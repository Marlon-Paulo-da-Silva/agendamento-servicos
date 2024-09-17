<?php

namespace App\Http\Controllers\admin;

use App\Models\SmsSettings;
use App\Models\Reservations;
use App\Models\SmsSendStatus;
use App\Models\SmsMarketingSend;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
// use Twilio\Rest\Client;
use App\Helpers\Helpers;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings_exist = SmsSettings::where('user_id', '=', Auth::id())->first();

        if(!$settings_exist)
        {
            $sms_settings = new SmsSettings();
            $sms_settings->site = Auth::id();
            $sms_settings->save();
        }

        $settings_exist = SmsSettings::where('user_id', '=', Auth::id())->first();

        $endpoint = "https://api.twilio.com/2010-04-01/Accounts/$settings_exist->account_sid/Balance.json";

        try {
            $client = new GuzzleClient();
            $response = $client->get($endpoint, [
                'auth' => [
                    $settings_exist->account_sid,
                    $settings_exist->auth_token
                ]
                ]);
                $php_response = json_decode($response->getBody());

        } catch(RequestException $e)
        {
            $php_response = new \stdClass();
            $php_response->balance = 0;
            $php_response->currency = 'USD';
        }

        $settings = Settings::where('user_id', '=', Auth::id())->first();

        if(!$settings)
        {
            $settings = new \StdClass();
            $settings->currency_format = 1;
        }

        return view('admin.sms.index', [
            'settings' => $settings_exist,
            'response' => $php_response,
            'info' => $settings
        ]);
    }

    public function settings(Request $request)
    {
        $settings = SmsSettings::where('user_id', '=', Auth::id())->first();

        return view('admin.sms.settings', [
            'settings' => $settings,
            'domain' => $request->getSchemeAndHttpHost()
        ]);
    }

    public function updateSettings(Request $request)
    {
        $settings = SmsSettings::where('user_id', '=', Auth::id())->first();
        $settings->account_sid = $request->input('account_sid');
        $settings->auth_token = $request->input('auth_token');
        $settings->number = $request->input('number');
        $settings->save();

        return redirect('/admin/sms/settings')->with('status', 'Settings updated!');
    }

    public function enable(Request $request)
    {

        $settings = SmsSettings::where('user_id', '=', Auth::id())->first();

        if($request->input('status'))
            $settings->enabled = 1;
        else
            $settings->enabled = null;

        $settings->save();

        return response()->json(array('success' => true), 200);

    }

    public function notify(Request $request)
    {

        $settings = SmsSettings::where('user_id', '=', Auth::id())->first();

        switch($request->input('notify'))
        {
            case 1: $notify = 15; break;
            case 2: $notify = 30; break;
            case 3: $notify = 45; break;
            case 4: $notify = 60; break;
            case 5: $notify = 120; break;
            default: $notify = 60;
        }

        $settings->notify = $notify;

        $settings->save();

        return response()->json(array('success' => true), 200);

    }

    public function send()
    {
        $this->sendSms();
        $this->sendMarketing();
    }

    public function sendMarketing()
    {
        $settings_exist = SmsSettings::where('user_id', '=', 1)->first();

        if(!$settings_exist OR !$settings_exist->enabled)
        {
            return false;
        }

        $sms_marketing = SmsMarketingSend::select('sms_marketing_send_status.id', 'customers.phone', 'customers.area_code', 'sms_marketing.message', 'sms_marketing.site')
            ->leftJoin('sms_marketing', 'sms_marketing.id', '=', 'sms_marketing_send_status.campaign')
            ->leftJoin('customers', 'customers.id', '=', 'sms_marketing_send_status.customer')
            ->whereNotNull('sms_marketing.enabled')
            ->whereNull('sms_marketing_send_status.sent')
            ->get();

        // TODO trocar depois não utilizará TWILIO
        $twilio = new \stdClass();
        // $twilio = new Client($settings_exist->account_sid, $settings_exist->auth_token);

        foreach($sms_marketing as $sms)
        {
                try {

                    $message = $twilio
                    ->messages
                        ->create(
                            "+".$sms->area_code.$sms->phone, // to
                            ["body" => $sms->message, "from" => $settings_exist->number]
                        );

                // set status as sent
                $status = SmsMarketingSend::where('id', '=', $sms->id)->first();
                $status->sent = 1;
                $status->save();

                set_time_limit(180);

                } catch(\Twilio\Exceptions\RestException $e)
                {
                    // do nothing
                }

        }
    }

    private function sendSms()
    {
        $settings_exist = SmsSettings::where('user_id', '=', 1)->first();

        $settings = Settings::where('user_id', '=', 1)->first();

        if(empty($settings)) {
            $settings = new \stdClass();
            $settings->time_format = 1;
        }

        $reservations = Reservations::
            select('reservations.id', 'settings.company', 'reservations.site', 'reservations.service', 'reservations.start', 'customers.area_code', 'customers.phone')
            ->leftJoin('sms_settings', 'reservations.site', '=', 'sms_settings.site')
            ->leftJoin('customers', 'reservations.customer', '=', 'customers.id')
            ->leftJoin('sms_send_status', 'sms_send_status.reservation', '=', 'reservations.id')
            ->leftJoin('settings', 'settings.site', '=', 'reservations.site')
            ->whereNull('sms_send_status.reservation')
            ->get();

        // TODO trocar depois não utilizará TWILIO
        $twilio = new \stdClass();
        // $twilio = new Client($settings_exist->account_sid, $settings_exist->auth_token);

        foreach($reservations as $reservation)
        {

            $notify = !$settings_exist ? 60 : $settings_exist->notify;

            $reservation_time = new \DateTime($reservation->start);
            $tomorrow = new \DateTime();
            $interval = new \DateInterval('PT'.$notify.'M');
            $tomorrow->add($interval);

            if($tomorrow >= $reservation_time)
            {

                $body = 'Dont forget on ' . $reservation->service . ' at ' . ($settings->time_format == 1 ? $reservation_time->format('h:ia') : $reservation_time->format('H:i')) . '.';

                try {

                    if($settings_exist && $settings_exist->enabled) {

                    $message = $twilio
                    ->messages
                        ->create(
                            "+".$reservation->area_code.$reservation->phone, // to
                            ["body" => $body, "from" => $settings_exist->number]
                        );

                    }

                } catch(\Twilio\Exceptions\RestException $e)
                {
                    // do nothing
                }

                // set status as sent
                $sms = new SmsSendStatus();
                $sms->reservation = $reservation->id;
                $sms->save();

                set_time_limit(180);
            }

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function show(SmsSettings $sms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsSettings $sms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsSettings $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsSettings $sms)
    {
        //
    }
}
