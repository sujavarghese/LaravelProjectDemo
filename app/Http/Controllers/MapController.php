<?php

namespace App\Http\Controllers;


class MapController extends Controller
{

    public function index()
    {
        $boundary_controller = new BoundariesController();
        $sam_names = array(
            'sam_names' => $boundary_controller->get_sam_names(),
        );
        return view('map.mapViewer')->with('response', $sam_names);
    }
}
