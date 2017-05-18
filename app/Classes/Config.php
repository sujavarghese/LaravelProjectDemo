<?php
/**
 * Created by PhpStorm.
 * User: Suja.Varghese
 * Date: 18/05/2017
 * Time: 11:03 AM
 */

class Config
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $boundary_configs;
    public $boundary_column_details;
    public $public_path;
    public $app_path;
    public $upload_path;
    public $download_path;

    public function __construct()
    {
        $this->boundary_configs = $this->read_config();
        $this->boundary_column_details = $this->get_column_names();

        $this->public_path = public_path();
        $this->app_path = app_path();
        $this->upload_path = $this->public_path . DIRECTORY_SEPARATOR . 'uploads';
        $this->download_path = $this->public_path . DIRECTORY_SEPARATOR . 'downloads';
    }
    private function read_config()
    {
        $config_path = config_path() . DIRECTORY_SEPARATOR . 'config.json';
        $string = file_get_contents($config_path);
        return json_decode($string, true);
    }
    public function get_column_names()
    {
        $layer_name = array();
        $column_names = array();

        $json_a = $this->boundary_configs;

        forEach ($json_a as $key => $val)
        {
            array_push($layer_name, $key);

            forEach ($val as $str => $dbArr)
            {
                if ($str == 'attributes')
                    forEach ($val[$str] as $dbcol => $dbVal)
                    {
                        array_push($column_names, $dbVal['tblcolumnname']);
                    }
            }
        }
        return array($layer_name, $column_names);
    }
}