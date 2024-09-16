<?php

namespace App\Http\Controllers\admin;

use App\Models\Customers;
use App\Models\Profile;
use App\Models\PhoneAreaCodes;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->privilege == 1)
            $customers = Customers::select('id', 'name', 'surname', 'area_code', 'phone', 'email')->where('user_id', '=', Auth::id())->distinct()->get();
        else
            $customers = Customers::select('id', 'name', 'surname', 'area_code', 'phone', 'email')->where('user_res', '=', Auth::id())->distinct()->get();

        $letters = array();
        foreach($customers as $customer)
        {
            $first_letter = mb_substr($customer->surname, 0, 1);

            if(is_numeric($first_letter))
            {
                $first_letter = '#';
            }

            if(strlen($first_letter)) {
                $letters[$first_letter][] = array(
                    'id' => $customer->id,
                    'name'=> $customer->name,
                    'surname' => $customer->surname,
                    'area_code' => $customer->area_code,
                    'phone' => $customer->phone,
                    'email' => $customer->email
                );
            }

        }

        uksort($letters, array($this,'compareASCII'));

        return view('admin.customers.index', ['customer_count' => $customers->count(), 'customers' => $letters]);
    }

    public function AjaxSearch(Request $request)
    {

        if(Auth::user()->privilege == 1) {
            $customers = Customers::select('id', 'name', 'surname', 'area_code', 'phone', 'email')
            ->where('user_id', '=', Auth::id());
        }
        else {
            $customers = Customers::select('id', 'name', 'surname', 'area_code', 'phone', 'email')
            ->where('user_res', '=', Auth::id());
        }

        if(strlen($request->search_term))
        $customers = $customers->whereRaw("MATCH (name, surname) AGAINST (? IN BOOLEAN MODE)", Helpers::fullTextWildcards($request->search_term));

        $customers = $customers->distinct()->get();


        $letters = array();

        if($customers)
        {
            foreach($customers as $customer)
            {

                $first_letter = mb_substr($customer->surname, 0, 1);

                if(is_numeric($first_letter))
                {
                    $first_letter = '#';
                }

                if(strlen($first_letter)) {
                    $letters[$first_letter][] = array(
                        'id' => $customer->id,
                        'name'=> $customer->name,
                        'surname' => $customer->surname,
                        'area_code' => $customer->area_code,
                        'phone' => $customer->phone,
                        'email' => $customer->email
                    );
                }

            }

        }



        uksort($letters, array($this,'compareASCII'));
        return response()->json($letters);


    }
    private static function compareASCII($a, $b) {
        $at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
        $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);
        return strcmp($at, $bt);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area_codes = PhoneAreaCodes::get();

        return view('admin.customers.add', [
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|min:3|max:255',
            'area_code' => 'required|integer',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/customers/add')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        if($this->PhoneExists($request->input('area_code'), $request->input('phone')))
            return back()->withInput()->withErrors(['msg' => 'Telefone já existe na sua base de dados.']);


        if(Auth::user()->privilege == 2) {
            $user_res = Auth::user()->member;
        } else {
            $user_res = Auth::id();
        }

        $customer = new Customers();
        $customer->user_res = $user_res;
        $customer->user_id = Auth::id();
        $customer->name = Helpers::mb_ucfirst($request->input('name'));
        $customer->surname = Helpers::mb_ucfirst($request->input('surname'));
        $customer->area_code = (int)$request->input('area_code');
        $customer->phone = (int)str_replace(" ", "", $request->input('phone'));
        $customer->email = $request->input('email');
        $customer->save();

        return redirect('/admin/customers');

    }

    private function PhoneExists($area_code, $number) {

        $code = (int)$area_code;
        $phone = (int)str_replace(" ", "", $number);

        $customers = Customers::where(
            [
                ['user_id', '=', Auth::id()],
                ['area_code', '=', $code],
                ['phone', '=', $phone]
            ]
        )->first();

        return $customers ? true : false;
    }
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'area_code' => 'required|integer',
            'phone' => 'required|string|min:3|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        if($this->PhoneExists($request->input('area_code'), $request->input('phone')))
            return response()->json(['phone_number' => ['Telefone já existe na sua base de dados.']], 422);

        if ($validator->fails()) {
                return response()->json($validator->messages(), 422);
        }

        if(Auth::user()->privilege == 2) {
            $user_res = Auth::user()->member;
        } else {
            $user_res = Auth::id();
        }

        $customer = new Customers();
        $customer->user_res = $user_res;
        $customer->user_id = Auth::id();
        $customer->name = Helpers::mb_ucfirst($request->input('name'));
        $customer->surname = Helpers::mb_ucfirst($request->input('surname'));
        $customer->area_code = (int)$request->input('area_code');
        $customer->phone = (int)str_replace(" ", "", $request->input('phone'));
        $customer->email = $request->input('email');
        $customer->save();


        return response()->json(array('success' => true, 'msg' => 'Cliente adicionado com sucesso.', 'customer_id' => $customer->id), 200);

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
    public function edit(Customers $customers, Request $request)
    {
        if(Auth::user()->privilege == 2) {

            $customer = Customers::where('id', '=', $request->id)->where('user', '=', Auth::id())->firstOrFail();

        } else {
            $customer = Customers::where('id', '=', $request->id)->where('user_res', '=', Auth::id())->firstOrFail();
        }

        return view('admin.customers.edit', [
            'customer' => $customer
        ]);

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/customers/edit/' . $request->id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        if(Auth::user()->privilege == 2) {

            $customer = Customers::where('id', '=', $request->id)->where('user_res', '=', Auth::id())->firstOrFail();

        } else {
            $customer = Customers::where('id', '=', $request->id)->where('user_id', '=', Auth::id())->firstOrFail();
        }

        $customer->name = $request->input('name');
        $customer->surname = $request->input('surname');
        $customer->email = $request->input('email');
        $customer->save();

        return redirect('/admin/customers');
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
