<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Barangay;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use function Laravel\Prompts\error;

class GeoLocationDataAndNpk extends Model
{
    use SoftDeletes;

    protected $table = 'geo_location_data_and_npks';
    // fillable
    protected $fillable = [
        'brgy_id',
        'x_coordinate',
        'y_coordinate',
        'n',
        'p',
        'k'
    ];

    // scope get all
    public function scopeGetDataPerBrgy($query, $id)
    {
        try {
            return $query->select('*')
                ->where('brgy_id', $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // relation to brgy
    public function brgy()
    {
        return $this->belongsTo(Barangay::class, 'brgy_id');
    }

    // delete a row
    public static function delete_row($id): bool
    {
        try {
            $item = self::find($id); // get item

            /**
             * if item not found
             * then log errors
             * return false
             */
            if (!$item) {
                Log::error("404 data input not found in database");
                return false;
            }

            $delete_status = $item->delete(); // soft delete item

            /**
             * check if false
             * if false then log error
             * then return false
             */
            if (!$delete_status) {
                Log::error("Failed to delete item in database!");
                return false;
            }

            return true; // returns true
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // edit data
    public static function update_row(array $data, $id)
    {
        try {
            $item = self::find($id);

            $status = $item->update($data);

            return $status;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // data import
    public function dataImport($file): bool
    {
        try {
            // This will return a Laravel Collection of rows
            $collection = Excel::toCollection(null, $file);

            // Optional: If Excel has multiple sheets, get the first one
            $rows = $collection[0]; // First sheet

            foreach ($rows as $row) {
                // Loop each row - assuming it has headers
                GeoLocationDataAndNpk::create([
                    'brgy_id'       => $row['brgy_id'],
                    'x_coordinate'  => $row['x_coordinate'],
                    'y_coordinate'  => $row['y_coordinate'],
                    'n'             => $row['n'],
                    'p'             => $row['p'],
                    'k'             => $row['k'],
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
