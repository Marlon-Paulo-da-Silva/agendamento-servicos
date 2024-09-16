<?php

namespace App\Http\Controllers\admin;

use App\Models\Settings;
use App\Models\PhoneAreaCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        $settings = Settings::where('site', '=', Auth::id())->first();

        if(empty($settings)) {
            $settings = new \stdClass();
            $settings->company = '';
            $settings->address = '';
            $settings->city = '';
            $settings->zip = '';
            $settings->taxid = '';
            $settings->trr = '';
            $settings->site_phone = '';
            $settings->site_email = '';
            $settings->booking = 4;
            $settings->view = 1;
            $settings->mode = 1;
            $settings->slot_mode = 1;
            $settings->currency_sign = '$';
            $settings->area_code = 15;
            $settings->currency_format = 1;
            $settings->time_format = 1;

        }

        $area_codes = PhoneAreaCodes::get();

        return view('admin.settings.index', [
            'data'=>$settings,
            'area_codes' => $area_codes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        $settings = Settings::where('site', '=', Auth::id())->first();

        $booking = $this->FormatBooking($request->input('booking'));

        if(empty($settings)) {
            $new = new Settings;
            $new->site = Auth::id();
            $new->company = $request->input('company');
            $new->address = $request->input('address');
            $new->city = $request->input('city');
            $new->zip = $request->input('zip');
            $new->taxid = $request->input('taxid');
            $new->trr = $request->input('trr');
            $new->site_phone = $request->input('site_phone');
            $new->site_email = $request->input('site_email');
            $new->booking = $booking;
            $new->view = $request->input('view');
            $new->mode = $request->input('mode');
            $new->slot_mode = $request->input('slot_mode');
            $new->currency_sign = $request->input('currency_sign');
            $new->area_code = $request->input('area_code');
            $new->currency_format = $request->input('currency_format');
            $new->time_format = $request->input('time_format');
            $new->save();
        } else {
            $settings->company = $request->input('company');
            $settings->address = $request->input('address');
            $settings->city = $request->input('city');
            $settings->zip = $request->input('zip');
            $settings->taxid = $request->input('taxid');
            $settings->trr = $request->input('trr');
            $settings->site_phone = $request->input('site_phone');
            $settings->site_email = $request->input('site_email');
            $settings->booking = $booking;
            $settings->view = $request->input('view');
            $settings->mode = $request->input('mode');
            $settings->slot_mode = $request->input('slot_mode');
            $settings->currency_sign = $request->input('currency_sign');
            $settings->area_code = $request->input('area_code');
            $settings->currency_format = $request->input('currency_format');
            $settings->time_format = $request->input('time_format');
            $settings->save();
        }

        return redirect('/admin/settings')->with('status', 'Settings updated!');
    }
    private function FormatBooking($input) {
        switch($input) {
            case 1: return 1; break;
            case 2: return 2; break;
            case 3: return 3; break;
            case 4: return 4; break;
            case 5: return 5; break;
            case 6: return 6; break;
            case 7: return 7; break;
            default: return 1;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
