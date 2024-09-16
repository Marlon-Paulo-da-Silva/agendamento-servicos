<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Reservations;
use App\Models\WorkTime;
use App\Models\WorkHours;
use App\Models\Holidays;
use App\Models\Profile;
use App\Models\Vacations;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InsightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Today date
        $today = new \DateTime();
        $today_format = $today->format('Y-m-d');

        // Chart data
        $last_month = new \DateTime();
        $last_month->modify( '-1 month' );

        $last_month_reservations = Reservations::
            where('site', '=', Auth::id())
            ->whereDate('start', '>=', $last_month->format('Y-m-d'))
            ->whereDate('start', '<=', $today->format('Y-m-d'))
            ->orderBy('start', 'asc')
            ->get();

        $reservations_by_day = array();

        foreach($last_month_reservations as $res)
        {
            $res_date = new \DateTime($res->start);
            if(key_exists($res_date->format('D'), $reservations_by_day))
            {
                $reservations_by_day[$res_date->format('D')]++;
            } else {
                $reservations_by_day[$res_date->format('D')] = 1;
            }
        }

        if(empty($reservations_by_day))
            $reservations_by_day = array(4);

        $y_axis = $this->makeYaxis(0, max($reservations_by_day), 5);

        $days = array();
        $days['mon'] = array(
            'percent' => isset($reservations_by_day['Mon']) ? $this->CalcPerc($reservations_by_day['Mon'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Mon']) ? $reservations_by_day['Mon'] : 0
        );
        $days['tue'] = array(
            'percent' => isset($reservations_by_day['Tue']) ? $this->CalcPerc($reservations_by_day['Tue'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Tue']) ? $reservations_by_day['Tue'] : 0
        );
        $days['wed'] = array(
            'percent' => isset($reservations_by_day['Wed']) ? $this->CalcPerc($reservations_by_day['Wed'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Wed']) ? $reservations_by_day['Wed'] : 0
        );
        $days['thu'] = array(
            'percent' => isset($reservations_by_day['Thu']) ? $this->CalcPerc($reservations_by_day['Thu'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Thu']) ? $reservations_by_day['Thu'] : 0
        );
        $days['fri'] = array(
            'percent' => isset($reservations_by_day['Fri']) ? $this->CalcPerc($reservations_by_day['Fri'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Fri']) ? $reservations_by_day['Fri'] : 0
        );
        $days['sat'] = array(
            'percent' => isset($reservations_by_day['Sat']) ? $this->CalcPerc($reservations_by_day['Sat'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Sat']) ? $reservations_by_day['Sat'] : 0
        );
        $days['sun'] = array(
            'percent' => isset($reservations_by_day['Sun']) ? $this->CalcPerc($reservations_by_day['Sun'], max($y_axis)) : 0,
            'reservations' => isset($reservations_by_day['Sun']) ? $reservations_by_day['Sun'] : 0
        );


        // Get profit this year
        $profit_this_year = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y'))
            ->where('site', '=', Auth::id())
            ->first();

        $datetime1 = new \DateTime('first day of january');
        $datetime2 = new \DateTime();
        $interval = $datetime1->diff($datetime2);
        $days_from_start =  (int)$interval->format('%R%a');

        $avg_profit_this_year = $profit_this_year->profit / $days_from_start;


        // Incomes in the past years
        $year_minus_one = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-1)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_two = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-2)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_three = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-3)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_four = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-4)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_five = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-5)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_profits = array(
            $year_minus_one->profit,
            $year_minus_two->profit,
            $year_minus_three->profit,
            $year_minus_four->profit,
            $year_minus_five->profit
        );


        if(max($year_minus_profits) == NULL)
        {
            $d_max = 4;
        } else {
            $d_max = max($year_minus_profits);
        }

        $y_axis_profits = $this->makeYaxis(0, $d_max, 5);
        $max_minus_profits = max($y_axis_profits);

        $year_profits_display = array(
            array(
                'year' => date('Y') -1,
                'profit' => $this->formatProfit($year_minus_one->profit),
                'percent' => $this->CalcPerc($year_minus_one->profit, $max_minus_profits)
            ),
            array(
                'year' => date('Y') -2,
                'profit' => $this->formatProfit($year_minus_two->profit),
                'percent' => $this->CalcPerc($year_minus_two->profit, $max_minus_profits)
            ),
            array(
                'year' => date('Y') -3,
                'profit' => $this->formatProfit($year_minus_three->profit),
                'percent' => $this->CalcPerc($year_minus_three->profit, $max_minus_profits)
            ),
            array(
                'year' => date('Y') -4,
                'profit' => $this->formatProfit($year_minus_four->profit),
                'percent' => $this->CalcPerc($year_minus_four->profit, $max_minus_profits)
            ),
            array(
                'year' => date('Y') -5,
                'profit' => $this->formatProfit($year_minus_five->profit),
                'percent' => $this->CalcPerc($year_minus_five->profit, $max_minus_profits)
            )
        );

        $reformat_y_axis_profits = array();
        foreach($y_axis_profits as $y)
        {
            $reformat_y_axis_profits[] = $y >= 1000 ? round($y/1000,1) . 'k' : $y;
        }

        // Average dails incomes in the past years
        $year_minus_one_inc = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-1)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_two_inc = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-2)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_three_inc = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-3)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_four_inc = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-4)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_five_inc = Reservations::select(DB::raw('sum(price) as profit'))
            ->whereYear('start', '=', date('Y')-5)
            ->where('site', '=', Auth::id())
            ->first();

        $year_minus_daily_inc = array(
            $year_minus_one_inc->profit,
            $year_minus_two_inc->profit,
            $year_minus_three_inc->profit,
            $year_minus_four_inc->profit,
            $year_minus_five_inc->profit
        );

        if(max($year_minus_daily_inc) == NULL)
        {
            $d_max = 4;
        } else {
            $d_max = max($year_minus_daily_inc) / 365;
        }


        $y_axis_daily_inc = $this->makeYaxis(0, $d_max, 5);
        $max_minus_daily_inc = max($y_axis_daily_inc);

        $year_daily_inc_display = array(
            array(
                'year' => date('Y') -1,
                'profit' => $this->formatDailyProfit($year_minus_one_inc->profit),
                'percent' => $this->CalcPerc($year_minus_one_inc->profit/365, $max_minus_daily_inc)
            ),
            array(
                'year' => date('Y') -2,
                'profit' => $this->formatDailyProfit($year_minus_two_inc->profit),
                'percent' => $this->CalcPerc($year_minus_two_inc->profit/365, $max_minus_daily_inc)
            ),
            array(
                'year' => date('Y') -3,
                'profit' => $this->formatDailyProfit($year_minus_three_inc->profit),
                'percent' => $this->CalcPerc($year_minus_three_inc->profit/365, $max_minus_daily_inc)
            ),
            array(
                'year' => date('Y') -4,
                'profit' => $this->formatDailyProfit($year_minus_four_inc->profit),
                'percent' => $this->CalcPerc($year_minus_four_inc->profit/365, $max_minus_daily_inc)
            ),
            array(
                'year' => date('Y') -5,
                'profit' => $this->formatDailyProfit($year_minus_five_inc->profit),
                'percent' => $this->CalcPerc($year_minus_five_inc->profit/365, $max_minus_daily_inc)
            )
        );


        // Reservations this week
        $last_week = new \DateTime();
        $last_week->modify( '-1 week' );

        $last_week_reservations = Reservations::
            where('site', '=', Auth::id())
            ->whereDate('start', '>=', $last_week->format('Y-m-d'))
            ->whereDate('start', '<=', $today->format('Y-m-d'))
            ->orderBy('start', 'asc')
            ->get();

        $weekly_reservations_by_day = array();

        foreach($last_week_reservations as $res)
        {
            $res_date = new \DateTime($res->start);
            if(key_exists($res_date->format('D'), $weekly_reservations_by_day))
            {
                $weekly_reservations_by_day[$res_date->format('D')]++;
            } else {
                $weekly_reservations_by_day[$res_date->format('D')] = 1;
            }
        }

        if(empty($weekly_reservations_by_day))
            $weekly_reservations_by_day = array(4);

        $y_axis_weekly = $this->makeYaxis(0, max($weekly_reservations_by_day), 5);

        $weekly_days = array();
        $weekly_days['mon'] = array(
            'percent' => isset($weekly_reservations_by_day['Mon']) ? $this->CalcPerc($weekly_reservations_by_day['Mon'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Mon']) ? $weekly_reservations_by_day['Mon'] : 0
        );
        $weekly_days['tue'] = array(
            'percent' => isset($weekly_reservations_by_day['Tue']) ? $this->CalcPerc($weekly_reservations_by_day['Tue'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Tue']) ? $weekly_reservations_by_day['Tue'] : 0
        );
        $weekly_days['wed'] = array(
            'percent' => isset($weekly_reservations_by_day['Wed']) ? $this->CalcPerc($weekly_reservations_by_day['Wed'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Wed']) ? $weekly_reservations_by_day['Wed'] : 0
        );
        $weekly_days['thu'] = array(
            'percent' => isset($weekly_reservations_by_day['Thu']) ? $this->CalcPerc($weekly_reservations_by_day['Thu'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Thu']) ? $weekly_reservations_by_day['Thu'] : 0
        );
        $weekly_days['fri'] = array(
            'percent' => isset($weekly_reservations_by_day['Fri']) ? $this->CalcPerc($weekly_reservations_by_day['Fri'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Fri']) ? $weekly_reservations_by_day['Fri'] : 0
        );
        $weekly_days['sat'] = array(
            'percent' => isset($weekly_reservations_by_day['Sat']) ? $this->CalcPerc($weekly_reservations_by_day['Sat'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Sat']) ? $weekly_reservations_by_day['Sat'] : 0
        );
        $weekly_days['sun'] = array(
            'percent' => isset($weekly_reservations_by_day['Sun']) ? $this->CalcPerc($weekly_reservations_by_day['Sun'], max($y_axis_weekly)) : 0,
            'reservations' => isset($weekly_reservations_by_day['Sun']) ? $weekly_reservations_by_day['Sun'] : 0
        );



        // Salon Occupancy
        $occupied = $this->occupied();

        $settings = Settings::where('site', '=', Auth::id())->first();

        if(!$settings)
        {
            $settings = new \StdClass();
            $settings->currency_sign = '$';
            $settings->currency_format = 1;
        }

        // template
        return view('admin.insights.index', [
            'chart_days' => $days,
            'y_axis' => $y_axis,
            'avg_profit' => $avg_profit_this_year,
            'y_axis_profits' => $reformat_y_axis_profits,
            'year_profits_display' => $year_profits_display,
            'y_axis_daily_inc' => $y_axis_daily_inc,
            'year_daily_inc_display' => $year_daily_inc_display,
            'y_axis_weekly' => $y_axis_weekly,
            'weekly_days' => $weekly_days,
            'occupied' => $occupied,
            'info' => $settings
        ]);
    }

    private function occupied()
    {

        $date = date('Y-m-d');

        // return 0 if the salon is closed
        $datetime = \DateTime::createFromFormat('Y-m-d', $date);
        $dates_day = $datetime->format('D');

        $working_day = WorkHours::where('site', '=', Auth::id())->first();

        if($working_day)
        {
            $closed_column = strtolower($dates_day) . '_closed';

            if($working_day->$closed_column)
                return 0;
        }

        // return 0 if there is a holiday
        $holiday = Holidays::whereDate('holiday', $date)->where('site', '=', Auth::id())->first();

        if($holiday)
            return 0;


        // Get all employees and loop through array
        $employees = Profile::select('id')->where('member', '=', Auth::id())->orWhere('id', '=', Auth::id())->get();

        $work_time_minutes = 0;
        $busy_hours = 0;

        foreach($employees as $employee)
        {

            // Skip the employee if it has vacations
            $vacations = Vacations::select('user')
                ->where('user', '=', $employee->id)
                ->whereDate('date_from', '<=', $date)
                ->whereDate('date_to', '>=', $date)
                ->first();

            if($vacations)
                continue;

            // get employee work time
            $employee_work_time = WorkTime::
            where('user', '=', $employee->id)
            ->whereDate('date_from', '<=', $date)
            ->whereDate('date_to', '>=', $date)
            ->first();

            if($employee_work_time)
            {
                $employee_work_time_start = new \DateTime($date.' '.$employee_work_time->time_from);
                $employee_work_time_end = new \DateTime($date.' '.$employee_work_time->time_to);

                $employee_work_time_diff = $employee_work_time_start->diff($employee_work_time_end);
                $work_time_minutes += $this->returnDiffMinutes($employee_work_time_diff);

                // substract lunch time minutes
                if($employee_work_time->lunch_from && $employee_work_time->lunch_to)
                {
                    $lunch_time_start = new \DateTime($date.' '.$employee_work_time->lunch_from);
                    $lunch_time_end = new \DateTime($date.' '.$employee_work_time->lunch_to);

                    $lunch_time_diff = $lunch_time_start->diff($lunch_time_end);
                    $work_time_minutes -= $this->returnDiffMinutes($lunch_time_diff);
                }
            }

            // calculate busy times for salon
            $reservations = Reservations::where('user', '=', $employee->id)
                ->whereDate('start', '=', $date)
                ->get();

            foreach($reservations as $reservation)
            {
                $reserv_time_start = new \DateTime($reservation->start);
                $reserv_time_end = new \DateTime($reservation->end);
                $reserv_time_end->modify("+1 second");

                $reserv_time_diff = $reserv_time_start->diff($reserv_time_end);
                $busy_hours += $this->returnDiffMinutes($reserv_time_diff);
            }

        }

        // if there is no working time return 0, can't divide by zero
        if(!$work_time_minutes)
            return 0;

        return round($busy_hours / $work_time_minutes * 100);

    }

    private function returnDiffMinutes($diff)
    {
        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;
        return $minutes;
    }

    private function formatDailyProfit($profit)
    {
        $profit = $profit / 365;
        return number_format($profit, 0, ',', '.');
    }

    private function formatProfit($profit)
    {
        return ($profit >= 1000) ? round($profit/1000, 1) . 'k' : (float)$profit;
    }

    private function CalcPerc($value, $max)
    {
        return round($value / $max * 100);
    }

    private function makeYaxis($yMin, $yMax, $ticks = 4)
    {
        $result = array();

        if($yMin == $yMax)
        {
            $yMin = $yMin - 10;
            $yMax = $yMax + 10;
        }

        $range = $yMax - $yMin;

        if($ticks < 2)
            $ticks = 2;
        else if($ticks > 2)
            $ticks -= 2;

        $tempStep = $range/$ticks;

        $mag = floor(log10($tempStep));
        $magPow = pow(10,$mag);
        $magMsd = (int)($tempStep/$magPow + 0.5);
        $stepSize = $magMsd*$magPow;

        $lb = $stepSize * floor($yMin/$stepSize);
        $ub = $stepSize * ceil(($yMax/$stepSize));

        $val = $lb;
        while(1)
        {
            $result[] = $val;

            $val += $stepSize;
            if($val > $ub)
            break;
        }

        return $result;

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
