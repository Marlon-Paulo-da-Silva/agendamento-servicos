<?php

namespace App\Http\Controllers\admin;

use App\Models\Services;
use App\Models\Settings;
use App\Helpers\Helpers;
use App\Models\ServicesCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
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
        $categories = ServicesCategories::where('user_id', '=', Auth::id())->get();

        $cats = array();

        foreach($categories as $cat)
        {
            $services = Services::where(
                [
                    ['user_id', '=', Auth::id()],
                    ['category', '=', $cat->id]
                ]
            )->get();


            $cats[] = array(
                'title' => $cat->title,
                'services' => $services,
                'num' => $services->count()
            );
        }

        $settings = Settings::where('user_id', '=', Auth::id())->first();

        if(!$settings)
        {
            $settings = new \StdClass();
            $settings->currency_sign = '$';
            $settings->currency_format = 1;
        }

        return view('admin.services.index', [
            'categories'=>$cats,
            'info' => $settings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ServicesCategories::where('user_id', '=', Auth::id())->get();

        return view('admin.services.add', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = $request->validate([
        //     'category' => 'required|integer|exists:services_cat,id',
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string|max:255',
        //     'price' => 'required|string|max:8',
        //     'hours' => 'nullable|date_format:H',
        //     'minutes' => 'required|date_format:i'
        // ]);

        $validator = Validator::make($request->all(), [
            'category' => 'required|integer|exists:services_cat,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|string|max:8',
            'hours' => 'nullable|date_format:H',
            'minutes' => 'required|date_format:i'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/services/add')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        $service = new Services();
        $service->user_id = Auth::id();
        $service->category = (int)$request->input('category');
        $service->title = $request->input('title');
        $service->description = $request->input('description');
        $service->price = Helpers::fromMoney($request->input('price'));

        $hours = sprintf('%02d', (int)$request->input('hours'));
        $minutes = sprintf('%02d', (int)$request->input('minutes'));

        $service->duration = $hours.':'.$minutes.':00';
        $service->save();

        return redirect('/admin/services');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services, $id)
    {
        $service = Services::where('user_id', '=', Auth::id())->findOrFail($id);

        $hours = explode(':', $service->duration);
        $service->hours = $hours[0];
        $service->minutes = $hours[1];

        $categories = ServicesCategories::where('user_id', '=', Auth::id())->get();

        return view('admin.services.edit', ['service' => $service, 'categories' => $categories, 'id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|integer|exists:services_cat,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|string|max:8',
            'hours' => 'nullable|min:0|max:23',
            'minutes' => 'required|min:0|max:59'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/services/edit/' . $id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        $service = Services::where('user_id', '=', Auth::id())->findOrFail($id);
        $service->category = (int)$request->input('category');
        $service->title = $request->input('title');
        $service->description = $request->input('description');
        $service->price = Helpers::fromMoney($request->input('price'));

        $hours = sprintf('%02d', (int)$request->input('hours'));
        $minutes = sprintf('%02d', (int)$request->input('minutes'));

        $service->duration = $hours.':'.$minutes.':00';
        $service->save();

        return redirect('/admin/services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services, Request $request)
    {
        $service = Services::where(
            [
                ['id', '=', $request->input('service')],
                ['user_id', '=', Auth::id()]
            ]
        )->firstOrFail();

        $service->delete();

        return redirect('/admin/services');
    }

    public function confirmDelete(Request $request)
    {

        $service = Services::where(
            [
                ['id', '=', $request->id],
                ['user_id', '=', Auth::id()]
            ]
        )->firstOrFail();

        return view('admin.services.delete', ['service' => $service]);
    }
}
