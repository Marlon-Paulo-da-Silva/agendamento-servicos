<?php

namespace App\Http\Controllers\admin;
use App\Models\Websites;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Websites  $websites
     * @return \Illuminate\Http\Response
     */
    public function show(Websites $websites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Websites $websites)
    {
        $website = Websites::where('user_id', '=', Auth::id())->first();

        if(empty($website)) {
            $website = new \stdClass();
            $website->title = '';
            $website->address = '';
            $website->color = 4;
            $website->logo = '';
            $website->font = 1;
            $website->facebook = '';
            $website->twitter = '';
            $website->instagram = '';

        }

        return view('admin.website.index', ["data"=>$website]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Websites $websites)
    {
        $website = Websites::where('user_id', '=', Auth::id())->first();

        if(empty($website)) {
            $new = new Websites;
            $new->site = Auth::id();
            $new->title = $request->input('title');
            $new->address = $request->input('address');
            $new->color = $request->input('color');
            $new->facebook = $request->input('facebook');
            $new->twitter = $request->input('twitter');
            $new->instagram = $request->input('instagram');
            $new->save();
        } else {
            $website->title = $request->input('title');
            $website->address = $request->input('address');
            $website->color = $request->input('color');
            $website->facebook = $request->input('facebook');
            $website->twitter = $request->input('twitter');
            $website->instagram = $request->input('instagram');
            $website->save();
        }


        return redirect('/admin/website')->with('status', 'Website updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Websites  $websites
     * @return \Illuminate\Http\Response
     */
    public function destroy(Websites $websites)
    {
        //
    }

    public function ImageUpload(Request $request)
    {

            $this->validate($request, [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $name = 'photo';

            if ($request->hasFile($name)) {

                $image = $request->file($name);
                $image_name = sha1(microtime()).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/logos');
                $image->move($destinationPath, $image_name);


                $website = Websites::where('user_id', '=', Auth::id())->first();

                if(empty($website)) {
                    $new = new Websites;
                    $new->site = Auth::id();
                    $new->logo = $image_name;
                    $new->save();
                } else {
                    $website->logo = $image_name;
                    $website->save();
                }

                echo $image_name;

            } else {
                echo 'invalid';
            }

    }
}
