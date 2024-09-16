<?php

namespace App\Http\Controllers\api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ServicesCategories;
use App\Services;
use App\Settings;
use App\Reservations;
use App\WorkHours;
use App\Profile;
use App\MyServices;
use App\WorkTime;
use App\Vacations;
use App\Websites;
use App\Holidays;

use App\Helpers\Helpers;
use Validator;

class ReservationsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->site_id = Helpers::GetSiteId($request->site);
        $this->template = Helpers::GetSiteTemplate($request->site);
    }

    private function GetSettingsData()
    {
        $settings = Settings::
        select(
            'company',
            'address',
            'city',
            'zip',
            'site_email',
            'site_phone',
            'booking',
            'currency_sign',
            'area_code',
            'currency_format',
            'time_format'
        )
        ->where('site', '=', $this->site_id)->first();

        if(!$settings)
        {
            $settings = new \StdClass();
            $settings->company = null;
            $settings->address = null;
            $settings->city = null;
            $settings->zip = null;
            $settings->site_email = null;
            $settings->site_phone = null;
            $settings->booking = 4;
            $settings->currency_sign = '$';
            $settings->area_code = 15;
            $settings->currency_format = 1;
            $settings->time_format = 1;
        }

        return $settings;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = ServicesCategories::where('user', '=', $this->site_id)->get();
        $info = $this->GetSettingsData();

        $cats = array();

        foreach($categories as $cat)
        {
            $services = Services::select('id', 'title', 'description', 'price', 'duration')->where(
                [
                    ['user', '=', $this->site_id],
                    ['category', '=', $cat->id]
                ]
            )->get();

            foreach($services as $key=>$service)
            {
                $hours = explode(':', $service->duration);
                $services[$key]->hours = (int)$hours[0];
                $services[$key]->minutes = (int)$hours[1];
                $services[$key]->price = $info->currency_sign.Helpers::FormatPrice($info->currency_format, $service->price);
                unset($services [$key]->duration);

            }


            $cats[] = array(
                'title' => $cat->title,
                'services' => $services,
                'num' => $services->count()
            );
        }

        


        $employees = Profile::select('name', 'surname', 'profile_image')->where('id', '=', $this->site_id)->orWhere('member', '=', $this->site_id)->get();
/*
        $website_data = Websites::where('site', '=', $this->site_id)->first();

        if(!$website_data)
        {
            $website_data = new \StdClass();
            $website_data->logo = null;
            $website_data->facebook = null;
            $website_data->twitter = null;
            $website_data->instagram = null;
            $website_data->color = 4;
            $website_data->address = null;
        }

        $settings = Settings::where('site', '=', $this->site_id)->first();

        if(!$settings)
        {
            $settings = new \StdClass();
            $settings->company = null;
            $settings->address = null;
            $settings->city = null;
            $settings->zip = null;
            $settings->site_email = null;
            $settings->site_phone = null;
            $settings->booking = 4;
            $settings->currency_sign = '$';
            $settings->area_code = 15;
            $settings->currency_format = 1;
            $settings->time_format = 1;
        }

        */
        $start_date = new \DateTime('now');
        $end_date = new \DateTime('now');
        $end_date->add(new \DateInterval($this->GetInterval($info->booking)));


        return response()->json([
            'categories'=>$cats,
            'employees' => $employees,
            'date_start' => $start_date->format('m/d'),
            'date_end' => $end_date->format('Y/m/d')
        ], 200);
    }

    public function days() {
        $days = $this->ListDaysBySetting();
        return response()->json($days, 200);
    }

    public function ListDaysBySetting()
    {

        $settings = Settings::where('site', '=', $this->site_id)->first();

        $string = $settings ? $settings->booking : 'x';

        $string = $this->GetInterval($string);

        $todays_date = new \DateTime('now');
        $today_date = $todays_date->format('Y-m-d H:i:s');
        $dates = Reservations::where('site', '=', $this->site_id)->where('start', '>=', $today_date)->get();

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

        $working_day = WorkHours::where('site', '=', $this->site_id)->first();

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
        
        $holidays = Holidays::where('site', '=', $this->site_id)->get();
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
            case 1 : return __('site.days_mon'); break;
            case 2 : return __('site.days_tue'); break;
            case 3 : return __('site.days_wed'); break;
            case 4 : return __('site.days_thu'); break;
            case 5 : return __('site.days_fri'); break;
            case 6 : return __('site.days_sat'); break;
            case 7 : return __('site.days_sun'); break;
            default : return '';
        }
    }
    private function GetMonthName($month) {

        switch($month) {
            case 1 : return __('site.months_jan'); break;
            case 2 : return __('site.months_feb'); break;
            case 3 : return __('site.months_mar'); break;
            case 4 : return __('site.months_apr'); break;
            case 5 : return __('site.months_may'); break;
            case 6 : return __('site.months_jun'); break;
            case 7 : return __('site.months_jul'); break;
            case 8 : return __('site.months_aug'); break;
            case 9 : return __('site.months_sep'); break;
            case 10 : return __('site.months_oct'); break;
            case 11 : return __('site.months_nov'); break;
            case 12 : return __('site.months_dec'); break;
            default : return '';
        }
    }

    private function CheckUserHasServiceRights($user, $service)
    {
        return Services::where('user', '=', $user)->where('id', '=', $service)->first();
    }
    private function GetEmployeesData($date, $service)
    {
        // Drop everything if there is non-working day
        $datetime = \DateTime::createFromFormat('Y-m-d', $date);
        $dates_day = $datetime->format('D');

        $working_day = WorkHours::where('site', '=', $this->site_id)->first();

        if($working_day)
        {
            $closed_column = strtolower($dates_day) . '_closed';

            if($working_day->$closed_column)
            return [];
        }

        // Drop everything if there is a holiday
        $holiday = Holidays::whereDate('holiday', $date)->where('site', '=', $this->site_id)->first();

        if($holiday)
            return [];

        // Set the main array where we will store employees
        $employees = array();

        // Check which employees are offering the service
        $get_employees_of_service = MyServices::select('my_services.user')
        ->leftJoin('users', 'my_services.user', '=', 'users.id')
        ->where('users.deleted_at', null)
        ->where('my_services.service', '=', $service)->get();
        

        if(!$get_employees_of_service)
            return [];

        $employees_of_service = array();

        foreach($get_employees_of_service as $employee)
        {
            $employees_of_service[] = $employee->user;
        }

        
        // Check if employees work on selected date and store them in array
        $working = WorkTime::select('work_times.user')
            ->distinct('work_times.user')
            ->leftJoin('users', 'work_times.user', '=', 'users.id')
            ->where('users.deleted_at', null)
            ->whereIn('work_times.user', $employees_of_service)
            ->whereDate('work_times.date_from', '<=', $date)
            ->whereDate('work_times.date_to', '>=', $date)
            ->get();



        foreach($working as $work)
        {
            $employees[] = $work->user;
        }

        // Check which employees have vacations and exclude them from array
        $vacations = Vacations::select('user')
            ->distinct()
            ->whereIn('user', $employees_of_service)
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



            $employee_work_time = WorkTime::
                where('user', '=', $employee)
                ->whereDate('date_from', '<=', $date)
                ->whereDate('date_to', '>=', $date)
                ->first();                


            // Employee start and end time of the day
            $employee_work_time_start = new \DateTime($date.' '.$employee_work_time->time_from);
            $employee_work_time_start_format = $employee_work_time_start->format('H:i');
            
            $employee_work_time_end = new \DateTime($date.' '.$employee_work_time->time_to);
            $employee_work_time_end_format = $employee_work_time_end->format('H:i');


            // Fill unavailables
            $reservations = Reservations::where('user', '=', $employee)
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
            where('user', '=', $employee)
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
    /* Return setting if only first available slot is shown */
    private function GetSlotMode() {

        $settings = Settings::where('site', '=', $this->site_id)->first();

        if(!$settings)
            return false;

        return $settings->slot_mode == 1 ? false : true;

    }
    public function GetTerms(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'service' => 'required|integer|exists:services,id'
        ]);

        if ($validator->fails()) {
            return response()->json([]);
        }  
        
        // Check if user has the right to the service
        if(!$this->CheckUserHasServiceRights($this->site_id, $request->service))
            return response()->json([]);

        
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
            return response()->json([]);

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
        
        $slots = [];
        $onlyfirst = $this->GetSlotMode();
        $settings = $this->GetSettingsData();

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
                    $slots[$time]['iso'] = $time_obj->format('Y-m-d H:i:s');
                    $slots[$time]['visual'] = $settings->time_format == 1 ? $time_obj->format('h:ia') : $time_obj->format('H:i');
                    $slots[$time]['employees'][] = $employee['id'];
                    
                    // if only first slot mode is available is on
                    if($onlyfirst) {
                        break;
                    }
                    
                }
                    
            }
            
            
        } 

        ksort($slots);

        $data = array(
            'employees' => $employees_data,
            'slots' => $slots
        );

        return response()->json($data);
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
        return response()->json(['reservation_slot' => ['Choosen term is not available anymore. It could be taken in the meanwhile.']], 422);

        // Check if user has reservation service
        if(!$this->UserHasService($request->input('reservation_user'), $request->input('reservation_service')))
            return response()->json(['reservation_service' => ['Selected employee does not perform this service.']], 422);

        // Check if there is a holiday
        if($this->IsHoliday($request->input('reservation_slot')))
            return response()->json(['reservation_holiday' => ['The selected date is a non-working day']], 422);
    
        $reservation_end = $this->CalculateSlotEndTime($request->input('reservation_slot'), $request->input('reservation_service'));
        $service_title = $this->GetServiceTitle($request->input('reservation_service'));
        $service_price = $this->GetServicePriceFormatted($request->input('reservation_service'));

        $reservation = new Reservations();
        $reservation->site = $this->site_id;
        $reservation->user = $request->input('reservation_user');
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

        $settings = Settings::where('site', '=', $this->site_id)->first();

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
                'service_price' => $service_price,
                'name'=> $profile->name . ' ' . $profile->surname,
                'profile_image' => $profile->profile_image,
                'occupation' => $profile->occupation,
                'date' => $start->format('Y/m/d'),
                'time' => $start_t . ' - ' . $end_t
            ), 
            'msg' => 'Termin je bil dodan.'
        ), 200);

    }

    private function GetServicePrice($id)
    {
        $service = Services::where('id', '=', $id)->first();
        return $service->price;
    }

    private function GetServicePriceFormatted($id)
    {
        $service = Services::where('id', '=', $id)->first();
        $info = $this->GetSettingsData();
        return $info->currency_sign.Helpers::FormatPrice($info->currency_format, $service->price);
    }

    private function SlotFree($start, $service, $user)
    {
        
        $startTime = $start;
        $endTime = $this->CalculateSlotEndTime($start, $service);

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
        })->where('user', '=', $user)->count();

        if($count)
            return true;

        
        // Check between vacation dates for user
        $vacation_times_for_user = Vacations::where('user', '=', $user)->first();

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
 

        $startTime_t = \DateTime::createFromFormat('Y-m-d H:i:s', $startTime);
        $endTime_t = \DateTime::createFromFormat('Y-m-d H:i:s', $endTime);


                // Get work times
                $work_times_for_user = WorkTime::
                    whereDate('date_from', '<=', $startTime_t->format('Y-m-d'))
                    ->whereDate('date_to', '>=', $startTime_t->format('Y-m-d'))
                    ->where('user', '=', $user)
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
        $work_hours = WorkHours::where('site', '=', $this->site_id)->first();

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
    
    private function GetServiceTitle($service_id)
    {
        $service = Services::where('id', '=', $service_id)->first();

        return $service ? $service->title : 'Unknown service';
    }
    private function UserHasService($user, $service)
    {
        $has_service = MyServices::where(
            [
                ['user', '=', $user],
                ['service', '=', $service]
            ]
        )->first();

        return $has_service ? true : false;
    }

    private function IsHoliday($day)
    {
        
        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $day);
        $dates_day = $datetime->format('Y-m-d');

        $holiday = Holidays::whereDate('holiday', $dates_day)->where('site', '=', $this->site_id)->first();

        return $holiday ? true : false;

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
    public function show(Bills $bills, $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function edit(Bills $bills, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bills $bills, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bills $bills, $id)
    {
    }


}
