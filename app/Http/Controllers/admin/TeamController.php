<?php

namespace App\Http\Controllers\admin;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Profile::where('member', '=', Auth::id())->get();

        return view('admin.team.index', ['members' => $team]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('admin.team.add', ["email" => $request->input('email')]);
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
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255'
        ]);

        $validator_email = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users'
        ]);

        if ($validator_email->fails()) {
            return redirect('/admin/team')
                        ->withErrors($validator_email)
                        ->withInput($request->all());
        }

        if ($validator->fails()) {
            return redirect('/admin/team/member/add')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $user = new Profile();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->privilege = 2;
        $user->member = Auth::id();
        $user->save();

        return redirect('/admin/team');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroyConfirm(Request $request)
    {
        $user = Profile::where(
            [
                ['id', '=', $request->id],
                ['privilege', '=', 2],
                ['member', '=', Auth::id()]
            ]
        )->firstOrFail();

        return view('admin.team.delete', ['user' => $user]);
    }
    public function destroy(Request $request)
    {
        $user = Profile::where(
            [
                ['id', '=', $request->input('user')],
                ['privilege', '=', 2],
                ['member', '=', Auth::id()]
            ]
        )->firstOrFail();

        $user->delete();

        return redirect('/admin/team');
    }
}
