<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrgyHeatmapPolygon extends Model
{
    // fillables
    protected $fillable = [
        'barangay_id',
        'polygon_coordinate',
    ];

    // get all scope with join in barangays table
    public function scopeGetAll($query) {
        try {
            return $query->join('barangays as t2', 'brgy_heatmap_polygons.barangay_id', '=', 't2.id')
                ->select([
                    't2.name',
                    'brgy_heatmap_polygons.*',
                ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // scope join into barangays
    public function scopeGetHeatMapData($query) {
        try {
            return $query->join('barangays as b', 'brgy_heatmap_polygons.barangay_id', '=', 'b.id')
            ->select([
                'brgy_heatmap_polygons.*',
                'b.name',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // delete row
    public static function deleteRow($id) : bool {
        try {
            $item = self::findOrFail($id); // get row

            return $item->delete(); // return bool result from deleted row

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
