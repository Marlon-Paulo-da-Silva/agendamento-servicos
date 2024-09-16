<?php

namespace App\Http\Controllers\admin;

use Jenssegers\Date\Date as Date;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\Reservations;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Profile;
// use Validator;
use App\Models\ServicesCategories;
use App\Models\Services;
use App\Models\MyServices;
use App\Models\WorkTime;
use App\Models\WorkHours;
use App\Models\Vacations;
use App\Models\Holidays;
use App\Models\PhoneAreaCodes;


class ReservationsController extends Controller
{

    public function __construct(Request $request)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): view
    {
        if(!$request->user)
        {
            $requested_user = Auth::id();
        } else {
            $requested_user = $request->user;
        }

        $request_day = NULL;
        if(!$request->day)
        {
            $today = new \DateTime();
            $request_day = $today->format('Y-m-d');
        }
        if($request->day)
        {
            $request_day = $request->day;
        }

        $selected_user = Profile::where('user_id', $requested_user)->first();


        // list days for mobile calendar
        $days = $this->ListDays();

        // get dates for navigation and sql for desktop calendar
        $dates = $this->getDates($request_day);

        $reservations = Reservations::whereBetween('start', [
            $dates['first_day']->format('Y-m-d H:i:s'), $dates['last_day']->format('Y-m-d H:i:s')
        ])
        ->where('user_id', '=', $requested_user)
        ->orderBy('start', 'asc')
        ->get();



        $reserv = array(
            'Mon' => array(),
            'Tue' => array(),
            'Wed' => array(),
            'Thu' => array(),
            'Fri' => array(),
            'Sat' => array(),
            'Sun' => array()
        );

        $settings = Settings::where('user_id', '=', $this->GetUser())->first();

        if(empty($settings)) {
            $settings = new \stdClass();
            $settings->time_format = 1;
        }

        foreach($reservations as $reservation)
        {
            $reservation_times_start_input = \DateTime::createFromFormat('Y-m-d H:i:s', $reservation->start);
            $reservation_times_end_input = \DateTime::createFromFormat('Y-m-d H:i:s', $reservation->end);
            $reservation_times_end_input->modify('+1 second');

            $reserv[$reservation_times_start_input->format('D')][] = array(
                'id' => $reservation->id,
                'title' => $reservation->service,
                'start' => $reservation_times_start_input->format('H:i'),
                'end' => $reservation_times_end_input->format('H:i'),
                'start_e' => ($settings->time_format == 1) ? $reservation_times_start_input->format('h:ia') : $reservation_times_start_input->format('H:i'),
                'end_e' => ($settings->time_format == 1) ? $reservation_times_end_input->format('h:ia')  : $reservation_times_end_input->format('H:i')
            );
        }

        // echo "<pre>";
        // // print_r($employees_data['employees']);
        // print_r($reserv);
        // echo "</pre>";
        // exit();

        // Get now time H:i for now bar
        $now = new \DateTime();
        $now = $now->format('H:i');

        $users = Profile::select('id', 'profile_image', 'name', 'surname')->get();


        // echo "<pre>";
        // // print_r($employees_data['employees']);
        // print_r($reserv);
        // echo "</pre>";
        // exit();

        return view('admin.reservations.index', [
            'days' => $days,
            'first_day' => $dates['first_day']->format('d/m'),
            'last_day' => $dates['last_day']->format('d/m/Y'),
            'next_week' => $dates['next_week']->format('d.m.Y'),
            'previous_week' => $dates['previous_week']->format('d.m.Y'),
            'reservations' => $reserv,
            'now' => $now,
            'users' => $users,
            'request_day' => $request->day,
            'selected_user' => $selected_user,
            'info' => $settings
        ]);

    }

    public function get(Request $request)
    {
        $reservation = Reservations::
        select('reservations.id', 'reservations.service', 'reservations.start', 'reservations.end', 'users.profile_image', 'users.name as u_name', 'users.surname as u_surname', 'users.occupation', 'customers.name', 'customers.surname', 'customers.area_code', 'customers.phone')
        ->leftJoin('customers', 'reservations.customer', '=', 'customers.id')
        ->leftJoin('users', 'reservations.user_res', '=', 'users.id')
        ->findOrFail($request->id);


        $reservation_start = new \DateTime($reservation->start);
        $reservation->start = $reservation_start->format('d/m/Y');
        $end = new \DateTime($reservation->end);
        $end->modify("+1 second");

        $settings = Settings::where('user_id', '=', $this->GetUser())->first();

        if(empty($settings)) {
            $settings = new \stdClass();
            $settings->time_format = 1;
        }

        $reservation->time = ($settings->time_format == 1) ? $reservation_start->format('h:ia') . ' - ' . $end->format('h:ia') : $reservation_start->format('H:i') . ' - ' . $end->format('H:i');

        return view('admin.reservations.view.index', [
            'reservation'=>$reservation,
        ]);
    }

    private function getDates($day) {

        if($day && $this->verifyDate($day) && $this->isMonday($day))
        {
            $date = \DateTime::createFromFormat('d.m.Y H:i:s', $day . ' 00:00:00');
            $date_end = \DateTime::createFromFormat('d.m.Y H:i:s', $day . '00:00:00');
            $date_end->modify('Next Sunday');
            $date_end->modify('+86399 seconds');

            $next_week_date_time = \DateTime::createFromFormat('d.m.Y', $day);
            $next_week = $next_week_date_time->modify('+1 week');

            $previous_week_date_time = \DateTime::createFromFormat('d.m.Y', $day);
            $previous_week = $previous_week_date_time->modify('-1 week');

        } else {
            $date = new \DateTime('this week monday');
            $date_end = new \DateTime('sunday this week');
            $date_end->modify('+86399 seconds');

            $next_week_date_time = new \DateTime('this week monday');
            $next_week = $next_week_date_time->modify('+1 week');

            $previous_week_date_time = new \DateTime('this week monday');
            $previous_week = $previous_week_date_time->modify('-1 week');
        }

        return array(
            'first_day' => $date,
            'last_day' => $date_end,
            'next_week' => $next_week,
            'previous_week' => $previous_week
        );
    }

    private function isMonday($date)
    {
        $from_format = \DateTime::createFromFormat('d.m.Y', $date);
        return $from_format->format('D') === 'Mon' ? true : false;
    }
    private function verifyDate($date)
    {
    return (\DateTime::createFromFormat('d.m.Y', $date) !== false);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ServicesCategories::where('user_id', '=', Auth::id())->get();

        $cats = array();

        foreach($categories as $cat)
        {
            $services = Services::where(
                [
                    ['user_id', '=', Auth::id()],
                    ['category', '=', $cat->id]
                ]
            )->get();

            foreach($services as $key=>$service)
            {
                $hours = explode(':', $service->duration);
                $services[$key]->hours = (int)$hours[0];
                $services[$key]->minutes = (int)$hours[1];

            }


            $cats[] = array(
                'title' => $cat->title,
                'services' => $services,
                'num' => $services->count()
            );
        }

        $days = $this->ListDaysBySetting();

        $area_codes = PhoneAreaCodes::get();

        $settings = Settings::where('user_id', '=', Auth::id())->first();

        if(empty($settings)) {
            $settings = new \stdClass();
            $settings->area_code = 15;
            $settings->currency_sign = '$';
            $settings->currency_format = 1;
            $settings->time_format = 1;
        }

        return view('admin.reservations.add.index', [
            'categories'=>$cats,
            'days' => $days,
            'area_codes' => $area_codes,
            'info' => $settings
        ]);
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
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function show(Reservations $reservations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservations $reservations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservations $reservations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservations $reservations, Request $request)
    {
        $reservation = Reservations::where(
            [
                ['user_id', '=', $this->GetUser()],
                ['id', '=', $request->input('id')]
            ]
        )->firstOrFail();

        $reservation->delete();

        return redirect($request->input('return_url'));
    }

    public function confirmDelete(Request $request, $id)
    {
        $reservation = Reservations::where(
            [
                ['user_id', '=', $this->GetUser()],
                ['id', '=', $id]
            ]
        )->firstOrFail();

        return view('admin.reservations.delete', ['id' => $id, 'reservation' => $reservation, 'return_url' => $request->return_url]);
    }

    private function CheckUserHasServiceRights($user, $service)
    {
        return Services::where('user_id', '=', $user)->where('id', '=', $service)->first();
    }
    private function GetEmployeesData($date, $service)
    {
        // Drop everything if there is non-working day
        $datetime = \DateTime::createFromFormat('Y-m-d', $date);
        $dates_day = $datetime->format('D');

        $working_day = WorkHours::where('user_id', '=', Auth::id())->first();


        if($working_day)
        {
            $closed_column = strtolower($dates_day) . '_closed';

            if($working_day->$closed_column)
            return [];
        }

        // Drop everything if there is a holiday
        $holiday = Holidays::whereDate('holiday', $date)->where('user_id', '=', Auth::id())->first();

        if($holiday)
            return [];


        // Set the main array where we will store employees
        $employees = array();

        // Check which employees are offering the service
        $get_employees_of_service = MyServices::select('my_services.user_res')
            ->leftJoin('users', 'my_services.user_id', '=', 'user_id')
            ->where('users.deleted_at', null)
            ->where('my_services.service_id', '=', $service)->get();


        if(!$get_employees_of_service)
            return [];

        $employees_of_service = array();

        foreach($get_employees_of_service as $employee)
        {
            $employees_of_service[] = $employee->user_res;
        }



        // Check if employees work on selected date and store them in array
        $working = WorkTime::select('work_times.employee_id')
            ->distinct('work_times.employee_id')
            ->leftJoin('users', 'work_times.employee_id', '=', 'users.id')
            ->where('users.deleted_at', null)
            ->whereIn('work_times.employee_id', $employees_of_service)
            ->whereDate('work_times.date_from', '<=', $date)
            ->whereDate('work_times.date_to', '>=', $date)
            ->get();




        foreach($working as $work)
        {
            $employees[] = $work->employee_id;
        }



        // Check which employees have vacations and exclude them from array
        $vacations = Vacations::select('employee_id')
            ->distinct()
            ->whereIn('employee_id', $employees_of_service)
            ->whereDate('date_from', '<=', $date)
            ->whereDate('date_to', '>=', $date)
            ->get();



        foreach($vacations as $vacation)
        {
            if (($key = array_search($vacation->user, $employees)) !== false) {
                    unset($employees[$key]);
            }
        }

        // Build an array of for each employee and it's data
        $data = array(
            'employees' => array(),
            'terms' => array()
        );

        $employees_info = array();
        $terms = array();

        foreach($employees as $employee)
        {

            // Get profile data for each employee
            $employees_sql = Profile::where('id', '=', $employee)->first();

            if($employees_sql)
            {
                if(!$employees_sql->name)
                    $employees_sql->name = 'Employee';

                $employees_info[$employees_sql->id] = array(
                    'name' => $employees_sql->name . ' ' . $employees_sql->surname,
                    'avatar' => $employees_sql->profile_image,
                    'occupation' => $employees_sql->occupation
                );

            }



            // HERE CHECK EMPLOYEE WORK TIME
            $employee_work_time = WorkTime::
                where('employee_id', '=', $employee)
                ->whereDate('date_from', '<=', $date)
                ->whereDate('date_to', '>=', $date)
                ->first();



            // Employee start and end time of the day
            $employee_work_time_start = new \DateTime($date.' '.$employee_work_time->time_from);
            $employee_work_time_start_format = $employee_work_time_start->format('H:i');

            $employee_work_time_end = new \DateTime($date.' '.$employee_work_time->time_to);
            $employee_work_time_end_format = $employee_work_time_end->format('H:i');


            // Fill unavailables
            $reservations = Reservations::where('user_res', '=', $employee)
                ->whereDate('start', $date)
                ->orderBy('end', 'desc')->get();



            $reservations_unavailables = array();

            foreach($reservations as $reservation)
            {
                $reservation_start_time = new \DateTime($reservation->start);
                $reservation->start = $reservation_start_time->format('Y-m-d H:i');

                $reservation_end_time = new \DateTime($reservation->end);
                $reservation->end = $reservation_end_time->format('Y-m-d H:i');

                $reservations_unavailables[] = array(
                    'start_at' => $reservation->start,
                    'end_at' => $reservation->end
                );
            }

            // Fill lunch times
            $lunch_time = WorkTime::
            where('employee_id', '=', $employee)
            ->whereDate('date_from', '<=', $date)
            ->whereDate('date_to', '>=', $date)
            ->first();

            if($lunch_time && $lunch_time->lunch_from && $lunch_time->lunch_to)
            {
                $lunch_time_start = new \DateTime($date.' '.$lunch_time->lunch_from);
                $lunch_time_start_format = $lunch_time_start->format('Y-m-d H:i');

                $lunch_time_end = new \DateTime($date.' '.$lunch_time->lunch_to);
                $lunch_time_end_format = $lunch_time_end->format('Y-m-d H:i');

                $reservations_unavailables[] = array(
                    'start_at' => $lunch_time_start_format,
                    'end_at' => $lunch_time_end_format
                );
            }


            $terms[] = array(
                'id' => $employee,
                'start_date' => $employee_work_time_start_format,
                'end_date' => $employee_work_time_end_format,
                'unavailables' => $reservations_unavailables
            );





        }

        $data['employees'] = $employees_info;
        $data['terms'] = $terms;

        return $data;


    }
    public function GetTerms(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'date' => 'required|after_or_equal:today',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'service' => 'required|integer|exists:services,id'
        ]);

        // echo "<pre>";
        // print_r(response()->json($validator->messages()));
        // echo "</pre>";
        // exit();


        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        // Check if user has the right to the service
        if(!$this->CheckUserHasServiceRights(Auth::id(), $request->service))
            return response()->json($validator->messages());


        // Get employees data that work on current day and are managing the service. Returns array of employees data and employees work times
        $employees_data = $this->GetEmployeesData($request->date, $request->service);


        if(!$employees_data)
            $employees_data = array(
                'employees' => array(),
                'terms' => array()
            );

        $day = $request->date;

        $service_duration = Services::where('id', '=', $request->service)->first();

        if(!$service_duration)
            return response()->json($validator->messages());


        $start_time = new \DateTime('00:00:00');
        $duration = new \DateTime($service_duration->duration);
        $interval = $start_time->diff($duration);
        $hours = (int)$interval->format('%H');
        $minutes = (int)$interval->format('%i');

        $minutesPerSession = ($hours * 60) + $minutes;


        return $this->list($employees_data['employees'], $employees_data['terms'], $day, $minutesPerSession);

    }
    public function list($employees_data, $employees, $day, $minutesPerSession, $minutesPerGap = 15)
    {

        $slots = array();

        foreach($employees as $employee)
        {
            if(!$employee['start_date'] OR !$employee['end_date'])
                continue;

            $start_date = new \DateTime($day.' '.$employee['start_date']);
            $start = $start_date->getTimestamp();
            $start = round($start / ($minutesPerGap * 60)) * ($minutesPerGap * 60);

            $end_date = new \DateTime($day.' '.$employee['end_date']);
            $end = $end_date->getTimestamp();

            $now = new \DateTime();
            $now_stamp = $now->getTimestamp();

            $slotsAvailable = array();

            for ($i = $start; $i <= $end - ($minutesPerGap * 60); $i = ($i + $minutesPerGap * 60))
            {
                if($now_stamp >= $i)
                continue;

                $time_obj = new \DateTime();
                $time_obj->setTimestamp($i);
                $time = $time_obj->format('H:i');

                $range_obj = new \DateTime();
                $range_obj->setTimestamp($i);
                $range_obj->modify("+{$minutesPerSession} minutes");
                $range = $range_obj->format('H:i');

                $dateStart = $start_date->format('Y-m-d') . ' ' . $time;
                $dateEnd =$end_date->format('Y-m-d') . ' ' . $range;
                $isAvailable = true;

                foreach ($employee['unavailables'] as $unavailable)
                {
                    if
                    (
                        ($unavailable['start_at'] <= $dateStart && $unavailable['end_at'] >= $dateStart) ||
                        ($unavailable['start_at'] <= $dateEnd && $unavailable['end_at'] >= $dateEnd) ||
                        ($unavailable['start_at'] >= $dateStart && $unavailable['end_at'] <= $dateEnd)
                    )
                    {
                        $isAvailable = false;
                        break;
                    }
                }

                if ($isAvailable)
                {
                    $slots[$time][] = $employee['id'];
                }

            }


        }

        // echo "<pre>";
        // print_r(ksort($slots));
        // echo "</pre>";
        // exit();

        ksort($slots);

        $data = array(
            'employees' => $employees_data,
            'slots' => $slots
        );

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        // TODO o SLOT está indo vazio, possivelmente por conta do ksort() então precisa verificar o motivo

        return response()->json($data);
    }

    public function ListDaysBySetting()
    {

        $settings = Settings::where('user_id', '=', Auth::id())->first();

        $string = $settings ? $settings->booking : 'x';

        $string = $this->GetInterval($string);

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $todays_date = new \DateTime('now');
        $today_date = $todays_date->format('Y-m-d H:i:s');

        // $today_date = Date::now()->format('Y-m-d H:i:s');


        // $todays_date = new \DateTime();
        // $todays_date = new IntlDateFormatter('pt_BR',
        //                     \IntlDateFormatter::FULL,
        //                     \IntlDateFormatter::NONE,
        //                     'America/Sao_Paulo',
        //                     \IntlDateFormatter::GREGORIAN);

        // $today_date = $todays_date->format($todays_date);

        $dates = Reservations::where('user_res', '=', Auth::id())->where('start', '>=', $today_date)->get();

        // Get the non working dates
        $non_working_days = $this->GetNonWorkingDays($string);

        // Get the non working dates - holidays
        $holidays = $this->GetHolidaysDates();
        $merged_non_working_dates = array_merge($non_working_days, $holidays);

        return $this->GetDays($string, $dates, $merged_non_working_dates);

    }

    public function ListDays()
    {

        $last_reservation = Reservations::where('user_res', '=', Auth::id())->orderBy('end', 'desc')->first();

        $today_date = new \DateTime();
        $origin = new \DateTime($today_date->format('Y-m-d'));
        if(!$last_reservation)
            $target = new \DateTime();
        else
            $target = new \DateTime($last_reservation->end);
        $interval = $origin->diff($target);

        $format = (int)$interval->format('%a');
        if($format < 30)
        {
            $string = 'P1M';
        } else {
            $string = 'P'.((int)$interval->format('%a')+1).'D';
        }

        // Get the reservations for current member
        $todays_date = new \DateTime('now');
        $today_date = $todays_date->format('Y-m-d H:i:s');
        $dates = Reservations::where('user_res', '=', Auth::id())->where('start', '>=', $today_date)->get();

        // Get the non working dates
        $non_working_days = $this->GetNonWorkingDays($string);

        // Get the non working dates - holidays
        $holidays = $this->GetHolidaysDates();
        $merged_non_working_dates = array_merge($non_working_days, $holidays);

        return $this->GetDays($string, $dates, $merged_non_working_dates);

    }
    private function GetNonWorkingDays($string) {

        $start_date = new \DateTime('now');
        $end_date = new \DateTime('now');
        $end_date->add(new \DateInterval($string));

        $interval = \DateInterval::createFromDateString('1 day');
        $daterange = new \DatePeriod($start_date, $interval ,$end_date);

        $working_day = WorkHours::where('user_id', '=', $this->GetUser())->first();

        $non_working_days = array();

        if($working_day)
        {
            foreach($daterange as $date)
            {
                $dates_day = $date->format('D');
                $closed_column = strtolower($dates_day) . '_closed';

                if($working_day->$closed_column)
                    $non_working_days[] = $date->format('Y-m-d');
            }
        }

        return $non_working_days;
    }
    private function GetHolidaysDates() {

        $holidays = Holidays::where('user_id', '=', $this->GetUser())->get();
        $holidays_days = array();

        if(!empty($holidays))
        {
            foreach($holidays as $date)
            {
                $holidays_days[] = $date->holiday;
            }
        }

        return $holidays_days;
    }
    public function ListDaysForUser()
    {

        $last_reservation = Reservations::where('user_id', '=', Auth::id())->orderBy('end', 'desc')->first();

        $today_date = new \DateTime();
        $origin = new \DateTime($today_date->format('Y-m-d'));
        if(!$last_reservation)
            $target = new \DateTime();
        else
            $target = new \DateTime($last_reservation->end);

        $interval = $origin->diff($target);

        $format = (int)$interval->format('%a');
        if($format < 30)
        {
            $string = 'P1M';
        } else {
            $string = 'P'.((int)$interval->format('%a')+1).'D';
        }

        $todays_date = new \DateTime('now');
        $today_date = $todays_date->format('Y-m-d H:i:s');
        $scheduled_dates = Reservations::where('user_id', '=', Auth::id())->where('start', '>=', $today_date)->get();


        // Get the non working dates
        $non_working_days = $this->GetNonWorkingDays($string);

        // Get the non working dates - holidays
        $holidays = $this->GetHolidaysDates();
        $merged_non_working_dates = array_merge($non_working_days, $holidays);

        return $this->GetDays($string, $scheduled_dates, $merged_non_working_dates);

    }
    private function GetInterval($num)
    {
        switch($num) {
            case 1 : return 'P1W'; break;
            case 2 : return 'P2W'; break;
            case 3 : return 'P3W'; break;
            case 4 : return 'P1M'; break;
            case 5 : return 'P2M'; break;
            case 6 : return 'P3M'; break;
            case 7 : return 'P6M'; break;
            default : return 'P1M';
        }
    }
    public function GetDays($interval_code, $scheduled_dates = array(), $non_working_days = array())
    {

        // Fill dates that have terms reserved
        $fillable_dates = array();

        foreach($scheduled_dates as $date_value)
        {
            $date_from_db = new \DateTime($date_value->start);
            $date_from_db_format = $date_from_db->format('Y-m-d');

            if(in_array($date_from_db_format, $fillable_dates))
                continue;

                $fillable_dates[] = $date_from_db_format;
        }


        // Fill dates that are non working days
        $fillable_non_working = array();

        foreach($non_working_days as $non_working_value)
        {
            if(in_array($non_working_value, $fillable_non_working))
                continue;

                $fillable_non_working[] = $non_working_value;
        }


        // Run through dates
        $start_date = new \DateTime('now');
        $end_date = new \DateTime('now');
        $end_date->add(new \DateInterval($interval_code));
        $end_date->modify('+1 day');

        $interval = \DateInterval::createFromDateString('1 day');
        $daterange = new \DatePeriod($start_date, $interval ,$end_date);

        $days = array();

        $found = false;
        $selected = false;

        foreach($daterange as $date){

            $scheduled = in_array($date->format('Y-m-d'), $fillable_dates) ? true : false;
            $disabled = in_array($date->format('Y-m-d'), $fillable_non_working) ? true : false;

            if(!$disabled && !$found)
            {
                $selected = true;
                $found = true;
            }

            $days[] = array(
                'day' => $date->format('j'),
                'day_name' => $this->GetDayName($date->format('N')),
                'month' => $this->GetMonthName($date->format('n')),
                'month_num' => $date->format('n'),
                'year' => $date->format('Y'),
                'date_iso' => $date->format('Y-m-d'),
                'scheduled' => $scheduled,
                'disabled' => $disabled,
                'selected' => $selected
            );

            if($found)
            $selected = false;
        }

        return $days;
    }
    private function GetDayName($day) {

        switch($day) {
            case 1 : return 'Monday'; break;
            case 2 : return 'Tuesday'; break;
            case 3 : return 'Wednesday'; break;
            case 4 : return 'Thursday'; break;
            case 5 : return 'Friday'; break;
            case 6 : return 'Saturday'; break;
            case 7 : return 'Sunday'; break;
            default : return '';
        }
    }
    private function GetMonthName($month) {

        switch($month) {
            case 1 : return 'January'; break;
            case 2 : return 'February'; break;
            case 3 : return 'March'; break;
            case 4 : return 'April'; break;
            case 5 : return 'May'; break;
            case 6 : return 'June'; break;
            case 7 : return 'July'; break;
            case 8 : return 'August'; break;
            case 9 : return 'September'; break;
            case 10 : return 'October'; break;
            case 11 : return 'November'; break;
            case 12 : return 'December'; break;
            default : return '';
        }
    }

    public function GetScheduleByUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'user_res' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(array());
        }

        $now = new \DateTime('now');
        $greater = $now->format('Y-m-d H:i:s');

        $reservations = Reservations::
                select('reservations.id', 'reservations.service', 'reservations.start', 'customers.name', 'customers.surname', 'customers.area_code', 'customers.phone')
                ->leftJoin('customers', 'reservations.customer', '=', 'customers.id')
                ->where('reservations.user_res', '=', $request->user)
                ->whereDate('reservations.start', $request->date)
                ->where('reservations.start', '>=', $greater)
                ->orderBy('reservations.start', 'asc')
                ->get();

        foreach($reservations as $key=>$reservation)
        {
            $dt = new \DateTime($reservation->start);
            $reservations[$key]->start = $dt->format('H:i');
        }

        return response()->json($reservations);
    }

    private function GetUser() {
        $user = Profile::where('id', '=', Auth::id())->first();
        if ($user) {
            return $user->member ? $user->member : Auth::id();
        }
        return Auth::id();
    }

    private function SlotFree($start, $service, $user)
    {

        $startTime = $start;
        $endTime = $this->CalculateSlotEndTime($start, $service);
        $user_id = $this->GetUser();

        // Check in reservations
        $count = Reservations::where(function ($query) use ($startTime, $endTime) {
            $query->where(function ($query) use ($startTime, $endTime) {
                $query->where('start', '<=', $startTime)
                    ->where('end', '>=', $startTime);
            })->orWhere(function ($query) use ($startTime, $endTime) {
                $query->where('start', '<=', $endTime)
                    ->where('end', '>=', $endTime);
            })->orWhere(function ($query) use ($startTime, $endTime) {
                $query->where('start', '>=', $startTime)
                    ->where('end', '<=', $endTime);
            });
        })->where('user_res', '=', $user)->count();

        if($count)
            return true;


        // Check between vacation dates for user
        $vacation_times_for_user = Vacations::where('employee_id', '=', $user)->first();

        if($vacation_times_for_user)
        {

            $vacation_time_start_date = $vacation_times_for_user->date_from . ' 00:00:00';
            $vacation_time_end_date = $vacation_times_for_user->date_to . ' 23:59:59';

            if
            (
                ($vacation_time_start_date <= $startTime && $vacation_time_end_date >= $startTime) ||
                ($vacation_time_start_date <= $endTime && $vacation_time_end_date >= $endTime) ||
                ($vacation_time_start_date >= $startTime && $vacation_time_end_date <= $endTime)
            )
            {
                   return true;
            }
        }


        // Check between working times for user

        $startTime_t = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime);
        $endTime_t = \DateTime::createFromFormat('Y-m-d H:i:s', $endTime);

                // Get work times
                $work_times_for_user = WorkTime::
                    whereDate('date_from', '<=', $startTime_t->format('Y-m-d'))
                    ->whereDate('date_to', '>=', $startTime_t->format('Y-m-d'))
                    ->where('employee_id', '=', $user)
                    ->first();

                if(!$work_times_for_user)
                    return true;

        $work_time_start_time = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime_t->format('Y-m-d') . ' ' . $work_times_for_user->time_from);
        $work_time_end_time = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime_t->format('Y-m-d') . ' ' . $work_times_for_user->time_to);

        if
        (
            ($work_time_start_time <= $startTime_t && $work_time_end_time >= $startTime_t) ||
            ($work_time_start_time <= $endTime_t && $work_time_end_time >= $endTime_t) ||
            ($work_time_start_time >= $startTime_t && $work_time_end_time <= $endTime_t)
        )
        {

        } else {
            return true;
        }

        // Check between lunch times for user
        if($work_times_for_user->lunch_from)
        {
            $startTime_l = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime);
            $endTime_l = \DateTime::createFromFormat('Y-m-d H:i:s', $endTime);

            $lunch_time_start_time = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime_l->format('Y-m-d') . ' ' . $work_times_for_user->lunch_from);
            $lunch_time_end_time = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime_l->format('Y-m-d') . ' ' . $work_times_for_user->lunch_to);

            if
            (
                ($lunch_time_start_time <= $startTime_l && $lunch_time_end_time >= $startTime_l) ||
                ($lunch_time_start_time <= $endTime_l && $lunch_time_end_time >= $endTime_l) ||
                ($lunch_time_start_time >= $startTime_l && $lunch_time_end_time <= $endTime_l)
            )
            {
                return true;
            }
        }


        // Check for closing times for shop

        $work_hours = WorkHours::where('user_id', '=', $user_id)->first();

        if($work_hours)
        {
            $start_time_format = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime);

            $dates_day = $start_time_format->format('D');
            $db_column = strtolower($dates_day) . '_closed';

            if($work_hours->$db_column)
                return true;
        }

        // return false as ok if everything pasess
        return false;

    }
    private function CalculateSlotEndTime($start_time, $service)
    {
        $service_duration = Services::where('id', '=', $service)->first();

        if(!$service_duration)
            return false;

        $start = new \DateTime('00:00:00');
        $duration = new \DateTime($service_duration->duration);
        $difference = $start->diff($duration);
        $hours = (int)$difference->format('%H');
        $minutes = (int)$difference->format('%i');

        $session_length_in_minutes = ($hours * 60) + $minutes;

        $end = new \DateTime($start_time);
        $end->modify("+{$session_length_in_minutes} minutes");
        $end->modify("-1 second");

        return $end->format('Y-m-d H:i:s');

    }
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reservation_slot' => 'required|date_format:Y-m-d H:i:s|after_or_equal:today',
            'reservation_service' => 'required|integer|exists:services,id',
            'reservation_user' => 'required|integer|exists:users,id',
            'reservation_customer' => 'required|integer|exists:customers,id'
        ]);

        if ($validator->fails()) {
                return response()->json($validator->messages(), 422);
        }

        if($this->SlotFree($request->input('reservation_slot'), $request->input('reservation_service'), $request->input('reservation_user')))
        return response()->json(['reservation_slot' => ['O período escolhido não está mais disponível. Entretanto, ele poderia ser aceito.']], 422);

        // Check if user has reservation service
        if(!$this->UserHasService($request->input('reservation_user'), $request->input('reservation_service')))
            return response()->json(['reservation_service' => ['O integrante selecionado não realiza este serviço.']], 422);

        // Check if there is a holiday
        if($this->IsHoliday($request->input('reservation_slot')))
            return response()->json(['reservation_holiday' => ['The selected date is a non-working day']], 422);

        $reservation_end = $this->CalculateSlotEndTime($request->input('reservation_slot'), $request->input('reservation_service'));
        $service_title = $this->GetServiceTitle($request->input('reservation_service'));

        $reservation = new Reservations();
        $reservation->user_id = $this->GetUser();
        $reservation->user_res = $request->input('reservation_user');
        $reservation->customer = $request->input('reservation_customer');
        $reservation->price = $this->GetServicePrice($request->input('reservation_service'));
        $reservation->service = $service_title;
        $reservation->start = $request->input('reservation_slot');
        $reservation->end = $reservation_end;
        $reservation->save();

        $profile = Profile::where('id', '=', $request->input('reservation_user'))->first();
        $start = new \DateTime($request->input('reservation_slot'));
        $end = new \DateTime($reservation_end);
        $end->modify("+1 second");

        $settings = Settings::where('user_id', '=', $this->GetUser())->first();

        if(empty($settings)) {
            $settings = new \stdClass();
            $settings->time_format = 1;
        }

        $start_t = ($settings->time_format == 1) ? $start->format('h:ia') : $start->format('H:i');
        $end_t = ($settings->time_format == 1) ? $end->format('h:ia') : $end->format('H:i');

        return response()->json(array(
            'success' => true,
            'data' => array(
                'service' => $service_title,
                'name'=> $profile->name . ' ' . $profile->surname,
                'profile_image' => $profile->profile_image,
                'occupation' => $profile->occupation,
                'date' => $start->format('Y/m/d'),
                'time' => $start_t . ' - ' . $end_t
            ),
            'msg' => 'The term was added.'
        ), 200);

    }

    private function GetServicePrice($id)
    {
        $service = Services::where('id', '=', $id)->first();
        return $service->price;
    }

    private function GetServiceTitle($service_id)
    {
        $service = Services::where('id', '=', $service_id)->first();

        return $service ? $service->title : 'Unknown Service';
    }
    private function IsHoliday($day)
    {

        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $day);
        $dates_day = $datetime->format('Y-m-d');

        $holiday = Holidays::whereDate('holiday', $dates_day)->where('user_id', '=', $this->GetUser())->first();

        return $holiday ? true : false;

    }
    private function UserHasService($user, $service)
    {
        $has_service = MyServices::where(
            [
                ['user_res', '=', $user],
                ['service_id', '=', $service]
            ]
        )->first();

        return $has_service ? true : false;
    }
}
