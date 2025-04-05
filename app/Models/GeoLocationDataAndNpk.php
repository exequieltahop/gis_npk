<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public function scopeGetDataPerBrgy($query, $id) {
        try {
            return $query->select('*')
                ->where('brgy_id', $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
