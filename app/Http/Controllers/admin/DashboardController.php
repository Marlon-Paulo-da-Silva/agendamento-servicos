<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \App\Models\Reservations;
use \App\Models\Services;
use \App\Models\ServicesCategories;
use \App\Models\Profile;
use \App\Models\Customers;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // echo "<pre>";
        // print_r($request->user()['id']);
        // echo "</pre>";
        // exit();

        // Today date
        $today = new \DateTime();
        $today_format = $today->format('Y-m-d');

        // Yesterday date
        $yesterday  = new \DateTime();
        $interval = new \DateInterval('P1D');
        $yesterday->sub($interval);
        $yesterday_format = $yesterday->format('Y-m-d');

        // Chart data
        $last_month = new \DateTime();
        $last_month->modify( '-1 month' );

        $last_month_reservations = Reservations::
            whereDate('start', '>=', $last_month->format('Y-m-d'))
            ->whereDate('start', '<=', $today->format('Y-m-d'))
            ->where('user_id', '=', $request->user()['id'])
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
        $days['mon'] = isset($reservations_by_day['Mon']) ? $this->CalcPerc($reservations_by_day['Mon'], max($y_axis)) : 0;
        $days['tue'] = isset($reservations_by_day['Tue']) ? $this->CalcPerc($reservations_by_day['Tue'], max($y_axis)) : 0;
        $days['wed'] = isset($reservations_by_day['Wed']) ? $this->CalcPerc($reservations_by_day['Wed'], max($y_axis)) : 0;
        $days['thu'] = isset($reservations_by_day['Thu']) ? $this->CalcPerc($reservations_by_day['Thu'], max($y_axis)) : 0;
        $days['fri'] = isset($reservations_by_day['Fri']) ? $this->CalcPerc($reservations_by_day['Fri'], max($y_axis)) : 0;
        $days['sat'] = isset($reservations_by_day['Sat']) ? $this->CalcPerc($reservations_by_day['Sat'], max($y_axis)) : 0;
        $days['sun'] = isset($reservations_by_day['Sun']) ? $this->CalcPerc($reservations_by_day['Sun'], max($y_axis)) : 0;

        // Reservations
        $reservations_today = Reservations::select('reservations.*', 'customers.*', 'users.name as employee_name', 'users.surname as employee_surname')
            ->leftJoin('customers', 'reservations.customer', '=', 'customers.id')
            ->leftJoin('users', 'users.id', '=', 'reservations.user_id')
            /*->where([
                ['reservations.user', '=', Auth::id()]
            ])*/
            ->whereDate('reservations.start', $today_format)
            // ->where('user_id', '=', $request->user()['id'])
            ->orderBy('start', 'asc')->get();

        $completed = 0;
        if($reservations_today->count())
        {
            foreach($reservations_today as $key=>$reservation)
            {
                $time = new \DateTime($reservation->start);

                $reservations_today[$key]->passed = $reservation->start >= $today->format('Y-m-d H:i:s') ? false : true;
                if($reservation->start < $today->format('Y-m-d H:i:s'))
                    $completed++;

                $reservations_today[$key]->start = $time->format('H:i');

            }
        }


        $customers = Customers::
            whereDate('created_at', $today_format)
            ->where('user_id', '=', $request->user()['id'])
            ->get();

        $customers_yesterday = Customers::
            whereDate('created_at', $yesterday_format)
            ->where('user_id', '=', $request->user()['id'])
            ->get();


        foreach($customers as $key=>$customer)
        {
            $phone = str_split('0'.$customer->phone, 3);
            $phone_format = '';
            foreach($phone as $ph)
            {
                $phone_format .= $ph . ' ';
            }
            $customers[$key]->phone_formatted = $phone_format;
        }

        // Services
        // $services = Services::where('user', '=', $this->GetSite())->get();
        $services = Services::where('user_id', '=', $request->user()['id'])->get();

        // Categories
        // $categories = ServicesCategories::where('user', '=', $this->GetSite())->get();
        $categories = ServicesCategories::where('user_id', '=', $request->user()['id'])->get();

        return view('admin.dashboard.index', [
            'reservations_today' => $reservations_today,
            'services' => $services,
            'categories' => $categories,
            'customers' => $customers,
            'customers_yesterday' => $customers_yesterday->count(),
            'completed_reservations' => $completed,
            'chart_days' => $days,
            'y_axis' => $y_axis
        ]);
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

    private function GetSite() {
        $user = Profile::where('id', '=', Auth::id())->first();
        return $user->member ? $user->member : Auth::id();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    // public function show(Bills $bills, $id)
    // {

    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Bills  $bills
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Bills $bills, $id)
    // {

    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Bills  $bills
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Bills $bills, $id)
    // {

    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Bills  $bills
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Bills $bills, $id)
    // {
    // }


}
