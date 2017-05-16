<?php

namespace App\Classes;
namespace App\Http\Controllers;

use App\Boundary;
use Illuminate\Http\Request;
use Constants;
use App\Http\Requests\LoadBoundaryFormRequest;
use Illuminate\Support\Facades\Storage;
use DB;
use Input;
use Validator;
use Redirect;
use Session;
use Auth;

class BoundariesController extends Controller
{
    public $boundary_msgs = [];
    public $primary_input_boundary = [];
    public $defined_boundary_type = array('SAM', 'ADA');

    public function validate_boundary_input($file, $bname, $btype)
    {
        if (!$file) {
            $this->boundary_msgs['file_error'] = 'Upload file is Required';
            return false;
        }
        if (!$bname) {
            $this->boundary_msgs['b_name'] = 'Boundary Name is Required';
            return false;
        }
        return true;
    }
    public function get_sam_names()
    {
        $sam_names = $this->sam_names();
        $response = array(
            ''=> '',
        );

        for ($i = 0, $c = count($sam_names); $i < $c; $i += 1) {
            $response[$sam_names[$i]] = $sam_names[$i];
        }
        return $response;
    }
    public function view_loader()
    {
        $response = array(
            'sam_names' => $this->get_sam_names(),
        );

         return view('boundaries.boundaryLoader')->with('response', $response);
    }

    public function validate_csv_data($bname, $btype)
    {
        $p = str_replace('-', '\-', $this->primary_input_boundary);
        $bname_pattern = '/^' . $p . '*/';
        if (!in_array($btype, $this->defined_boundary_type)) {
            if (!isset($this->boundary_msgs['b_type']))
                $this->boundary_msgs['b_type'] = '';
            $this->boundary_msgs['b_type'] .= 'Boundary Type ' . $btype . ' is Invalid. <br>';
            return false;
        }
        if (!$bname || trim($bname) == '' || !preg_match($bname_pattern, $bname)) {
            if (!isset($this->boundary_msgs['b_name']))
                $this->boundary_msgs['b_name'] = '';
            $this->boundary_msgs['b_name'] .= 'Boundary ' . $bname . ' is not an asscociated boundary, cannot be imported. <br>';
            return false;
        }
        return '(\'' . $bname . '\', \'' . $btype . '\', now(), \'' . \Auth::user()->name  . '\'),';
    }

    public function extract_valid_data($file)
    {
        try {

            $row_str = '';
            $r_cnt = 0;
            while (($data = fgetcsv($file, 200, ",")) !== FALSE) {
                $name = $data[0];
                $type = $data[1];

                $q_str = $this->validate_csv_data($name, $type);
                if ($q_str) {
                    $row_str .= $q_str;

                    $r_cnt += 1;
                }
            }
            return [$row_str, $r_cnt];
        } catch (Exception $e) {
            $this->boundary_msgs['extract_valid_data_e'] = 'Failed due to Exception' . $e->getMessage();
            return false;
        }

    }

    public function read_csv_data($file)
    {

        try {
            $file = fopen($file, "r");
            // Read the header for validation and it skips insertion
            $cols = fgetcsv($file);
            $expected_header = ['name', 'type'];
            $header_check = array_udiff($cols, $expected_header, 'strcasecmp');
            if (count($header_check)) {
                //TODO: Add Notes
                $this->boundary_msgs['csv_header_error'] = 'CSV header is not in expeceted format!';
                return false;
            }
            $valid_data_arr = $this->extract_valid_data($file);
            $row_str = $valid_data_arr[0];
            $row_cnt = $valid_data_arr[1];
            if ($row_str)
                DB::delete('delete from boundaries where boundary_name like \'' . $this->primary_input_boundary . '%\'');
            DB::insert('insert into boundaries (boundary_name, boundary_type, created_at, added_by) 
                          values ' . rtrim($row_str, ","));
            $this->boundary_msgs['insertion_success_msg'] = '<b>' . $row_cnt . '</b> boundary rows are inserted to database';
            fclose($file);
            return true;
        } catch (Exception $e) {
            $this->boundary_msgs['read_csv_data_e'] = 'Failed due to Exception' . $e->getMessage();
            return false;
        }

    }

    public function load($file)
    {
        return $this->read_csv_data($file);
    }

    public function validate_load_store(Request $r)
    {
        $this->boundary_msgs['overall_status'] = 'Pass';
        $file = Input::file('boundaryCsvFile');
        $bType = $r->get('selBoundaryType');
        $bName = $r->get('selBoundaryName');
        $this->primary_input_boundary = $bName;
        $val_result = $this->validate_boundary_input($file, $bName, $bType);
        echo '<br>' . $this->primary_input_boundary;
        echo '<br>' . $val_result;
        if (!$val_result) {
            $this->boundary_msgs['overall_status'] = 'Failed';
            $this->boundary_msgs['overall_status_reason'] = 'failed during validation';
            Session::put('boundary_msgs', $this->boundary_msgs);
            return Redirect::to('boundary_loader');
        }

        $load_result = $this->load($file);
        if (!$load_result)
            $this->boundary_msgs['overall_status'] = 'Failed';
        $this->boundary_msgs['overall_status_reason'] = 'during data insertion';

        Session::put('boundary_msgs', $this->boundary_msgs);
        return Redirect::to('boundary_loader');
    }
    public function export_mapinfo()
    {
        $data = array();
        $r = array();
        $t = 1;
        $out_path = "C:\\xampp\\htdocs\\data\\out.tab";
        $db_name = "laraveldemodb";
        $user = 'root';
        $host = 'localhost';
        $port = '3306';
        $table = 'boundaries';
        exec(
            'ogr2ogr -f "MapInfo File" ' . $out_path . ' "MYSQL:' . $db_name . ',user=' . $user . ',host=' . $host . ',port=' . $port . ',tables=' . $table . '"',
            $r, $t
        );
        $data['result'] = $r;
        $data['status'] = $t;
        return $data;
    }
    public function export_kml()
    {
        $data = array();
        $r = array();
        $t = 1;
        $out_path = "C:\\xampp\\htdocs\\data\\out.kml";
        $db_name = "laraveldemodb";
        $user = 'root';
        $host = 'localhost';
        $port = '3306';
        $table = 'boundaries';
        exec(
            'ogr2ogr -f "KML" ' . $out_path . ' "MYSQL:' . $db_name . ',user=' . $user . ',host=' . $host . ',port=' . $port . ',tables=' . $table . '"',
            $r, $t
        );
        $data['result'] = $r;
        $data['status'] = $t;
        return $data;
    }
    public function convert_kml_to_mapinfo()
    {
        $input_path = "C:\\xampp\\htdocs\\data\\out.kml";
        $output_path = "C:\\xampp\\htdocs\\data\\convert.tab";
        exec(
            'ogr2ogr -f "MapInfo File" ' . $output_path . ' ' . $input_path,
            $r, $t
        );
    }
    public function get_boundary_types()
    {
        return $this->defined_boundary_type;
    }
    function sam_names()
    {
        $cn = new Constants();
        return $cn->getSAMNames();
    }
    public function get_data()
    {
        $data = Boundary::all();
        return view('boundaries.viewBoundaries')->with('data', $data);
    }
}