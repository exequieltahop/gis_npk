<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\GeoLocationDataAndNpk;
use Illuminate\Support\Facades\Crypt;

class BarangayDataController extends Controller
{
    // view blade brgy data
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
                    $query->recommended = $this->getRecommendedPlantsAndFertilizer($query->n, $query->p, $query->k);
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

    // get recommended plants and fertilizer
    public function getRecommendedPlantsAndFertilizer($n, $p, $k) : array {
        try {
            // nitrogen
            $low_n_plants = [
                'Mung beans (Vigna radiata)',
                'Kangkong (Ipomoea aquatica)',
            ];

            $low_n_fertilizer = [
                'Urea (46-0-0)',
                'Chicken manure (high in nitrogen)'
            ];

            $medium_n_plants = [
                'Corn (Zea mays)',
                'Eggplant (Solanum melongena)'
            ];

            $medium_n_fertilizer = [
                '14-14-14 NPK fertilizer (balanced)',
                'Slow-release fertilizers (e.g., Osmocote)'
            ];

            $high_n_plants = [
                'Tomatoes (Solanum lycopersicum)',
                'Bell peppers (Capsicum annuum)'
            ];

            $high_n_fertilizer = [
                '5-10-10 NPK fertilizer (lower nitrogen)',
                'Avoid excess nitrogen to prevent leaf growth over fruiting'
            ];

            // phosphorus
            $low_p_plants = [
                'Sweet potatoes (Ipomoea batatas)',
                'Marigolds (Tagetes spp.)',
            ];

            $low_p_fertilizer = [
                'Superphosphate (0-20-0)',
                'Bone meal (high in phosphorus)'
            ];

            $medium_p_plants = [
                'Okra (Abelmoschus esculentus)',
                'Peppers (Capsicum spp.)'
            ];

            $medium_p_fertilizer = [
                '10-10-10 NPK fertilizer (balanced)',
                'Fish bone meal (organic source)'
            ];

            $high_p_plants = [
                'Peanuts (Arachis hypogaea)',
                'Basil (Ocimum basilicum)'
            ];

            $high_p_fertilizer = [
                'Low phosphorus fertilizers (e.g., 5-10-10)',
                'Avoid excess phosphorus to prevent nutrient lockout'
            ];

            // potassium
            $low_k_plants = [
                'Tomatoes (Solanum lycopersicum)',
                'Bananas (Musa spp.)',
            ];

            $low_k_fertilizer = [
                'Potassium sulfate (0-0-50)',
                'Wood ash (natural source)'
            ];

            $medium_k_plants = [
                'Lettuce (Lactuca sativa)',
                'Carrots (Daucus carota)'
            ];

            $medium_k_fertilizer = [
                '10-10-10 NPK fertilizer (balanced)',
                'Slow-release potassium fertilizers (e.g., potassium nitrate)'
            ];

            $high_k_plants = [
                'Potatoes (Solanum tuberosum)',
                'Corn (Zea mays)'
            ];

            $high_k_fertilizer = [
                'Low potassium fertilizers (e.g., 5-10-10)',
                'Avoid excess potassium to prevent imbalances'
            ];

            $data_plant = [];
            $data_fertilizer = [];

            // Nitrogen Levels
            if ($n > 0 && $n <= 30) {
                $data_plant = array_merge($data_plant, $low_n_plants);
                $data_fertilizer = array_merge($data_fertilizer, $low_n_fertilizer);
            }

            if ($n > 30 && $n <= 70) {
                $data_plant = array_merge($data_plant, $medium_n_plants);
                $data_fertilizer = array_merge($data_fertilizer, $medium_n_fertilizer);
            }

            if ($n > 70 && $n <= 100) {
                $data_plant = array_merge($data_plant, $high_n_plants);
                $data_fertilizer = array_merge($data_fertilizer, $high_n_fertilizer);
            }

            // Phosphorus Levels
            if ($p > 0 && $p <= 20) {
                $data_plant = array_merge($data_plant, $low_p_plants);
                $data_fertilizer = array_merge($data_fertilizer, $low_p_fertilizer);
            }

            if ($p > 20 && $p <= 50) {
                $data_plant = array_merge($data_plant, $medium_p_plants);
                $data_fertilizer = array_merge($data_fertilizer, $medium_p_fertilizer);
            }

            if ($p > 50 && $p <= 100) {
                $data_plant = array_merge($data_plant, $high_p_plants);
                $data_fertilizer = array_merge($data_fertilizer, $high_p_fertilizer);
            }

            // Potassium Levels
            if ($k > 0 && $k <= 30) {
                $data_plant = array_merge($data_plant, $low_k_plants);
                $data_fertilizer = array_merge($data_fertilizer, $low_k_fertilizer);
            }

            if ($k > 30 && $k <= 70) {
                $data_plant = array_merge($data_plant, $medium_k_plants);
                $data_fertilizer = array_merge($data_fertilizer, $medium_k_fertilizer);
            }

            if ($k > 70 && $k <= 100) {
                $data_plant = array_merge($data_plant, $high_k_plants);
                $data_fertilizer = array_merge($data_fertilizer, $high_k_fertilizer);
            }

            // Output the resulting arrays of plants and fertilizers
            return [
                'plants' => $data_plant,
                'fertilizers' => $data_fertilizer
            ];

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
