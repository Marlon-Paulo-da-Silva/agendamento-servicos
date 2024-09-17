<?php

namespace App\Http\Controllers\admin;

use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reviews = Reviews::where('user_id', '=', Auth::id())->where('status', '=', 1)->get();

        foreach($reviews as $key=>$review)
        {
            $created = new \DateTime($review->created);
            $reviews[$key]->created = $created->format('d.m.Y H:i');
            $reviews[$key]->review = Str::limit($review->review, 75);
        }

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'request' => $request,
            'statuses' => $this->GetStatuses()
        ]);
    }

    public function bin(Request $request)
    {
        $reviews = Reviews::where('user_id', '=', Auth::id())->where('status', '=', 3)->get();

        foreach($reviews as $key=>$review)
        {
            $created = new \DateTime($review->created);
            $reviews[$key]->created = $created->format('d.m.Y H:i');
        }

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'request' => $request,
            'statuses' => $this->GetStatuses()
        ]);
    }

    public function approved(Request $request)
    {
        $reviews = Reviews::where('user_id', '=', Auth::id())->where('status', '=', 2)->get();

        foreach($reviews as $key=>$review)
        {
            $created = new \DateTime($review->created);
            $reviews[$key]->created = $created->format('d.m.Y H:i');
        }

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'request' => $request,
            'statuses' => $this->GetStatuses()
        ]);
    }

    private function GetStatuses()
    {
        $waiting = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', Auth::id())
        ->where('status', '=', 1)
        ->first();

        $bin = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', Auth::id())
        ->where('status', '=', 3)
        ->first();

        $approved = Reviews::select(DB::raw('count(*) as ct'))
        ->where('user_id', '=', Auth::id())
        ->where('status', '=', 2)
        ->first();

        $return = new \StdClass();
        $return->waiting = $waiting->ct;
        $return->bin = $bin->ct;
        $return->approved = $approved->ct;

        return $return;

    }

    public function changeStatus(Request $request)
    {

        $review = Reviews::where('user_id', '=', Auth::id())->where('id', '=', $request->id)->firstorFail();
        $review->status = $request->status;
        $review->save();

        return redirect()->back();
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
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviews $reviews, Request $request)
    {
        $review = Reviews::where('user_id', '=', Auth::id())->findOrFail($request->id);

        return view('admin.reviews.edit', ['review' => $review, 'id' => $request->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviews $reviews)
    {
        $validator = Validator::make($request->all(), [
            'recension_impression' => 'required|string|max:255',
            'recension_name' => 'required|string|max:255',
            'recension_city' => 'required|string|max:255',
            'recension_review' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/reviews/edit/' . $request->id)
                        ->withErrors($validator)
                        ->withInput($request->all());
        }


        $review = Reviews::where('user_id', '=', Auth::id())->findOrFail($request->id);
        $review->impression = $request->input('recension_impression');
        $review->name = $request->input('recension_name');
        $review->city = $request->input('recension_city');
        $review->review = $request->input('recension_review');
        $review->save();

        return redirect('/admin/reviews');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviews $reviews)
    {
        //
    }
}
