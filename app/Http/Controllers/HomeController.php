<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boundary;
use App\User;
use App\UsersLog;


class HomeController extends Controller
{

    public $user_count = 0;
    public $ada_count = 0;
    public $sam_count = 0;
    public $dashboard_data = array();
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_users()
    {
        return User::count();
    }
    public function get_ada_count()
    {
        return Boundary::where('boundary_type', '=', 'ADA')->count();
    }
    public function get_sam_count()
    {
        return Boundary::where('boundary_type', '=', 'SAM')->count();
    }
    public function get_user_activity_log()
    {
        return UsersLog::all();
    }
    public function get_dashboard_details()
    {
        $this->dashboard_data['user_count'] = $this->get_users();
        $this->dashboard_data['ada_count'] = $this->get_ada_count();
        $this->dashboard_data['sam_count'] = $this->get_sam_count();
    }

    public function index()
    {
        $this->get_dashboard_details();
        return view('home')->with(
            'dashboard_data', $this->dashboard_data
        );
    }
}
