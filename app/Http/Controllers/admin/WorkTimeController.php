<?php

namespace App\Http\Controllers\admin;

use App\Models\WorkTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;

class WorkTimeController extends Controller
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
                ['user_id', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $id],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();

        $now = new \DateTime();
        $work_times = WorkTime::where('user_id', '=', $id)->where('date_to', '>=', $now->format('Y-m-d'))->get();

        foreach($work_times as $key=>$time)
        {
            $date_from = \DateTime::createFromFormat('Y-m-d', $time->date_from);
            $work_times[$key]->date_from = $date_from->format('d.m.y');

            $date_to = \DateTime::createFromFormat('Y-m-d', $time->date_to);
            $work_times[$key]->date_to = $date_to->format('d.m.y');

            $time_from = \DateTime::createFromFormat('H:i:s', $time->time_from);
            $work_times[$key]->time_from = $time_from->format('H:i');

            $time_to = \DateTime::createFromFormat('H:i:s', $time->time_to);
            $work_times[$key]->time_to = $time_to->format('H:i');

            if($time->lunch_from) {
                $lunch_from = \DateTime::createFromFormat('H:i:s', $time->lunch_from);
                $work_times[$key]->lunch_from = $lunch_from->format('H:i');

                $lunch_to = \DateTime::createFromFormat('H:i:s', $time->lunch_to);
                $work_times[$key]->lunch_to = $lunch_to->format('H:i');
            }
        }

        return view('admin.schedule.work_time.index', ['user_id' => $member, 'work_times' => $work_times]);
    }

    public function generate($id)
    {
        $member = Profile::where(
            [
                ['id', '=', $id],
                ['user_id', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $id],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();



        return view('admin.schedule.work_time.generate', ['user_id' => $member]);
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
                ['user_id', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $id],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();


        $user = NUll;
        $employee_id = NUll;

        if($member->privilege == 1){
            $user = $member->id;
        }

        if($member->privilege == 2){
            $user = $member->member;
            $employee_id = $member->id;
        }

        // echo "<pre>";
        // print_r($member);
        // echo "</pre>";
        // exit();



        $validator = Validator::make($request->all(), [
            'date_from' => 'required|after_or_equal:today|date_format:d.m.Y',
            'date_to' => 'required|date_format:d.m.Y|after_or_equal:date_from',
            'time_from' => 'required|date_format:H:i|before:time_to',
            'time_to' => 'required|date_format:H:i|after:time_from',
            'lunch_from' => 'nullable|date_format:H:i|before:lunch_to',
            'lunch_to' => 'nullable|date_format:H:i|after:lunch_from',
        ]);


        if ($validator->fails()) {
            return redirect('/admin/schedule/work-time/' . $id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

        $date_from = \DateTime::createFromFormat('d.m.Y', $request->input('date_from'));
        $startTime = $date_from->format('Y-m-d');

        $date_to = \DateTime::createFromFormat('d.m.Y', $request->input('date_to'));
        $endTime = $date_to->format('Y-m-d');

        $count = $this->checkIfExists($startTime, $endTime, $id);

        if($count)
            return back()->withInput()->withErrors(['msg' => 'The period you have entered overlaps with the period allready in the database.']);


        if(!$count)
        {
            $work_time = new WorkTime();
            $work_time->user_id = $user;
            $work_time->employee_id = $employee_id;
            $work_time->date_from = $startTime;
            $work_time->date_to = $endTime;
            $work_time->time_from = $request->input('time_from');
            $work_time->time_to = $request->input('time_to');
            $work_time->lunch_from = $request->input('lunch_from');
            $work_time->lunch_to = $request->input('lunch_to');
            $work_time->save();

            return redirect('/admin/schedule/work-time/' . $id)->with('status', 'Horário de trabalho adicionado!');
        }
    }

    public function generateStore(Request $request)
    {
        $id = $request->input('id');

        $member = Profile::where(
            [
                ['id', '=', $id],
                ['user_id', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $id],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();


        $validator = Validator::make($request->all(), [
            'date_from' => 'required|after_or_equal:today|date_format:d.m.Y',
            /* Monday */
            'mon_time_from' => 'nullable|date_format:H:i|before:mon_time_to',
            'mon_time_to' => 'nullable|date_format:H:i|after:mon_time_from',
            'mon_lunch_from' => 'nullable|date_format:H:i|before:mon_lunch_to',
            'mon_lunch_to' => 'nullable|date_format:H:i|after:mon_lunch_from',
            /* Tuesday */
            'tue_time_from' => 'nullable|date_format:H:i|before:tue_time_to',
            'tue_time_to' => 'nullable|date_format:H:i|after:tue_time_from',
            'tue_lunch_from' => 'nullable|date_format:H:i|before:tue_lunch_to',
            'tue_lunch_to' => 'nullable|date_format:H:i|after:tue_lunch_from',
            /* Wednesday */
            'wed_time_from' => 'nullable|date_format:H:i|before:wed_time_to',
            'wed_time_to' => 'nullable|date_format:H:i|after:wed_time_from',
            'wed_lunch_from' => 'nullable|date_format:H:i|before:wed_lunch_to',
            'wed_lunch_to' => 'nullable|date_format:H:i|after:wed_lunch_from',
            /* Thursday */
            'thu_time_from' => 'nullable|date_format:H:i|before:thu_time_to',
            'thu_time_to' => 'nullable|date_format:H:i|after:thu_time_from',
            'thu_lunch_from' => 'nullable|date_format:H:i|before:thu_lunch_to',
            'thu_lunch_to' => 'nullable|date_format:H:i|after:thu_lunch_from',
            /* Friday */
            'fri_time_from' => 'nullable|date_format:H:i|before:fri_time_to',
            'fri_time_to' => 'nullable|date_format:H:i|after:fri_time_from',
            'fri_lunch_from' => 'nullable|date_format:H:i|before:fri_lunch_to',
            'fri_lunch_to' => 'nullable|date_format:H:i|after:fri_lunch_from',
            /* Saturday */
            'sat_time_from' => 'nullable|date_format:H:i|before:sat_time_to',
            'sat_time_to' => 'nullable|date_format:H:i|after:sat_time_from',
            'sat_lunch_from' => 'nullable|date_format:H:i|before:sat_lunch_to',
            'sat_lunch_to' => 'nullable|date_format:H:i|after:sat_lunch_from',
            /* Sunday */
            'sun_time_from' => 'nullable|date_format:H:i|before:sun_time_to',
            'sun_time_to' => 'nullable|date_format:H:i|after:sun_time_from',
            'sun_lunch_from' => 'nullable|date_format:H:i|before:sun_lunch_to',
            'sun_lunch_to' => 'nullable|date_format:H:i|after:sun_lunch_from',
        ]);


        if ($validator->fails()) {
            return redirect('/admin/schedule/generate/' . $id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        switch($request->input('repeat'))
        {
            case 1 : $int = 'P1W'; break;
            case 2 : $int = 'P2W'; break;
            case 3 : $int = 'P3W'; break;
            case 4 : $int = 'P1M'; break;
            case 5 : $int = 'P2M'; break;
            case 6 : $int = 'P3M'; break;
            case 7 : $int = 'P6M'; break;
            default :
                return back()->withInput()->withErrors(['msg' => 'Por favor selecione o período que será gerado']);
        }



        $date_from = \DateTime::createFromFormat('d.m.Y', $request->input('date_from'));
        $date_to = new \DateTime($date_from->format('Y-m-d'));
        $date_to->add(new \DateInterval($int));


        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($date_from, $interval, $date_to);

        foreach ($period as $dt) {

            $date_checked = $dt->format('Y-m-d');
            if($this->checkIfExists($date_checked, $date_checked, $id))
            {
                return back()->withInput()->withErrors(['msg' => 'O período para o qual você está gerando dias úteis se sobrepõe ao período já existente no banco de dados. Favor apagar o período adicionado no banco de dados ou alterar a data de início do período de geração.']);
            }
        }


        $insert = array();

        foreach ($period as $dt) {

            $date_in = $dt->format('Y-m-d');
            $res_date = new \DateTime($date_in);
            $underscore = strtolower($res_date->format('D'));

                if($request->input($underscore.'_time_from') !== null)
                {
                    $insert[] = array(
                        'user_id' => Auth::id(),
                        'employee_id' => $id,
                        'date_from' => $date_in,
                        'date_to' => $date_in,
                        'time_from' => $request->input($underscore.'_time_from'),
                        'time_to' => $request->input($underscore.'_time_to'),
                        'lunch_from' => $request->input($underscore.'_lunch_from'),
                        'lunch_to' => $request->input($underscore.'_lunch_to'),
                    );
                }

        }

        if(!empty($insert))
            WorkTime::insert($insert);

        return redirect('/admin/schedule/work-time/' . $id)->with('status', 'Horário de trabalho adicionado!');

    }

    private function checkIfExists($startTime, $endTime, $userId)
    {
        return WorkTime::where(function ($query) use ($startTime, $endTime) {
            $query->where(function ($query) use ($startTime, $endTime) {
                $query->where('date_from', '<=', $startTime)
                    ->where('date_to', '>=', $startTime);
            })->orWhere(function ($query) use ($startTime, $endTime) {
                $query->where('date_from', '<=', $endTime)
                    ->where('date_to', '>=', $endTime);
            })->orWhere(function ($query) use ($startTime, $endTime) {
                $query->where('date_from', '>=', $startTime)
                    ->where('date_to', '<=', $endTime);
            });
        })->where('user_id', '=', $userId)->count();
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
    public function edit(WorkTime $workTime, $user, $id)
    {
        $member = Profile::where(
            [
                ['id', '=', $user],
                ['user_id', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $user],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();

        $work_time = $workTime::findOrFail($id);

        $date_from = \DateTime::createFromFormat('Y-m-d', $work_time->date_from);
        $work_time->date_from = $date_from->format('d.m.Y');

        $date_to = \DateTime::createFromFormat('Y-m-d', $work_time->date_to);
        $work_time->date_to = $date_to->format('d.m.Y');

        $time_from = \DateTime::createFromFormat('H:i:s', $work_time->time_from);
        $work_time->time_from = $time_from->format('H:i');

        $time_to = \DateTime::createFromFormat('H:i:s', $work_time->time_to);
        $work_time->time_to = $time_to->format('H:i');

        if($work_time->lunch_from) {
            $lunch_from = \DateTime::createFromFormat('H:i:s', $work_time->lunch_from);
            $work_time->lunch_from = $lunch_from->format('H:i');

            $lunch_to = \DateTime::createFromFormat('H:i:s', $work_time->lunch_to);
            $work_time->lunch_to = $lunch_to->format('H:i');
        }

        return view('admin.schedule.work_time.edit', ['user_id' => $member, 'worktime' => $work_time]);
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
        $user = $request->input('user');
        $id = $request->input('id');

        $member = Profile::where(
            [
                ['id', '=', $user],
                ['user_id', '=', Auth::id()]
            ]
        )->orWhere(
            [
                ['id', '=', $user],
                ['id', '=', Auth::id()]
            ]
        )->firstOrFail();

        $work_time = $workTime::findOrFail($id);


        $validator = Validator::make($request->all(), [
            'time_from' => 'required|date_format:H:i|before:time_to',
            'time_to' => 'required|date_format:H:i|after:time_from',
            'lunch_from' => 'nullable|date_format:H:i|before:lunch_to',
            'lunch_to' => 'nullable|date_format:H:i|after:lunch_from',
        ]);


        if ($validator->fails()) {
            return redirect('/admin/schedule/work-time/' .$user. '/edit/' . $id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        $work_time->time_from = $request->input('time_from');
        $work_time->time_to = $request->input('time_to');
        $work_time->lunch_from = $request->input('lunch_from');
        $work_time->lunch_to = $request->input('lunch_to');
        $work_time->save();

        return redirect('/admin/schedule/work-time/' . $user)->with('status', 'Horário de trabalho atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkTime  $workTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkTime $workTime, Request $request)
    {
        $work_time = WorkTime::where(
            [
                ['user_id', '=', Auth::id()],
                ['id', '=', $request->input('id')]
            ]
        )->firstOrFail();

        $work_time->delete();

        return redirect('/admin/schedule/work-time/' . $request->input('user'));
    }

    public function confirmDelete(Request $request, $id, $user)
    {
        $work_time = WorkTime::where(
            [
                ['user_id', '=', Auth::id()],
                ['id', '=', $id]
            ]
        )->firstOrFail();

        $date_from = \DateTime::createFromFormat('Y-m-d', $work_time->date_from);
        $work_time->date_from = $date_from->format('d.m.Y');

        $date_to = \DateTime::createFromFormat('Y-m-d', $work_time->date_to);
        $work_time->date_to = $date_to->format('d.m.Y');

        return view('admin.schedule.work_time.delete', ['id' => $id, 'user' => $user, 'work_time' => $work_time]);
    }
}
