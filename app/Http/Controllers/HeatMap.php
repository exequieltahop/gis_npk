<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Barangay;
use App\Models\BrgyHeatmapPolygon;
use App\Models\GeoLocationDataAndNpk;
use Illuminate\Support\Facades\Crypt;

class HeatMap extends Controller
{
    public function index()
    {
        try {
            $brgys = BrgyHeatmapPolygon::getAll()
                ->get()
                ->map(function ($item) {
                    $item->encrypted_id = Crypt::encrypt($item->id);
                    return $item;
                });

            return view('pages.heat-map', [
                'brgys' => $brgys
            ]);
        } catch (\Throwable $th) {
            /**
             * log error and abort 500
             */
            Log::error($th->getMessage());
            abort(500);
        }
    }

    // add polygon
    public function addPolygon(Request $request)
    {
        try {
            // validate
            $request->validate([
                'select_brgy' => ['required'],
                'coordinates' => 'required',
            ]);
            $decrypted_id = Crypt::decrypt($request->select_brgy); //decrypt id

            $checker = BrgyHeatmapPolygon::where('barangay_id', $decrypted_id)->first(); // get row with same brgy id

            // if the brgy already have polygon response with error 422
            if ($checker) {
                /**
                 * log error
                 * make session error
                 * response 422
                 */
                Log::error("Brgy Id already exist!");
                session()->flash("error", "This selected brgy already have polygon!");
                return response(null, 422);
            }

            $create_status = BrgyHeatmapPolygon::create([
                'barangay_id' => $decrypted_id,
                'polygon_coordinate' => $request->coordinates,
            ]);

            if (!$create_status) {
                throw new Exception("Failed to save coordinates data into database");
            }
            /**
             * session flash success
             * response 200
             */
            session()->flash("success", "Successfully Added Polygon");
            return response(null, 200);
        } catch (\Throwable $th) {
            /**
             * log error
             * make session flash error
             * response 500
             */
            Log::error($th->getMessage());
            session()->flash("error", "Failed to add polygon!, Pls try again!, If the problem persist pls contact developer");
            return response(null, 500);
        }
    }

    // get heat map data
    public function getHeatMapData($type)
    {
        try {
            $data = BrgyHeatmapPolygon::getHeatMapData()
                ->get()
                ->map(function ($item) use ($type) {
                    $item->avg = GeoLocationDataAndNpk::where('brgy_id', $item->barangay_id)
                        ->avg($type);
                    return $item;
                });

            return response()->json($data, 200); // repsonse 200 with data
        } catch (\Throwable $th) {
            /**
             * log error
             * response 500
             */
            Log::error($th->getMessage());
            return response(null, 500);
        }
    }

    // delete polygon
    public function deletePolygon($id)
    {
        try {
            // decrypt id
            $decrypted_id = Crypt::decrypt($id);

            // delete row
            $delete_status = BrgyHeatmapPolygon::deleteRow($decrypted_id);

            // if failed to delete then throw new exception
            if (!$delete_status) {
                throw new Exception("Failed to delete polygon");
            }

            /**
             * session success
             * respones 200
             */
            session()->flash("success", "Successfully Delete Polygon");
            return response(null, 200);
        } catch (\Throwable $th) {
            /**
             * log error
             * response 500
             */
            Log::error($th->getMessage());
            return response(null, 500);
        }
    }
}
