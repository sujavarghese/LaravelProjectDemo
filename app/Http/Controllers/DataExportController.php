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
        parent::__construct();
    }
    public function index()
    {
        return view('boundaries.boundaryExporter');
    }
    public function get_boundary_by($type, $code, $job_code){
        $response = array();
        $match_these = array('boundary_type' => $type, 'boundary_name' => $code);
        if ($job_code != NULL) {
            $match_these['job_code'] = $job_code;
        }
        $queryset = Boundary::where($match_these)
            ->first()->toArray();
        if ($queryset != NULL){
            $response = array($queryset);
        }
        return $response;
    }
    /**
     * Function to store uploaded boundary data
     * @param Request $r
     */
    public function export_kml($type, $code, $job_code = NULL)
    {
        if ($code != NULL) {
            $queryset = $this->get_boundary_by($type, $code, $job_code);
            $response = $this->dataload_utilities->generate_kml_args();
            $response['boundary_details'] = $this->dataload_utilities->exclude_columns_from_response(
                $this->excluding_columns, $queryset);
            $response['boundary_details'] = $this->dataload_utilities->reverse_map_to_input_attributes(
                $response['boundary_details'], $this->generic_config->boundary_configs);
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
     * # TODO: Integrate
     */
    public function convert_kml_to_mapinfo($input_path, $output_path)
    {
        exec(
            'ogr2ogr -f "MapInfo File" ' . $output_path . ' ' . $input_path,
            $r, $t
        );
    }
}
