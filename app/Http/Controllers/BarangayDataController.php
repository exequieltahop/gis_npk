<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\GeoLocationDataAndNpk;
use Illuminate\Support\Facades\Crypt;

class BarangayDataController extends Controller
{
    public function viewBrgyDataView($id) {
        try {

            return view('pages.view-brgy-data', [
                'brgyId' => $id
            ]);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500);
        }
    }

    // get brgy data
    public function getBrgyDataView($id) {
        try {
            //decrypt id
            $decrypted_id = Crypt::decrypt($id);

            // get data
            $data = GeoLocationDataAndNpk::getDataPerBrgy($decrypted_id)
                ->get()
                ->map(function($query){
                    $query->encrypted_id = Crypt::encrypt($query->id);
                    return $query;
                });

            return response()->json(['data' => $data], 200); //response 200 with data

        } catch (\Throwable $th) {
            /**
             * log error and response 500
             */
            Log::error($th->getMessage());
            return response()->json([], 500);
        }
    }
}
