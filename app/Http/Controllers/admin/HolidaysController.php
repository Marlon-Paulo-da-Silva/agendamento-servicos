<?php

namespace App\Http\Controllers\admin;

use App\Models\Holidays;
use App\Models\WorkTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $now = new \DateTime();
        $holidays = Holidays::where('site', '=', Auth::id())->where('holiday', '>=', $now->format('Y-m-d'))->get();

        foreach($holidays as $key=>$date)
        {
            $holiday_date = \DateTime::createFromFormat('Y-m-d', $date->holiday);
            $holidays[$key]->holiday = $holiday_date->format('d.m.Y');
        }

        return view('admin.work_hours.holidays.index', ['holidays' => $holidays]);
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

        $validator = Validator::make($request->all(), [
            'holidays_date' => 'required|after_or_equal:today|date_format:d.m.Y'
        ]);


        if ($validator->fails()) {
            return redirect('/admin/holidays/')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $holidays_date = \DateTime::createFromFormat('d.m.Y', $request->input('holidays_date'));
        $holiday_date_format = $holidays_date->format('Y-m-d');

        $count = Holidays::whereDate('holiday', $holiday_date_format)->where('site', '=', Auth::id())->count();

        if($count)
            return back()->withInput()->withErrors(['msg' => 'The period you have entered overlaps with period allready in database.']);


        if(!$count)
        {
            $holidays = new Holidays();
            $holidays->site = Auth::id();
            $holidays->holiday = $holiday_date_format;
            $holidays->save();

            return redirect('/admin/holidays/')->with('status', 'Non-working day added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkTime  $workTime
     * @return \Illuminate\Http\Response
     */
    public function show(WorkTime $workTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkTime  $workTime
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkTime $workTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkTime  $workTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkTime $workTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkTime  $workTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holidays $holidays, Request $request)
    {
        $holiday = Holidays::where(
            [
                ['site', '=', Auth::id()],
                ['id', '=', $request->input('id')]
            ]
        )->firstOrFail();

        $holiday->delete();

        return redirect('/admin/holidays');
    }

    public function confirmDelete(Request $request, $id)
    {
        $holiday = Holidays::where(
            [
                ['site', '=', Auth::id()],
                ['id', '=', $id]
            ]
        )->firstOrFail();

        $date = \DateTime::createFromFormat('Y-m-d', $holiday->holiday);
        $holiday->holiday = $date->format('d.m.Y');

        return view('admin.work_hours.holidays.delete', ['id' => $id, 'holiday' => $holiday]);
    }
}
