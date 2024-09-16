<?php

namespace App\Http\Controllers\admin;

use App\Models\ServicesCategories;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServicesCategoriesController extends Controller
{
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
            $cats[] = array(
                'id' => $cat->id,
                'title' => $cat->title,
                'num' => Services::where(
                    [
                        ['user_id', '=', Auth::id()],
                        ['category', '=', $cat->id]
                    ]
                )->get()->count()
            );
        }

        return view('admin.services_categories.index', [
            'categories'=>$cats
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services_categories.add');
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
            'category' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/services-categories/add')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $category = new ServicesCategories();
        $category->user_id = Auth::id();
        $category->title = $request->input('category');
        $category->save();

        return redirect('/admin/services-categories');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServicesCategories  $servicesCategories
     * @return \Illuminate\Http\Response
     */
    public function show(ServicesCategories $servicesCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServicesCategories  $servicesCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicesCategories $servicesCategories, $id)
    {
        $category = ServicesCategories::where('user_id', '=', Auth::id())->findOrFail($id);
        return view('admin.services_categories.edit', ['category' => $category, 'id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServicesCategories  $servicesCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicesCategories $servicesCategories, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/services-categories/edit/' . $id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        $category = ServicesCategories::where('user_id', '=', Auth::id())->findOrFail($id);
        $category->title = $request->input('category');
        $category->save();

        return redirect('/admin/services-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServicesCategories  $servicesCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicesCategories $servicesCategories, Request $request)
    {
        $num = Services::where(
            [
                ['user_id', '=', Auth::id()],
                ['category', '=', $request->input('category')]
            ]
        )->get()->count();

        if($num)
            abort(403);

        $category = ServicesCategories::where(
            [
                ['id', '=', $request->input('category')],
                ['user_id', '=', Auth::id()]
            ]
        )->firstOrFail();

        $category->delete();

        return redirect('/admin/services-categories');


    }

    public function confirmDelete(Request $request)
    {

        $num = Services::where(
            [
                ['user_id', '=', Auth::id()],
                ['category', '=', $request->id]
            ]
        )->get()->count();

        if($num)
            abort(403);

        $category = ServicesCategories::where(
            [
                ['id', '=', $request->id],
                ['user_id', '=', Auth::id()]
            ]
        )->firstOrFail();

        return view('admin.services_categories.delete', ['category' => $category]);
    }
}
