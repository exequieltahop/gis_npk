<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\GeoLocationDataAndNpk;

class DataInputController extends Controller
{
    // view blade data input
    public function view_data_input() {
        try {
            return view('pages.data-input');
        } catch (\Throwable $th) {
            Log::error("Error : ".$th->getMessage());
            abort(500);
        }
    }

    // public add new data
    public function addData(Request $request) {

        // validate data
        $request->validate([
            'brgy' => ['required'],
            'x_coordinate' => ['required'],
            'y_coordinate' => ['required'],
            'n' => ['required'],
            'p' => ['required'],
            'k' => ['required']
        ]);

        $brgy_id = Crypt::decrypt($request->brgy);

        // data for insertion
        $data_create = [
            'brgy_id' => $brgy_id,
            'x_coordinate' => $request->x_coordinate,
            'y_coordinate' => $request->y_coordinate,
            'n' => $request->n,
            'p' => $request->p,
            'k' => $request->k
        ];

        // get status
        $status = GeoLocationDataAndNpk::create($data_create);

        /**
         * check if successfully added data into database
         * if not then log error
         * make error session flash
         * then return redirect back
         */
        if(!$status){
            session()->flash('error', 'Failed to add data, If the problem persist, Pls contact developer!, Thank you');
            Log::error("Failed to add data for geo_location and npks!");
            return redirect()->back();
        }else{
            // success and redirect
            session()->flash('success', 'Successfully added data!');
            return redirect()->back();
        }
    }
}
