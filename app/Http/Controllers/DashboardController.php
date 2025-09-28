<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

class DashboardController extends Controller
{
    // @desc Show all users job listings
    // @ route GET /dashboard
    public function index() : View{
        //Get logged in user
        $user = Auth::user();

        //Get user listings
        $jobs = Job::where('user_id', $user->id)->get();

        // dd($jobs);
        return view('dashboard.index', compact('user', 'jobs'));
    }
}
