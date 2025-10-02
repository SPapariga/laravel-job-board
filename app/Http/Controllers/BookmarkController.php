<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Job;


class BookmarkController extends Controller
{
    // @desc Get all users bookmarks
    // @route Get /bookmarks
    public function index() : View
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarkedJobs()->paginate(9);
        return view('jobs.bookmarked')->with('bookmarks', $bookmarks);
    }

    // @desc Create new bookmark
    // @route POST /bookmarks/job
    public function store(Job $job) : RedirectResponse
    {
        $user = Auth::user();
        //Check if job is already bookmarked
        if($user->bookmarkedJobs()->where('job_id',$job->id)->exists()){
            return back()->with('success','Job is already bookmarked');
        }

        $user->bookmarkedJobs()->attach($job->id);
        return back()->with('success','Job bookmarked successfully!');
    }

    // @desc Remove bookmark
    // @route DELETE /bookmarks/job
    public function destroy(Job $job) : RedirectResponse
    {
        $user = Auth::user();
        //Check if job is already bookmarked
        if(!$user->bookmarkedJobs()->where('job_id',$job->id)->exists()){
            return back()->with('error','Job is not bookmarked');
        }

        $user->bookmarkedJobs()->detach($job->id);
        return back()->with('success','Bookmark removed successfully!');
    }
}
