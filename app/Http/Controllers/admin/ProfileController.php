<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\PhoneAreaCodes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        $area_codes = PhoneAreaCodes::get();

        return view('admin.profile.index', [
            'data'=>$user,
            'area_codes' => $area_codes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $profile = Profile::findOrFail(Auth::id());

        if($request->input('include_profile'))
        {
            $checkbox = 1;
        } else {
            $checkbox = null;
        }

        $profile->name = $request->input('name');
        $profile->surname = $request->input('surname');
        $profile->occupation = $request->input('occupation');
        $profile->area_code = (int)$request->input('area_code');
        $profile->include_profile = $checkbox;
        $profile->phone = (int)str_replace(' ', '', $request->input('phone'));
        $profile->about = $request->input('about');
        $profile->save();

        return redirect('/admin/profile')->with('status', 'Profile updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
                $destinationPath = public_path('/images/profile_images');
                $image->move($destinationPath, $image_name);


                $profile = Profile::find(Auth::id());
                $profile->profile_image = $image_name;
                $profile->save();

                echo $image_name;

            } else {
                echo 'invalid';
            }

    }

    public function changePassword(Request $request)
    {
        return view('admin.profile.change_password.index', []);
    }

    public function updatePassword(Request $request)
    {

        Validator::extend('old_password', function($attribute, $value, $parameters)
        {
            $profile = Profile::where('id', '=', Auth::id())->first();

            $password = $profile->password;

            if(Hash::check($value, $password)) {
                    return true;
            } else {
                return false;
            }
        });

        $validator = Validator::make($request->all(), [
            'profile_old_password' => 'required|string|old_password',
            'profile_new_password' => 'required|string|min:6|max:255|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/profile/change-password')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $profile = Profile::where('id', '=', Auth::id())->first();
        $profile->password = Hash::make($request->input('profile_new_password'));
        $profile->save();

        return redirect('/admin/profile/change-password')->with('status', 'Your password has been changed!');;
    }
}
