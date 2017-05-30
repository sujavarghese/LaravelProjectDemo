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

    /**
     * Function to return count of all users
     * @return array
     */
    public function get_users()
    {
        return User::count();
    }
    /**
     * Function to return count of ADA boundaries uploaded into Database.
     * @return array
     */
    public function get_ada_count()
    {
        return Boundary::where('boundary_type', '=', 'ADA')->count();
    }
    /**
     * Function to return count of SAM boundaries uploaded into Database.
     * @return array
     */
    public function get_sam_count()
    {
        return Boundary::where('boundary_type', '=', 'SAM')->count();

    }
    /**
     * Function to return 5 boundaries which are recently uploaded into Database.
     * @return array
     */
    public function get_recent_uploads()
    {
        return UsersLog::limit(5)->orderBy('created_at', 'DESC')->get();
    }
    /**
     * Function to return user activity log details.
     * @return array
     */
    public function get_user_activity_log()
    {
        $log_table = UsersLog::all();
        $total_count = count($log_table);
        $valid_upload_count = 0;
        $valid_validate_count = 0;
        $valid_load_count = 0;
        foreach ($log_table as $log_obj) {
            if ($log_obj['upload_status'] == "PASS") {
                $valid_upload_count = $valid_upload_count + 1;
            }
            if ($log_obj['validation_status'] == "VALIDATED") {
                $valid_validate_count = $valid_validate_count + 1;
            }
            if ($log_obj['load_status'] == "PASS") {
                $valid_load_count = $valid_load_count + 1;
            }
        }
        return array(
            'total_count' => $total_count,
            'valid_upload_count' => $valid_upload_count,
            'valid_upload_percentage' => $valid_upload_count * 100 / $total_count,
            'valid_validate_count' => $valid_validate_count,
            'valid_validate_percentage' => $valid_validate_count * 100 / $total_count,
            'valid_load_count' => $valid_load_count,
            'valid_load_percentage' => $valid_load_count * 100 / $total_count
        );
    }
    /**
     * Function to return dashboard details
     * @return array
     */
    public function get_dashboard_details()
    {
        $this->dashboard_data['user_count'] = $this->get_users();
        $this->dashboard_data['ada_count'] = $this->get_ada_count();
        $this->dashboard_data['sam_count'] = $this->get_sam_count();
        $this->dashboard_data['load_stat'] = $this->get_user_activity_log();
        $this->dashboard_data['recent_uploads'] = $this->get_recent_uploads();
    }

    public function index()
    {
        $this->get_dashboard_details();
        return view('home')->with(
            'dashboard_data', $this->dashboard_data
        );
    }
}
