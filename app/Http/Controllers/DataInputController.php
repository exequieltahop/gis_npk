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
            /**
             * get data inputs
             */
            $data_inputs_data = GeoLocationDataAndNpk::with('brgy')
                ->get()
                ->map(function($query){
                    $query->encrypted_id = Crypt::encrypt($query->id);
                    return $query;
                });

            // return view
            return view('pages.data-input', [
                'data_inputs_data' => $data_inputs_data
            ]);
        } catch (\Throwable $th) {
            Log::error("Error : ".$th->getMessage());
            abort(500);
        }
    }

    // public add new data
    public function addData(Request $request) {
        // validate data
        $request->validate([
            'select_brgy' => ['required'],
            'x_coordinate' => ['required'],
            'y_coordinate' => ['required'],
            'n' => ['required'],
            'p' => ['required'],
            'k' => ['required']
        ]);

        $brgy_id = Crypt::decrypt($request->select_brgy);

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
            // dd(1);
            session()->flash('error', 'Failed to add data, If the problem persist, Pls contact developer!, Thank you');
            Log::error("Failed to add data for geo_location and npks!");
            return redirect()->back();
        }else{
            // dd(2);
            // success and redirect
            session()->flash('success', 'Successfully added data!');
            return redirect()->back();
        }
    }

    // delete data
    public function deleteData($id) {
        try {
            $decrypted_id = Crypt::decrypt($id); // decrypt id

            $delete_status = GeoLocationDataAndNpk::delete_row($decrypted_id); // delete item

            /**
             * check if succes
             * if not then response 429 failed to delete
             */
            if(!$delete_status){
                return response()->json([], 429);
            }

            session()->flash('success', 'Successfully deleted data input');
            return response()->json([], 200); // return 200
        } catch (\Throwable $th) {
            // log and return 500
            Log::error($th->getMessage());
            return response()->json([], 500);
        }
    }

    // edit data
    public function editData(Request $request) {
        try {
            // validate data
            $request->validate([
                'edit_id' => 'required',
                'x_coordinate' => ['required'],
                'y_coordinate' => ['required'],
                'n' => ['required'],
                'p' => ['required'],
                'k' => ['required']
            ]);

            $id = Crypt::decrypt($request->edit_id);

            // $brgy_id = Crypt::decrypt($request->edit_select_brgy);

            // data for insertion
            $data_create = [
                'x_coordinate' => $request->x_coordinate,
                'y_coordinate' => $request->y_coordinate,
                'n' => $request->n,
                'p' => $request->p,
                'k' => $request->k
            ];

            // get status
            $status = GeoLocationDataAndNpk::update_row($data_create, $id);

            /**
             * check if successfully edit data into database
             * if not then log error
             * make error session flash
             * then return redirect back
             */
            if(!$status){
                session()->flash('error', 'Failed to edit data, If the problem persist, Pls contact developer!, Thank you');
                Log::error("Failed to edit data for geo_location and npks!");
                return redirect()->back();
            }else{
                // success and redirect
                session()->flash('success', 'Successfully updated data!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // data import
    public function dataImport(Request $request) {
        try {

        } catch (\Throwable $th) {
            session()->flash('error', "Failed to import data");
            Log::error($th->getMessage());
            return redirect()->back();
        }
    }
}
