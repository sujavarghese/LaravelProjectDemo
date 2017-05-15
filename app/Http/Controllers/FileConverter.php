<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Redirect;

class FileConverter extends Controller
{
    public $input_file_type;
    public $output_file_type;

    public $command = 'ogr2ogr -f';

    public function load_file(Request $r) {
        $file = Input::file('inputFile');
        $iType = $r->get('inputFileType');
        $oType = $r->get('outputFileType');

        $this ->command = $this ->command . ' ' . $oType . ' output.' . strtolower($oType) . ' ' . $file;

        echo $this ->command;

        return true;

        exec($this->command);

        return Redirect::to('converter');

    }


}
