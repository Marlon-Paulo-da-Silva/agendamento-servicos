<?php

namespace App\Http\Controllers\app;

use App\Models\Settings;
use App\Models\Profile;
use App\Models\Websites;
use App\Models\Photos;
use App\Models\Services;
use App\Models\WorkHours;
use App\Models\ServicesCategories;
use App\Models\Reviews;
use App\Models\Customers;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\Contact;



class IndexController extends Controller
{
    private $site_id;
    private $account_data = array();
    private $template;
    private $url;
    private $email;

    public function __construct(Request $request)
    {
        $request->site = parse_url($request->url(), PHP_URL_HOST);
        // TODO descomentar depois
        // $this->template = Helpers::GetSiteTemplate($request->site);
        $this->template = "default";
        $this->site_id = Helpers::GetSiteId($request->site);
        // $this->email = Helpers::GetAdminEmail($request->site);
    }


    public function indexSub(Request $request, $account)
    {
        // TODO teste index
        // echo "<pre>";
        // echo "Subdominio que veio para o controller<br>";
        // print_r($account);
        // print_r($request->site);
        // echo "</pre>";
        // exit();

        // $this->account_data = $this->GetAccountData($account);

        // $this->site_id = Helpers::GetSiteId($request->site);
        // $this->template = Helpers::GetSiteTemplate($request->site);
        // $this->email = Helpers::GetAdminEmail($request->site);

        $website_data = $this->GetSubdomainData($account);

        if(!$website_data->user_id){
            return redirect('/');
        }

        $this->site_id = $website_data->user_id;

        // echo "<pre>";
        // print_r($website_data);
        // echo "</pre>";
        // exit();

        // $website_data = new \StdClass();
        // $website_data->logo = 'https://codeland.fun/images/logos/dbbd493ccda436f0f60d5f33a3e0849ee15dc159.png';
        // $website_data->title = null;
        // $website_data->address = null;
        // $website_data->facebook = null;
        // $website_data->twitter = null;
        // $website_data->instagram = null;
        // $website_data->color = 4;
        // $website_data->address = null;

        // $photos = new \StdClass();
        // $photos->photo_1 = 'image-salon.jpeg';
        // $photos->photo_2 = 'image-salon.jpeg';
        // $photos->photo_3 = 'image-salon.jpeg';
        // $photos->photo_4 = 'image-salon.jpeg';
        // $photos->photo_5 = 'image-salon.jpeg';
        // $photos->photo_6 = 'image-salon.jpeg';
        // $photos->photo_7 = 'image-salon.jpeg';
        // $photos->photo_8 = 'image-salon.jpeg';
        // $photos->photo_9 = 'image-salon.jpeg';
        // $photos->photo_10 = 'image-salon.jpeg';

        // $settings = new \StdClass();
        // $settings->company = null;
        // $settings->address = null;
        // $settings->city = null;
        // $settings->zip = null;
        // $settings->site_email = null;
        // $settings->site_phone = null;
        // $settings->booking = 4;
        // $settings->currency_sign = '$';
        // $settings->area_code = 15;
        // $settings->currency_format = 1;

        // return view('app.templates.' . $this->template . '.site.index.index', [
        //     'site_id' => 'site_id',
        //     'website' => $website_data,
        //     'colors' => Helpers::Colors(2),
        //     'info' => $settings,

        //     'photos' => $photos
        // ]);

        return view('app.templates.' . $this->template . '.site.index.index', [
            'site_id' => $request->site,
            'website' => $website_data,
            'colors' => Helpers::Colors(2),
            'info' => $this->GetSettingsData(),
            'photos' => $this->GetPhotosData()
        ]);

    }

    private function GetSubdomainData($account)
    {
        $website_data = Websites::where('subdomain', '=', $account)->first();

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
            $website_data->address = null;
            $website_data->user_id = null;
        }

        return $website_data;
    }

    private function GetWebsiteData($domain)
    {
        $website_data = Websites::where('domain', '=', $domain)->first();

        if(!$website_data)
        {
            $website_data = new \StdClass();
            $website_data->logo = null;
            $website_data->title = null;
            $website_data->address = null;
            $website_data->facebook = null;
            $website_data->twitter = null;
            $website_data->instagram = null;
            $website_data->color = 2;
            $website_data->address = null;
        }

        return $website_data;
    }



    private function GetAccountData()
    {
        $website_data = Websites::where('user_id', '=', $this->site_id)->first();

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
            $website_data->address = null;
        }

        return $website_data;
    }

    private function GetSettingsData()
    {
        $settings = Settings::where('user_id', '=', $this->site_id)->first();

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
        $photos = Photos::where('user_id', '=', $this->site_id)->first();
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

        return $photos;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO teste index


        if(Helpers::verifiyDomainSystem($request->getHost())){
            echo "<pre>";
            echo "Domínio do sistema";
            echo "</pre>";
            exit();
        }

        if(!Helpers::verifiyDomainSystem($request->getHost())){

            $this->site_id = Helpers::GetSiteId($request->getHost());

            $website_data = $this->GetWebsiteData($request->getHost());

            return view('app.templates.' . $this->template . '.site.index.index', [
                'site_id' => $this->site_id,
                'website' => $website_data,
                'colors' => Helpers::Colors(2),
                'info' => $this->GetSettingsData
                (),
                'photos' => $this->GetPhotosData()
            ]);

        }




    }



    public function aboutUsSub(Request $request, $account)
    {

        $website_data = $this->GetSubdomainData($account);

        if(!$website_data->user_id){
            return redirect('/');
        }

        $this->site_id = $website_data->user_id;

        $employees = Profile::
            where(function($query) {
                $query->where('id', '=', $this->site_id)
                    ->orWhere('user_id', '=', $this->site_id);
            })
            // ->where('include_profile', '=', 1)
            ->get();

        // $website_data = $this->GetWebsiteData();

        return view('app.templates.' . $this->template . '.site.about_us.index', [
        // return view('app.templates.default.site.about_us.index', [
            'site_id' => $request->site,
            'website' => $website_data,
            // 'colors' => ['#000000', '#000000'],
            'colors' => Helpers::Colors(2),
            'info' => $this->GetSettingsData(),
            'employees' => $employees
        ]);
    }

    public function aboutUs(Request $request)
    {

        $employees = Profile::
            where(function($query) {
                $query->where('id', '=', $this->site_id)
                    ->orWhere('user_id', '=', $this->site_id);
            })
            // ->where('include_profile', '=', 1)
            ->get();

        $website_data = $this->GetWebsiteData($request->getHost());

        return view('app.templates.' . $this->template . '.site.about_us.index', [
            'site_id' => $request->site,
            'website' => $website_data,
            'colors' => Helpers::Colors(2),
            'info' => $this->GetSettingsData(),
            'employees' => $employees
        ]);
    }

    public function recensions(Request $request)
    {


        $website_data = $this->GetWebsiteData($request->getHost());

        $reviews = Reviews::where('user_id', '=', $this->site_id)
            ->where('status', '=', 2)
            ->get();


        $review_count = Reviews::select(DB::raw('count(*) as ct'))
            ->where('user_id', '=', $this->site_id)
            ->where('status', '=', 2)
            ->first();


        $avg_vote = Reviews::select(DB::raw('AVG(vote) as vote'))
            ->where('user_id', '=', $this->site_id)
            ->where('status', '=', 2)
            ->first();

        $one = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 1)
        ->first();

        $two = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 2)
        ->first();

        $three = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 3)
        ->first();

        $four = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 4)
        ->first();

        $five = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', $this->site_id)
        ->where('status', '=', 2)
        ->where('vote', '=', 5)
        ->first();

        return view('app.templates.' . $this->template . '.site.recensions.index', [
            'site_id' => $request->site,
            'website' => $website_data,
            'colors' => Helpers::Colors($website_data->color),
            'info' => $this->GetSettingsData(),
            'reviews' => $reviews,
            'review_count' => $review_count,
            'avg_vote' => $avg_vote,
            'one' => $one,
            'two' => $two,
            'three' => $three,
            'four' => $four,
            'five' => $five
        ]);
    }

    public function contact(Request $request)
    {

        $website_data = $this->GetWebsiteData($request->getHost());

        return view('app.templates.' . $this->template . '.site.contact.index', [
            'site_id' => $request->site,
            'website' => $website_data,
            'colors' => Helpers::Colors($website_data->color),
            'info' => $this->GetSettingsData()
        ]);
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

        $work_time = WorkHours::where('user_id', '=', $this->site_id)->first();

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
            }
        }

        $website_data = $this->GetWebsiteData($request->getHost());

        return view('app.templates.' . $this->template . '.site.work_time.index', [
            'site_id' => $request->site,
            'website' => $website_data,
            'colors' => Helpers::Colors($website_data->color),
            'info' => $this->GetSettingsData(),
            'times' => $work_time
        ]);
    }

    public function services(Request $request)
    {

        $categories = ServicesCategories::where('user_id', '=', $this->site_id)->get();

        $cats = array();

        foreach($categories as $cat)
        {
            $services = Services::where(
                [
                    ['user_id', '=', $this->site_id],
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


        return view('app.templates.' . $this->template . '.site.services.index', [
            'site_id' => $request->site,
            'website' => $this->GetWebsiteData($request->getHost()),
            'colors' => Helpers::Colors($this->GetWebsiteData($request->getHost())->color),
            'info' => $this->GetSettingsData(),
            'categories' => $cats
        ]);
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
