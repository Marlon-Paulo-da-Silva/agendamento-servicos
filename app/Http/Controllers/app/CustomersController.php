<?php

namespace App\Http\Controllers\app;

use App\Customers;
use App\Profile;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class CustomersController extends Controller
{
    public function __construct(Request $request)
    {
        $this->site_id = Helpers::GetSiteId($request->site);
    }
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_code' => 'required|integer',
            'phone' => 'required|string|min:3|max:255'
        ]);

        if ($validator->fails()) {
                return response()->json($validator->messages(), 422);
        }

        $customer_exists = $this->CustomerExists($request->input('area_code'), $request->input('phone'));
        if($customer_exists)
            return response()->json(array('success' => true, 'customer_id' => $customer_exists->id), 200);    
        
        
        return response()->json(['error' => ['Telefonska številka še ne obstaja.']], 418);


    }

    public function storeAjaxFull(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'area_code' => 'required|integer',
            'phone' => 'required|string|min:3|max:255',
            'email' => 'nullable|email|max:255',
            'user' => 'required|integer|exists:users,id'
        ]);

        $customer_exists = $this->CustomerExists($request->input('area_code'), $request->input('phone'));
        if($customer_exists)
            return response()->json(['phone_number' => ['Telefonska številka že obstaja v bazi.']], 422);

        if ($validator->fails()) {
                return response()->json($validator->messages(), 422);
        }

        $customer = new Customers();
        $customer->company = $this->site_id;
        $customer->user = $request->input('user');
        $customer->name = Helpers::mb_ucfirst($request->input('name'));
        $customer->surname = Helpers::mb_ucfirst($request->input('surname'));
        $customer->area_code = (int)$request->input('area_code');
        $customer->phone = (int)str_replace(" ", "", $request->input('phone'));
        $customer->email = $request->input('email');        
        $customer->save();


        return response()->json(array('success' => true, 'msg' => 'Stranka je bila dodana.', 'customer_id' => $customer->id), 200);

    }

    private function CustomerExists($area_code, $number) {

        $code = (int)$area_code;
        $phone = (int)str_replace(" ", "", $number);

        $customers = Customers::where(
            [
                ['company', '=', $this->site_id],
                ['area_code', '=', $code],
                ['phone', '=', $phone]
            ]
        )->first();

        return $customers;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit(Customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
    }
}
