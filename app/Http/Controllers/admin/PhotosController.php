<?php

namespace App\Http\Controllers\admin;

use App\Models\Photos;
use App\Models\Profile;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class PhotosController extends Controller
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
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function show(Photos $photos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function edit(Photos $photos)
    {
        $photos = Photos::where('user_id', '=', Helpers::GetAdmin())->first();

        if(empty($photos)) {
            $photos = new \stdClass();
            $photos->photo_1 = '';
            $photos->photo_2 = '';
            $photos->photo_3 = '';
            $photos->photo_4 = '';
            $photos->photo_5 = '';
            $photos->photo_6 = '';
            $photos->photo_7 = '';
            $photos->photo_8 = '';
            $photos->photo_9 = '';
            $photos->photo_10 = '';

        }

        return view('admin.photos.index', ["data"=>$photos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photos $photos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photos $photos, Request $request)
    {


        $id = $request->input('id');
        $photo = 'photo_'.$id;
        $query = Photos::where('user_id', '=', Helpers::GetAdmin());
        $files = $query->first();

        $response = false;

        if($files)
        {
            $image_path = public_path().'/images/website_photos/'.$files->$photo;
            $delete = File::delete($image_path);

            if($delete)
            {
                $query_photo = $query->first();
                $query_photo->$photo = null;
                $query_photo->save();
                $response = true;
            }

        }

        if($response)
        {

            return response()->json(array('success' => true, 'msg' => 'Success'), 200);
        }
        else
        {
            return response()->json(array('success' => false, 'msg' => 'Failed'), 422);
        }

    }

    public function ImageUpload(Request $request)
    {


            $this->validate($request, [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:3048',
            ]);

            $name = 'photo';

            if ($request->hasFile($name)) {

                $image = $request->file($name);
                $image_name = sha1(microtime()).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/website_photos');
                $image->move($destinationPath, $image_name);


                $photos = Photos::where('user_id', '=',Helpers::GetAdmin())->first();
                $r = 'photo_'.$request->id;

                if(empty($photos)) {
                    $new = new Photos;
                    $new->user_id = Helpers::GetAdmin();
                    $new->$r = $image_name;
                    $new->save();
                } else {
                    $photos->$r = $image_name;
                    $photos->save();
                }

                echo $image_name;

            } else {
                echo 'invalid';
            }

    }
}
