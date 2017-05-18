<?php

namespace App\Classes;
namespace App\Utilities;

use Illuminate\Support\Facades\Storage;
use DB;
use Input;
use Validator;
use Redirect;
use Session;
use Auth;
use DateTime;

use GenericConfig;
use Constants;

class DataLoadUtilities
{

    /**
     * Function to get input file type
     * @param $file : Input file
     * @return string
     */
    public function get_file_type($file)
    {
        $fileType = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        return strtoupper($fileType);
    }

    public function join_path($path, $file)
    {
        return $path . DIRECTORY_SEPARATOR . $file;
    }

    function generate_kml($results)
    {
        $config = new GenericConfig();
        $response = array(
            'root_tag_name' => 'boundary',
            'attr_list' => $config->boundary_column_details,
        );
        echo $response;
        $boundary_details = array();
        $attr_list = array();

        foreach ($results as $key => $value) {
            if ($key != 'boundary_details') {
                $attr_list[] = $key;
                $boundary_details[$key] = $value;
            }
        }
        foreach ($results['boundary_details'] as $key => $value) {
            $attr_list[] = $key;
            $boundary_details[$key] = $value;
        }
        return$response;
    }
    /**
     * Function to validate file extension
     * @param $file : Input file
     * @return bool
     */
    public function validate_file_extension($file)
    {
        $fileType = $this->get_file_type($file);
        $validFile = array('KML');
        if (in_array(strtoupper($fileType), $validFile)) {
            return true;
        }
        return false;
    }


    /**
     * Function to read CSV data
     * @param $file : Uploaded file
     * @return bool
     */
    public function read_csv_data($file, $primary_input_boundary)
    {

        try {
            $file = fopen($file, "r");
            // Read the header for validation and it skips insertion
            $cols = fgetcsv($file);
            $expected_header = ['name', 'type'];
            $header_check = array_udiff($cols, $expected_header, 'strcasecmp');
            if (count($header_check)) {
                //TODO: Add Notes
                $this->boundary_msgs['csv_header_error'] = $this->get_file_type($file);
                return false;
            }
            $valid_data_arr = $this->extract_valid_data($file);
            $row_str = $valid_data_arr[0];
            $row_cnt = $valid_data_arr[1];
            if ($row_str)
                DB::delete('delete from boundaries where boundary_name like \'' . primary_input_boundary . '%\'');
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

    /**
     * Function to extract valid data from csv
     * @param $file : Uploaded file
     * @return array|bool
     */
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

    /**
     * @param $bname : Boundary Name
     * @param $btype : Boundary Type
     * @return bool|string
     */
    public function validate_csv_data($bname, $btype, $primary_input_boundary)
    {
        $p = str_replace('-', '\-', primary_input_boundary);
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
        return '(\'' . $bname . '\', \'' . $btype . '\', now(), \'' . \Auth::user()->name . '\'),';
    }


    /**
     * Function to read KML file
     * @param $file : Uploaded file
     * @return bool
     */
    public function read_kml_data($file, $primary_input_boundary)
    {

        try {
            $xml = simplexml_load_file($file);
            $folder = $xml->Document->Folder;
            $created_at = new DateTime();
            $row_str = array();
            $row_cnt = 0;
            forEach ($folder as $bound) {
                $layer_name = $bound->name;
                $set_layer_valid = false;
                if ($layer_name == 'nbnBoundary') {
                    $set_layer_valid = true;
                }
                if ($set_layer_valid) {
                    $placemark = isset($bound->Placemark) ? $bound->Placemark : null;
                    $style = isset($placemark) ? $placemark->Style : null;
                    $line_style = (!empty($style)) ? $style->LineStyle->color : null;
                    $poly_style = (!empty($style)) ? $style->PolyStyle->fill : null;
                    forEach ($placemark as $pm) {

                        $extended_data = isset($pm->ExtendedData->SchemaData) ? $pm->ExtendedData->SchemaData->SimpleData : null;
                        $b_geom = isset($pm->Polygon->outerBoundaryIs->LinearRing->coordinates) ? $pm->Polygon->outerBoundaryIs->LinearRing->coordinates : 'noCoords';
                        $schema_name = null;
                        $schema_type = null;
                        $schema_gml_id = null;
                        if (!empty($extended_data)) {
                            forEach ($extended_data as $key => $data) {
                                $data_type = $data['name'];
                                $schema_name = ($data_type == 'type') ? $data : $schema_type;
                                $schema_type = ($data_type == 'code') ? $data : $schema_name;
                                $schema_gml_id = ($data_type == 'gml_id') ? $data : $schema_gml_id;
                            }
                        }
                        if ($schema_name && $schema_type && $b_geom)
                            $row_str[$row_cnt] = array(
                                'boundary_type' => (string)$schema_name,
                                'boundary_name' => (string)$schema_type,
                                'created_at' => $created_at,
                                'added_by' => Auth::user()->name,
                                'coordinates' => (string)$b_geom);

                        $row_cnt++;

                    }
                }
            }
            if ($row_str)
                DB::delete('delete from boundaries where boundary_name like \'' . $primary_input_boundary . '%\'');
            DB::table('boundaries')->insert($row_str);
            $this->boundary_msgs['insertion_success_msg'] = '<b>' . $row_cnt . '</b> boundary rows are inserted to database';
            return true;
        } catch (Exception $e) {
            $this->boundary_msgs['read_csv_data_e'] = 'Failed due to Exception' . $e->getMessage();
            return false;
        }

    }

}
