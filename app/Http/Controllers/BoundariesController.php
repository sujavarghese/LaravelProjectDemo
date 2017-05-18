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
    }

    public function get_sam_names()
    {
        $nj = new DataLoadUtilities();
        $sam_names = $this->sam_names();
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
            'sam_names' => $this->get_sam_names(),
        );

        return view('boundaries.boundaryLoader')->with('response', $response);
    }

    /**
     * Function to load data into DB
     * @param $file : Upload file
     * @return bool
     */
    public function load($file, $primary_input_boundary)
    {
        $fileType = $this->dataload_utilities->get_file_type($file);
        echo $fileType;
        if ($fileType == 'KML') {
            return $this->dataload_utilities->read_kml_data($file, $primary_input_boundary);
        } else {
            return $this->dataload_utilities->read_csv_data($file, $primary_input_boundary);
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
        $file_validation = $this->dataload_utilities->validate_file_extension(Input::file('boundaryCsvFile'));

        //check if file is kml
        if (!$file_validation) {

            $error = array();
            $error[] = "File type must be kml";
            $validator = $error;
            return Redirect::to('boundaries/boundary_loader')->withErrors($validator);
        }
        $this->boundary_msgs['overall_status'] = 'Pass';
        $file = Input::file('boundaryCsvFile');
        $bType = $r->get('selBoundaryType');
        $bName = $r->get('selBoundaryName');

        $this->primary_input_boundary = $bName;

        $load_result = $this->load($file, $this->primary_input_boundary);
        if (!$load_result)
            $this->boundary_msgs['overall_status'] = 'Failed';
        $this->boundary_msgs['overall_status_reason'] = 'during data insertion';


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

    /**
     * Function to return sam names
     * @return array of sam names
     */
    function sam_names()
    {
        $cn = new Constants();
        return $cn->getSAMNames();
    }

    public function store()
    {
        $data = Boundary::all();
        return view('boundaries.viewBoundaries')->with('data', $data);
    }
}
