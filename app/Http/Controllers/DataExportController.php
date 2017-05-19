<?php

namespace App\Classes;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\DataLoadUtilities;
use GenericConfig;
use App\Boundary;

class DataExportController extends Controller
{
    /**
     * Function to export mapinfo
     * @return array
     */
    public $dataload_utilities;
    public $generic_config;
    public $excluding_columns = ['added_by','created_at'];

    public function __construct()
    {
        $this->dataload_utilities = new DataLoadUtilities();
        $this->generic_config = new GenericConfig();
    }
    public function index()
    {
        return view('boundaries.boundaryExporter');
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

    /**
     * Function to export kml
     * @return array
     */
    public function export_kml_ogr()
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
    /**
     * Function to store uploaded boundary data
     * @param Request $r
     */
    public function export_kml($type, $code)
    {
        if (is_array($code)) {
            $filter_in = $code;
        } else {
            $filter_in = array($code);
        }
        if ($filter_in != NULL) {
            $queryset = Boundary::whereIn('boundary_name', $filter_in)
                ->orderBy('boundary_name', 'desc')
                ->get()->toArray();

            $response = $this->dataload_utilities->generate_kml();
            $response['boundary_details'] = $this->dataload_utilities->exclude_columns_from_response($this->excluding_columns, $queryset);
            $file_name = $code . '_' . time() . '.kml';
            $response['file_name'] = $file_name;
            return response()->view('boundaries.kml', compact('response'))->header(
                'Content-Type', 'text/xml')->header(
                'Content-Disposition', 'attachment; filename="' . $file_name . '"');
        }
        return NULL;
    }
    /**
     * Function to convert kml to mapinfo
     */
    public function convert_kml_to_mapinfo()
    {
        $input_path = "C:\\xampp\\htdocs\\data\\out.kml";
        $output_path = "C:\\xampp\\htdocs\\data\\convert.tab";
        exec(
            'ogr2ogr -f "MapInfo File" ' . $output_path . ' ' . $input_path,
            $r, $t
        );
    }
}
