<?php

namespace App\Http\Controllers\admin;

use App\Models\MyServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Models\ServicesCategories;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;

class MyServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_id = Helpers::GetMember();

        $categories = ServicesCategories::where('user_id', '=', $site_id)->get();

        $cats = array();

        foreach($categories as $cat)
        {
            $services = Services::where(
                [
                    ['user_id', '=', $site_id],
                    ['category', '=', $cat->id]
                ]
            )->get();

            $my_services = MyServices::where(
                [
                    ['user_id', '=', Auth::id()]
                ]
            )->get();

            $in_db = array();
            foreach($my_services as $ser)
            {
                $in_db[] = $ser->service;
            }

            foreach($services as $key=>$service)
            {
                $hours = explode(':', $service->duration);
                $services[$key]->hours = (int)$hours[0];
                $services[$key]->minutes = (int)$hours[1];
                $services[$key]->checked = in_array($service->id, $in_db) ? true : false;

            }


            $cats[] = array(
                'title' => $cat->title,
                'services' => $services,
                'num' => $services->count()
            );
        }

        return view('admin.my_services.index', ['categories'=>$cats]);
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
     * @param  \App\MyServices  $myServices
     * @return \Illuminate\Http\Response
     */
    public function show(MyServices $myServices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MyServices  $myServices
     * @return \Illuminate\Http\Response
     */
    public function edit(MyServices $myServices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MyServices  $myServices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyServices $myServices)
    {
        MyServices::where('user_res', Auth::id())->delete();

        $insert = array();
        $checked = $request->input('checked');

        if(!empty($checked))
        {
            foreach($checked as $checked_service)
            {
                $insert[] = array(
                    'user_id' => Helpers::GetAdmin(),
                    'user_res' => Helpers::GetMember(),
                    'service_id' => (int)$checked_service
                );
            }
        }

        if(!empty($insert))
            MyServices::insert($insert);

        return redirect('/admin/my-services')->with('status', 'Os Serviços que você oferece foram atualizados');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MyServices  $myServices
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyServices $myServices)
    {
        //
    }
}
