<?php

namespace App\Http\Controllers;
namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Utilities\DataLoadUtilities;
use Config;
use Constants;


class DataExportController extends Controller
{
    /**
     * Function to export mapinfo
     * @return array
     */
    public $dataload_utilities;
    public $generic_config;

    public function __construct()
    {
        $this->dataload_utilities = new DataLoadUtilities();
        $this->generic_config = new Config();
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
    public function export_kml($code)
    {
        if (is_array($code)) {
            $filter_in = $code;
        } else {
            $filter_in = array($code);
        }
        if ($filter_in != NULL) {
            $queryset = Boundary::whereIn('code', $filter_in)
                ->orderBy('code', 'desc')
                ->get()->toArray();

            $response = $this->dataload_utilities->generate_kml($queryset);
            $path_to_file = $this->dataload_utilities->join_path(
                $this->generic_config->download_path, $code . time() . '.kml'
            );

            return response('response', $response)->download($path_to_file)->deleteFileAfterSend(true);
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
