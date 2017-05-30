<?php

namespace App\Classes;

namespace App\Http\Controllers;

use App\Boundary;
use Illuminate\Http\Request;
use Constants;
use GenericConfig;
use App\Http\Requests\LoadBoundaryFormRequest;
use Illuminate\Support\Facades\Storage;
use App\Utilities\DataLoadUtilities;
use DB;
use Input;
use Validator;
use Redirect;
use Session;
use Auth;
use DateTime;
use DateTimeZone;

class BoundariesController extends Controller
{
    public $boundary_msgs = [];
    public $primary_input_boundary = [];
    public $defined_boundary_type = array('SAM', 'ADA');
    public $dataload_utilities;
    public $generic_config;

    public function __construct()
    {
        $this->dataload_utilities = new DataLoadUtilities();
        $this->generic_config = new GenericConfig();
        parent::__construct();
    }

    /**
     * Function to get boundary names
     * @param string $boundary_type: Boundary type argument default is SAM
     * @return mixed
     */
    public function get_sam_names(Request $r)
    {
        $bType = $r->get('boundaryType');
        if(!$bType) {
            $bType = 'SAM';
        }
        $sam_names = Boundary::where('boundary_type', $bType)->pluck('boundary_name')->toArray();
        $response = array(
            '' => '',
        );

        for ($i = 0, $c = count($sam_names); $i < $c; $i += 1) {
            $response[$sam_names[$i]] = $sam_names[$i];
        }

        return $response;
    }

    public function index()
    {
        $response = array(
            'sam_names' => $this->dataload_utilities->get_default_sams(),
        );

        return view('boundaries.boundaryLoader')->with('response', $response);
    }

    /**
     * Function to load data into DB
     * @param $file : Upload file
     * @return bool
     */
    public function load($file, $primary_input_boundary, $boundary_msgs, $detail)
    {
        $fileType = $this->dataload_utilities->get_file_type($file);
        if ($fileType == 'KML') {
            return $this->dataload_utilities->read_kml_data($file, $primary_input_boundary, $boundary_msgs, $detail);
        } else {
            return $this->dataload_utilities->read_csv_data($file, $primary_input_boundary, $boundary_msgs);
        }

    }

    /**
     * Function to store uploaded boundary data
     * @param Request $r
     * @return Redirect to boundary loader
     */
    public function create(Request $r)
    {
        /**
         * Form validation
         */
        $this->validate($r, [
            'boundaryCsvFile' => 'required',
            'selBoundaryType' => 'required',
            'selBoundaryName' => 'required',
        ], [], [
                'boundaryCsvFile' => 'Boundary File',
                'selBoundaryType' => 'Boundary Type',
                'selBoundaryName' => 'Boundary Name',
            ]
        );
        $created_at = new DateTime('now', new DateTimeZone('AUSTRALIA/MELBOURNE'));
        $file_validation = $this->dataload_utilities->validate_file_extension(Input::file('boundaryCsvFile'));
        $structure_validation = $this->dataload_utilities->validate_kml(Input::file('boundaryCsvFile'));
        //check if file is kml
        $this->boundary_msgs['overall_status'] = '&nbsp;&nbsp;&nbsp;<br/><b> Pass </b>';
        $file = Input::file('boundaryCsvFile');
        $bType = $r->get('selBoundaryType');
        $bName = $r->get('selBoundaryName');
        DB::table('users_log')->insert(
            ['boundary_code' => $bName, 'boundary_type' => $bType,
                'created_at' => $created_at, 'upload_status' => 'PASS',
                'validation_status' => 'VALIDATED', 'load_status'=>'', 'user'=> Auth::user()->name,
                'count'=>0,'validation_result'=>'']
        );
        $details = $this->dataload_utilities->get_db_details();
        if (!$file_validation || $structure_validation !== 'Validated') {

            $error = array();
            if (!$file_validation)
                $error[] = "File type must be kml";
            else
                if ($structure_validation == 'Failed'){
                    $error[] = "Invalid file";
                }
                else {
                    $error[] = "Invalid structure for tag " .$structure_validation."";
                }
                $this->dataload_utilities->update_user_log($details->id,'validation_status','FAILED');

            $validator = $error;
            return Redirect::to('boundaries/boundary_loader')->withErrors($validator);
        }
        $this->boundary_msgs['overall_status'] = '&nbsp;&nbsp;&nbsp;<br/><b> Pass </b>';
        $file = Input::file('boundaryCsvFile');
        $bType = $r->get('selBoundaryType');
        $bName = $r->get('selBoundaryName');

        $this->primary_input_boundary = $bName;

        $load_result = $this->load($file, $this->primary_input_boundary, $this->boundary_msgs,$details);

        $this->boundary_msgs = $load_result['msg'];

        if ($load_result['status'] == 'PASS') {
            $this->boundary_msgs['overall_status'] = 'Pass';
            $this->boundary_msgs['job_code'] = $details->id;
        } else {
            $this->boundary_msgs['overall_status_reason'] = 'during data insertion';
        }
        $this->dataload_utilities->update_user_log($details->id,'load_status',$load_result['status']);


        Session::put('boundary_msgs', $this->boundary_msgs);

        return Redirect::to('boundaries/boundary_loader');
    }
    /**
     * Function to get boundary types
     * @return array of boundary types
     */
    public function get_boundary_types()
    {
        return $this->defined_boundary_type;
    }


    public function store(Request $r)
    {
        $id = $r->get('id');
        if ($id){
            $data = DB::table('boundaries')->where('job_code', '=', $id)->orderBy('job_code', 'desc')->get();
        }
        else
            $data = Boundary::all();
        return view('boundaries.viewBoundaries')->with('data', $data);
    }
    /**
     * Function to return boundary co-ordinates for the selected boundary
     * @return array
     */
    public function get_coordinates(Request $r){
        $bName = $r->get('selBoundaryName');
        $bType = $r->get('selBoundaryType');
        $coords = DB::table('boundaries')->where('boundary_name', '=', $bName)->where('boundary_type', '=', $bType)->select('coordinates')->limit(1)->get();
        return $coords;
    }
    /**
     * Function to download a sample KML template
     * @return array
     */
    public function download_kml_sample() {
        $kml_sample_path = $this->generic_config->download_path . DIRECTORY_SEPARATOR . "nbn_boundary_kml_structure.kml";
        return response()->download($kml_sample_path);
    }
}
