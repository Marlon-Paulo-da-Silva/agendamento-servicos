<?php

namespace App\Http\Controllers\api;

use App\Settings;
use App\Profile;
use App\Websites;
use App\Photos;
use App\Services;
use App\WorkHours;
use App\ServicesCategories;
use App\Reviews;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\Contact;
use App\PhoneAreaCodes;

class IndexController extends Controller
{
    public function __construct(Request $request)
    {
        $this->site_id = Helpers::GetSiteId($request->site);
        $this->template = Helpers::GetSiteTemplate($request->site);
        $this->email = Helpers::GetAdminEmail($request->site);
    }

    private function GetWebsiteData()
    {
        $website_data = Websites::
        select(
            'logo',
            'title',
            'address',
            'facebook',
            'twitter',
            'instagram',
            'color'
        )
        ->where('site', '=', $this->site_id)->first();

        if(!$website_data)
        {
            $website_data = new \StdClass();
            $website_data->logo = null;
            $website_data->title = null;
            $website_data->address = null;
            $website_data->facebook = null;
            $website_data->twitter = null;
            $website_data->instagram = null;
            $website_data->color = 4;
        }

        return $website_data;
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
            'currency_format'
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
        }

        return $settings;
    }

    private function GetPhotosData()
    {
        $photos = Photos::
        select(
            'photo_1',
            'photo_2',
            'photo_3',
            'photo_4',
            'photo_5',
            'photo_6',
            'photo_7',
            'photo_8',
            'photo_9',
            'photo_10',
        )
        ->where('site', '=', $this->site_id)->first();
        if(!$photos)
        {
            $photos = new \StdClass();
            $photos->photo_1 = null;
            $photos->photo_2 = null;
            $photos->photo_3 = null;
            $photos->photo_4 = null;
            $photos->photo_5 = null;
            $photos->photo_6 = null;
            $photos->photo_7 = null; 
            $photos->photo_8 = null;
            $photos->photo_9 = null;
            $photos->photo_10 = null;           

        }

        $images = [];
        for($i=1; $i<=10; $i++)
        {
            $name = "photo_".$i;
            if($photos->$name)
                $images[] = $photos->$name;
        }

        return $images;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $website_data = $this->GetWebsiteData();

        $array = [
            'website' => $website_data,
            'colors' => Helpers::Colors($website_data->color),
            'info' => $this->GetSettingsData(),
            'photos' => $this->GetPhotosData()
        ];

        return response()->json($array, 200);

    }

    public function aboutUs(Request $request)
    {

        $employees = Profile::
            select('profile_image', 'name', 'surname', 'occupation', 'area_code', 'phone', 'about')
            ->where(function($query) {
                $query->where('id', '=', $this->site_id)
                    ->orWhere('member', '=', $this->site_id);
            })
            ->where('include_profile', '=', 1)
            ->get();

        return response()->json($employees, 200);
    }

    public function GetAreaCodes() {
        
        $settings = $this->GetSettingsData();
        $area_codes = PhoneAreaCodes::get();

        $array = [
            'selected' => $settings->area_code,
            'area_codes' => $area_codes
        ];

        return response()->json($array, 200);
    }

    public function recensions(Request $request)
    {


        $website_data = $this->GetWebsiteData();

        $reviews = Reviews::where('site', '=', $this->site_id)
            ->where('status', '=', 2)
            ->get();


        $review_count = Reviews::select(DB::raw('count(*) as ct'))
            ->where('site', '=', $this->site_id)
            ->where('status', '=', 2)
            ->first();


        $avg_vote = Reviews::select(DB::raw('AVG(vote) as vote'))
            ->where('site', '=', $this->site_id)
            ->where('status', '=', 2)
            ->first();

        $one = Reviews::select(DB::raw('count(*) as ct'))
        ->where('site', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 1)
        ->first();

        $two = Reviews::select(DB::raw('count(*) as ct'))
        ->where('site', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 2)
        ->first();

        $three = Reviews::select(DB::raw('count(*) as ct'))
        ->where('site', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 3)
        ->first();

        $four = Reviews::select(DB::raw('count(*) as ct'))
        ->where('site', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 4)
        ->first();

        $five = Reviews::select(DB::raw('count(*) as ct'))
        ->where('site', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 5)
        ->first();

        $arr = array(
            'reviews' => $reviews,
            'review_count' => $review_count->ct,
            'avg_vote' => (float)$avg_vote->vote,
            'one' => round(($one->ct / ($review_count->ct ? $review_count->ct : 1)) * 100),
            'two' => round(($two->ct / ($review_count->ct ? $review_count->ct : 1)) * 100),
            'three' => round(($three->ct / ($review_count->ct ? $review_count->ct : 1)) * 100),
            'four' => round(($four->ct / ($review_count->ct ? $review_count->ct : 1)) * 100),
            'five' => round(($five->ct / ($review_count->ct ? $review_count->ct : 1)) * 100)
        );

        return response()->json($arr, 200);
        
    }

    public function mail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_subject' => 'required|string|max:255',
            'contact_message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        Mail::to($this->email)
        ->send(
            new Contact(
                $request->input('contact_name'), 
                $request->input('contact_subject'),
                $request->input('contact_email'), 
                $request->input('contact_message')
            )
        );

        return response()->json(array('success' => true, 'msg' => 'Thank you! Your message has been sent.'), 200);

    }

    public function recension(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recension_rating' => 'required|integer|min:1|max:5',
            'recension_impression' => 'required|string|max:255',
            'recension_name' => 'required|string|max:255',
            'recension_city' => 'required|string|max:255',
            'recension_review' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $review = new Reviews();
        $review->site = $this->site_id;
        $review->vote = (int)$request->input('recension_rating');
        $review->impression = $request->input('recension_impression');
        $review->name = $request->input('recension_name');
        $review->city = $request->input('recension_city');
        $review->review = $request->input('recension_review');

        $created = new \DateTime();
        $review->created = $created->format('Y-m-d H:i:s');
        $review->save();

        return response()->json(array('success' => true, 'msg' => 'Thank you! Your recensions is being reviewed.'), 200);

    }

    public function workTime(Request $request)
    {

        $work_time = WorkHours::where('site', '=', $this->site_id)->first();
        
        $days = array(
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
            'sat',
            'sun'
        );

        if(!$work_time)
        {
            $work_time = new \StdClass();

            foreach($days as $day)
            {
                $from = $day.'_from';
                $to = $day.'_to';
                $closed = $day.'_closed';

                $work_time->$from = null;
                $work_time->$to = null;
                $work_time->$closed = null;
            }

        } else {

            foreach($days as $day)
            {
                $from = $day.'_from';
                $to = $day.'_to';

                if($work_time->$from)
                {
                    $time_from = new \DateTime($work_time->$from);
                    $time_from_f = $time_from->format('H:i');
                } else {
                    $time_from_f = null;
                }
                

                if($work_time->$from)
                {
                    $time_to = new \DateTime($work_time->$to);
                    $time_to_f = $time_to->format('H:i');
                } else {
                    $time_to_f = null;
                }

                $work_time->$from = $time_from_f;
                $work_time->$to = $time_to_f;
                unset($work_time->id);
                unset($work_time->site);
            }
        }

        return response()->json($work_time, 200);
    }

    public function services(Request $request)
    {

        $categories = ServicesCategories::where('user', '=', $this->site_id)->get();
        $info = $this->GetSettingsData();

        $cats = array();

        foreach($categories as $cat)
        {
            $services = Services::select('title', 'description', 'price', 'duration')->where(
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
                'services' => $services
            );
        }

        return response()->json($cats, 200);
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
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit(Customers $customers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
    }
}
