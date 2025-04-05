<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Barangay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    // get all barangays
    public static function getAll() {
        $data = self::all()
            ->map(fn($item) => tap($item, fn($i) => $i->encrypted_id = Crypt::encrypt($i->id)));

        return $data;
    }


    // add data
    public static function add_row(array $data) : bool {
        try {
            $create_status = self::create($data);

            if(!$create_status){
                return false;
            }

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // update a row
    public static function update_row(array $data, $id) : int {
        try {
            $item = self::find($id);

            /**
             * if data was not found then return 3 for data not found or 404
             */
            if(!$item){
                return 3;
            }

            /**
             * update status either return 1 or 0
             */
            $update_status = $item->update($data);

            /**
             * if udpate status is 0 then return 2 for failed update
             */
            if(!$update_status){
                return 2;
            }

            // return 1 if success
            return 1;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // delete a row
    public static function delete_a_row($id) : int {
        try {
            // find item
            $item = self::find($id);

            // if item was not found return 3 for 404
            if(!$item){
                return 3;
            }

            $delete_status = $item->delete(); // else delete item

            // if not delete then return 2 for failed deletion for 429 or 500
            if(!$delete_status){
                return 2;
            }

            // if success return 1 for 200
            return 1;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
