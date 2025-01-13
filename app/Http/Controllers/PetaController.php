<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $show = $request->input('show', 'provincies');

        switch ($show) {
            case 'earth-quakes':
                $data = json_decode(file_get_contents('https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json', true));
                break;
            case 'regencies':
                $data = Regency::all();
                $data->load('province:id,name');
                break;
            default:
                $data = Province::all();
        }

        return view('index', compact('data', 'show'));
    }
}
