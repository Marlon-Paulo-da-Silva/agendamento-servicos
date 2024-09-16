<?php

namespace App\Http\Controllers\admin;

use App\Models\Vacations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;


class VacationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $member = Profile::where(
            [
                ['id', '=', $id],
                ['member', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $id],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();

        $now = new \DateTime();
        $work_times = Vacations::where('user', '=', $id)->first();

        if($work_times)
        {

            $date_from = \DateTime::createFromFormat('d-m-Y', $work_times->date_from);
            $work_times->date_from = $date_from->format('d.m.Y');

            $date_to = \DateTime::createFromFormat('d-m-Y', $work_times->date_to);
            $work_times->date_to = $date_to->format('d.m.Y');

        } else {
            $work_times = new \stdClass();
            $work_times->date_from = '';
            $work_times->date_to = '';
        }
        return view('admin.schedule.vacations.index', ['member' => $member, 'work_times' => $work_times]);
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
        $id = $request->input('id');

        $member = Profile::where(
            [
                ['id', '=', $id],
                ['member', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $id],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();


        $validator = Validator::make($request->all(), [
            'date_from' => 'nullable|after_or_equal:today|date_format:d.m.Y',
            'date_to' => 'nullable|date_format:d.m.Y|after_or_equal:date_from',
        ]);


        if ($validator->fails()) {
            return redirect('/admin/schedule/vacations/' . $id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        if($request->input('date_from') && $request->input('date_to'))
        {
            $date_from = \DateTime::createFromFormat('d.m.Y', $request->input('date_from'));
            $startTime = $date_from->format('d-m-Y');

            $date_to = \DateTime::createFromFormat('d.m.Y', $request->input('date_to'));
            $endTime = $date_to->format('d-m-Y');
        }


        $lunch = Vacations::where('user', '=', $id)->first();

        if($lunch)
            $lunch->delete();

        if($request->input('date_from') && $request->input('date_to'))
        {
            $work_time = new Vacations();
            $work_time->site = Auth::id();
            $work_time->user = $id;
            $work_time->date_from = $startTime;
            $work_time->date_to = $endTime;
            $work_time->save();
        }


        return redirect('/admin/schedule/vacations/' . $id)->with('status', 'Vacations updated!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vacations  $Vacations
     * @return \Illuminate\Http\Response
     */
    public function show(Vacations $Vacations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacations  $Vacations
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacations $Vacations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vacations  $Vacations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacations $Vacations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacations  $Vacations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacations $Vacations, Request $request)
    {

    }

}
