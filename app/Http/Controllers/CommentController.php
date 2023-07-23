<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;
use App\Http\Requests\Comment\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CommentController extends Controller
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
     * @param  \App\Http\Requests\Comment\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, $pid, $tid)
    {
        $data = $request->validated();
        
        $comment = new Comment;

        $comment->ticket_id = $tid;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $data['comment'];

        $comment->save();

        return redirect()->route('ticket.show', ['pid' => $pid, 'tid' => $tid] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->comment = $request->input('comment');
        
        $comment->save();

        $id = $comment->id;
        
        $redirectUrl = URL::previous() . "#comment-$id";
        
        return redirect($redirectUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(comment $comment)
    {
        $comment->delete();
        
        return redirect()->back();
    }
}
