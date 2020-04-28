<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vote;
class VotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $value = $request->value;
        $postId = $request->post_id;
        $userId = auth()->user()->id;
        //check to see if user has an existing vote
        $vote = Vote::where('user_id',auth()->user()->id)->where('post_id',$postId)->first();
        if(!$vote){
            //first vote for user
            $vote = new Vote();
            $vote->value = $value;
            $vote->user_id = $userId;
            $vote->post_id = $postId;
            $vote->save();
        }else{
            //consecutive votes for user
            $vote->value == $value ? $vote->delete() : $vote->update(['value' => $value]);
        }
        
        //return number of votes for a post
        $numVotes = Vote::where('post_id',$request->post_id)->where('value',1)->count() - Vote::where('post_id',$request->post_id)->where('value',-1)->count();
        return response()->json(['numVotes'=>$numVotes, 'userVote'=>$value]);
        // return back()->with('success');
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
