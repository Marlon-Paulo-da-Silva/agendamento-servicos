<?php

namespace App\Http\Controllers\admin;

use App\Models\WorkHours;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WorkHoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.work_hours.index');
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
     * @param  \App\WorkHours  $workHours
     * @return \Illuminate\Http\Response
     */
    public function show(WorkHours $workHours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkHours  $workHours
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkHours $workHours)
    {
        $WorkHours = WorkHours::where('user_id', '=', Auth::id())->first();

        $days = array(
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
            'sat',
            'sun'
        );

        if(empty($WorkHours)) {
            $WorkHours = new \stdClass();

            foreach($days as $day)
            {
                $from = $day.'_from';
                $to = $day.'_to';
                $closed = $day.'_closed';

                $WorkHours->$from = '';
                $WorkHours->$to = '';
                $WorkHours->$closed = null;

            }

        }

        foreach($days as $day)
        {
            $from = $day.'_from';
            $to = $day.'_to';

            if($WorkHours->$from)
            {
                $date_from = \DateTime::createFromFormat('H:i:s', $WorkHours->$from);
                $WorkHours->$from = $date_from->format('H:i');
            }
            if($WorkHours->$to)
            {
                $date_to = \DateTime::createFromFormat('H:i:s', $WorkHours->$to);
                $WorkHours->$to = $date_to->format('H:i');
            }
        }



        return view('admin.work_hours.salon.index', ["data"=>$WorkHours]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkHours  $workHours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkHours $workHours)
    {

        $validator = Validator::make($request->all(), [
            'mon_from' => 'nullable|date_format:H:i',
            'mon_to' => 'nullable|date_format:H:i|after:mon_from',
            'tue_from' => 'nullable|date_format:H:i',
            'tue_to' => 'nullable|date_format:H:i|after:tue_from',
            'wed_from' => 'nullable|date_format:H:i',
            'wed_to' => 'nullable|date_format:H:i|after:wed_from',
            'thu_from' => 'nullable|date_format:H:i',
            'thu_to' => 'nullable|date_format:H:i|after:thu_from',
            'fri_from' => 'nullable|date_format:H:i',
            'fri_to' => 'nullable|date_format:H:i|after:fri_from',
            'sat_from' => 'nullable|date_format:H:i',
            'sat_to' => 'nullable|date_format:H:i|after:sat_from',
            'sun_from' => 'nullable|date_format:H:i',
            'sun_to' => 'nullable|date_format:H:i|after:sun_from'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/salon-work-hours')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        $WorkHours = WorkHours::where('user_id', '=', Auth::id())->first();

        $days = array(
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
            'sat',
            'sun'
        );

        if(empty($WorkHours)) {
            $new = new WorkHours;
            $new->user_id = Auth::id();

            foreach($days as $day)
            {
                $from = $day.'_from';
                $to = $day.'_to';
                $closed = $day.'_closed';

                $new->$from = $request->input($from);
                $new->$to = $request->input($to);
                $new->$closed = $request->input($closed);

            }
            $new->save();
        } else {
            foreach($days as $day)
            {
                $from = $day.'_from';
                $to = $day.'_to';
                $closed = $day.'_closed';

                $WorkHours->$from = $request->input($from);
                $WorkHours->$to = $request->input($to);
                $WorkHours->$closed = $request->input($closed);

            }
            $WorkHours->save();
        }


        return redirect('/admin/salon-work-hours')->with('status', 'Horário de trabalho atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkHours  $workHours
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkHours $workHours)
    {
        //
    }
}
