<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Barangay;
use Illuminate\Support\Facades\Crypt;

class BarangayController extends Controller
{
    // add brgy
    public function addBarangay(Request $request) {
        try {
            // validate
            $request->validate([
                'brgy' => ['required']
            ]);

            // add new brgy
            $create_status = Barangay::add_row(['name' => $request->brgy]);

            /**
             * if failed log erros
             * make error session
             * return redirect back
             */
            if(!$create_status){
                Log::error("Failed to add new brgy");
                session()->flash('error', "Failed to add brgy, If the problem persist contact developer!, Thank you");
                return redirect()->back();
            }

            /**
             * if success
             * make success session
             * return redirect back
             */
            session()->flash('success', 'Successfully Added new Barangay');
            return redirect()->back();

        } catch (\Throwable $th) {
            /**
             * log errors
             * make a flash session
             * return redirect back
             */
            Log::error($th->getMessage());
            session()->flash('error', "Failed to add brgy, If the problem persist contact developer!, Thank you");
            return redirect()->back();
        }
    }

    // edit brgy
    public function editBarangay(Request $request) {
        try {
            // request validated
            $request->validate([
                'id' => 'required',
                'name'=> 'required'
            ]);

            //decrypt id
            $id = Crypt::decrypt($request->id);

            // make update data
            $update_data = [
                'name' => $request->name
            ];

            // update row
            $update_status = Barangay::update_row($update_data, $id);

            /**
             * get udpate status
             * check if the return was 2 or 3
             * if 2 or 3
             * then log errors
             * then return back with errors
             */
            if($update_data == 3){
                Log::error("Brgy cannot be found in database!");
                session()->flash('error', 'Failed to update barangay, If the problem persist pls contact developer');
                return redirect()->back();
            }

            if ($update_data == 2){
                Log::error("Failed to update data!");
                session()->flash('error', 'Failed to update barangay, If the problem persist pls contact developer');
                return redirect()->back();
            }

            // return with success message
            session()->flash('success', 'Successfully Updated Barangay');
            return redirect()->back();

        } catch (\Throwable $th) {
            /**
             * catch errors and exceptions
             * log catch $th or throwable either error or exceptions
             * make error session
             * return redirect back
             */
            Log::error($th->getMessage());
            session()->flash('error', 'Failed to update barangay, If the problem persist pls contact developer');
            return redirect()->back();
        }
    }

    // delete brgy
    public function deleteBarangay($id) {
        try {
            $decrypted_id = Crypt::decrypt($id); // decrypt id

            $delete_status = Barangay::delete_a_row($decrypted_id); // delete item

            /**
             * if failed to delete
             * then log error
             * then make sessions
             * and return redirect back
             */
            if($delete_status == 3 || $delete_status == 2){
                Log::error("Failed to delete , reason $delete_status ");
                return response()->json([], 500);
            }

            // if success return with success message
            return response()->json([], 200);

        } catch (\Throwable $th) {
            /**
             * catch errors and exceptions
             * log catch $th or throwable either error or exceptions
             * make error session
             * return redirect back
             */
            Log::error($th->getMessage());
            return response()->json([], 500);
        }
    }
}
