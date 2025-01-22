<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\NameData;
use App\Models\Province;
use App\Models\RegencyData;
use App\Models\ProvinceData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $show = $request->input('show', 'provinces');

        $data = match ($show) {
            'earth-quakes' => $this->getEarthquakeData(),
            'regencies' => Regency::with('province:id,name')->get(),
            default => Province::with('provinceDatas')->get()
        };

        return view('geo-map', compact('data', 'show'));
    }

    private function getEarthquakeData()
    {
        return Cache::remember('earthquake_data', 3600, function () {
            return json_decode(file_get_contents('https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json'), true);
        });
    }

    public function choroplet(Request $request)
    {
        $province = Province::with(['regencies', 'provinceDatas' => function ($query) {
            $query->with('nameData.category')
                ->where('year', request('year', date('Y')));
        }])->findOrFail($request->province_id ?? 62);

        // Get available data types from NameData
        $dataTypes = NameData::with('category')
            ->whereHas('provinceDatas', function ($query) use ($province) {
                $query->where('province_id', $province->id);
            })
            ->orWhereHas('regencyDatas', function ($query) use ($province) {
                $query->whereIn('regency_id', $province->regencies->pluck('id'));
            })
            ->get()
            ->groupBy('category.name');

        // Get available years
        $years = [2024];

        return view('choroplet', compact('province', 'dataTypes', 'years'));
    }

    public function getGeoJson(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $nameDataId = $request->input('name_data_id');
        $level = $request->input('level', 'province');
        $provinceId = $request->input('province_id');

        if ($level === 'province') {
            return $this->getProvinceGeoJson($provinceId, $year, $nameDataId);
        } else {
            return $this->getRegencyGeoJson($provinceId, $year, $nameDataId);
        }
    }

    private function getProvinceGeoJson($provinceId, $year, $nameDataId)
    {
        $province = Province::findOrFail($provinceId);
        $geojsonContent = file_get_contents(storage_path('app/public/' . $province->geojson_path));
        $geojson = json_decode($geojsonContent, true);

        $provinceData = ProvinceData::with('nameData')
            ->where('year', $year)
            ->where('province_id', $provinceId)
            ->where('name_data_id', $nameDataId)
            ->first();

        if ($provinceData) {
            $geojson['features'][0]['properties']['value'] = $provinceData->amount;
            $geojson['features'][0]['properties']['unit'] = $provinceData->nameData->unit;
            $geojson['properties']['value'] = $provinceData->amount;
            $geojson['properties']['name'] = $province->name;
            $geojson['properties']['data_name'] = $provinceData->nameData->name;
            $geojson['features'][0]['properties']['data_name'] = $provinceData->nameData->name;
            $geojson['properties']['category'] = $provinceData->nameData->category->name;
        }

        return response()->json($geojson);
    }

    private function getRegencyGeoJson($provinceId, $year, $nameDataId)
    {
        $regencies = Regency::where('province_id', $provinceId)->get();
        $features = [];

        foreach ($regencies as $regency) {
            $geojsonContent = file_get_contents(storage_path('app/public/' . $regency->geojson_path));
            $regencyGeojson = json_decode($geojsonContent, true);

            $regencyData = RegencyData::with('nameData')
                ->where('year', $year)
                ->where('regency_id', $regency->id)
                ->where('name_data_id', $nameDataId)
                ->first();

            if ($regencyData) {
                $regencyGeojson['features'][0]['properties']['value'] = $regencyData->amount;
                $regencyGeojson['features'][0]['properties']['unit'] = $regencyData->nameData->unit;
                $regencyGeojson['properties']['value'] = $regencyData->amount;
                $regencyGeojson['properties']['name'] = $regency->name;
                $regencyGeojson['properties']['data_name'] = $regencyData->nameData->name;
                $regencyGeojson['features'][0]['properties']['data_name'] = $regencyData->nameData->name;
                $regencyGeojson['properties']['category'] = $regencyData->nameData->category->name;
            }

            $features[] = $regencyGeojson;
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
