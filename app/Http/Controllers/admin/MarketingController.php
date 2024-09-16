<?php

namespace App\Http\Controllers\admin;

use App\Models\SmsMarketing;
use App\Models\SmsMarketingSend;
use App\Models\PhoneAreaCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsSettings;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $campaigns_count = SmsMarketing::select(DB::raw('count(id) as ct'))->where('site', '=', Auth::id())->first();

        $sending_sms = SmsMarketingSend::select(DB::raw('count(sms_marketing_send_status.id) as ct'))
        ->leftJoin('sms_marketing', 'sms_marketing.id', '=', 'sms_marketing_send_status.campaign')
        ->where(
            [
                ['sms_marketing_send_status.site', '=', Auth::id()]
            ]
        )
        ->whereNotNull('sms_marketing.enabled')
        ->whereNull('sms_marketing_send_status.sent')
        ->first();

        $sms_sent_count = SmsMarketingSend::select(DB::raw('count(id) as ct'))
        ->where(
            [
                ['site', '=', Auth::id()]
            ]
        )
        ->whereNotNull('sent')
        ->first();

        $settings = SmsSettings::where('site', '=', Auth::id())->first();

        if(!$settings)
        {
            $alert = true;

        } else {

            $alert = false;
        }

        return view('admin.marketing.index', [
            'alert' => $alert,
            'sending_sms' => $sending_sms,
            'campaigns_count' => $campaigns_count,
            'sms_sent_count' => $sms_sent_count
        ]);
    }

    public function enableCampaign(Request $request)
    {

        $settings = SmsMarketing::where('site', '=', Auth::id())->where('id', '=', $request->id)->first();

        if(!$settings)
            return response()->json(array('success' => false), 422);

        if($request->input('status'))
            $settings->enabled = 1;
        else
            $settings->enabled = null;

        $settings->save();

        return response()->json(array('success' => true), 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area_codes = PhoneAreaCodes::get();

        return view('admin.marketing.create', [
            'area_codes' => $area_codes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'marketing_area_code' => 'required|integer',
            'marketing_title' => 'required|string|max:255',
            'marketing_msg' => 'required|string|max:600'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/marketing/new')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $site = Auth::id();

        $sms_marketing = new SmsMarketing();
        $sms_marketing->site = $site;
        $sms_marketing->title = $request->input('marketing_title');
        $sms_marketing->message = $request->input('marketing_msg');
        $sms_marketing->area_code = $request->input('marketing_area_code');

        $datetime = new \DateTime();
        $sms_marketing->created_at = $datetime->format('Y-m-d H:i:s');

        $sms_marketing->save();

        $customers = Customers::select(DB::raw('DISTINCT(phone), id'))
        ->where(
            [
                ['company', '=', Auth::id()],
                ['area_code', '=', (int)$request->input('marketing_area_code')]
            ]
        )->get();

        $data = array();
        foreach($customers as $customer)
        {
            $data[] = array(
                'site' => $site,
                'campaign' => $sms_marketing->id,
                'customer' => $customer->id
            );
        }

        SmsMarketingSend::insert($data);

        return redirect('/admin/marketing/list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function show(SmsMarketing $marketing)
    {
        //
    }

    public function editItem(SmsMarketing $marketing, Request $request)
    {
        $campaign = SmsMarketing::where('site', '=', Auth::id())->where('id', '=', $request->id)->firstOrFail();

        return view('admin.marketing.edit.edit', [
            'campaign' => $campaign,
            'id' => $request->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsMarketing $marketing)
    {
        $campaigns = SmsMarketing::where('site', '=', Auth::id())->orderBy('id', 'desc')->get();

        foreach($campaigns as $key=>$campaign)
        {
            $campaigns[$key]->sent = SmsMarketingSend::select(DB::raw('count(id) as ct'))->where('campaign', '=', $campaign->id)->whereNotNull('sent')->first()->ct;
            $campaigns[$key]->all = SmsMarketingSend::select(DB::raw('count(id) as ct'))->where('campaign', '=', $campaign->id)->first()->ct;
        }

        return view('admin.marketing.list', ['campaigns' => $campaigns]);
    }

    public function editList(SmsMarketing $marketing, Request $request)
    {
        $campaign = $marketing::where('site', '=', Auth::id())->where('id', '=', $request->id)->firstOrFail();

        return view('admin.marketing.edit_list', [
            'campaign' => $campaign
        ]);
    }

    public function confirmDelete(Request $request, $id)
    {
        $campaign = SmsMarketing::where(
            [
                ['site', '=', Auth::id()],
                ['id', '=', $id]
            ]
        )->firstOrFail();

        return view('admin.marketing.delete.delete', ['id' => $id, 'campaign' => $campaign]);
    }

    public function destroy(SmsMarketing $marketing, Request $request)
    {
        $campaign = SmsMarketing::where(
            [
                ['site', '=', Auth::id()],
                ['id', '=', $request->input('id')]
            ]
        )->firstOrFail();

        $campaign->delete();

        return redirect('/admin/marketing/list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsMarketing $marketing)
    {
        $validator = Validator::make($request->all(), [
            'marketing_title' => 'required|string|max:255',
            'marketing_msg' => 'required|string|max:600'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/marketing/edit-item/' . $request->id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $campaign = SmsMarketing::where('site', '=', Auth::id())->where('id', '=', $request->id)->firstOrFail();
        $campaign->title = $request->input('marketing_title');
        $campaign->message = $request->input('marketing_msg');
        $campaign->save();

        return redirect('/admin/marketing/edit/'.$request->id);
    }

}
