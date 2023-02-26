<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function sponsored()
    {
        $homes = Home::with(['services'])->where('sponsored', '=', 1)->get();

        if ($homes->count() > 0) {
            return response()->json([
                'success' => true,
                'data' => $homes
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Nessuna Casa trovata.'
            ]);
        }
    }

    public function quellaBuona($latitude, $longitude, $radius)
    {
        $radius = 6371;

        $filteredHomes = Home::with(['services' => function ($query) {
            $query->select('services.id', 'services.title');
        }])
            ->select(DB::raw('homes.*, ( ' . $radius . ' * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians(latitude) ) ) ) AS distance'))
            ->leftJoin('home_service', 'homes.id', '=', 'home_service.home_id')
            ->where('visible', 1)
            ->having('distance', '<', 20)
            ->groupBy('homes.id')
            ->orderBy('distance')
            ->get();

        return response()->json([
            'result' => 'success',
            'data' => $filteredHomes,
        ]);
    }

    public function searchHomes($latitude, $longitude, $radius)
    {
        $radius = 6371;

        $filteredHomes = DB::select(DB::raw('SELECT *, ( ' . $radius . ' * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians(latitude) ) ) ) AS distance FROM homes WHERE visible=1 HAVING distance < 20 ORDER BY distance'));

        return response()->json([
            'result' => 'success',
            'data' => $filteredHomes,

        ]);
    }

    public function filterHomes(Request $request, $latitude, $longitude, $radius)
    {
        $radius = 6371;

        // Recupera i parametri di query dalla richiesta
        $rooms = $request->query('rooms');
        $services = $request->query('services');

        $query = 'SELECT *, ( ' . $radius . ' * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians(latitude) ) ) ) AS distance FROM homes WHERE visible=1';

        if ($rooms) {
            $query .= ' AND rooms = ' . $rooms;
        }

        if ($services) {
            // Costruisci la clausola WHERE usando l'operatore IN
            $servicesArray = explode(',', $services);
            $servicesInClause = implode(',', array_fill(0, count($servicesArray), '?'));
            $query .= ' AND service_id IN (' . $servicesInClause . ')';
        }

        $query .= ' HAVING distance < 20 ORDER BY distance';

        $filteredHomes = DB::select(DB::raw($query), $servicesArray ?? []);

        return response()->json([
            'result' => 'success',
            'data' => $filteredHomes,
        ]);
    }

    public function getServices()
    {
        $services = DB::table('services')->get();
        return response()->json([
            'result' => 'success',
            'data' => $services,
        ]);
    }

    public function index()
    {
        $homes = Home::with('services')->get();
        if ($homes) {
            return response()->json([
                'success' => true,
                'data' => $homes
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Nessuna Casa trovata.'
            ]);
        }
    }

    public function show($slug)
    {
        $homes = Home::with('services')->where('slug', $slug)->first();

        if ($homes) {
            return response()->json([
                'success' => true,
                'data' => $homes
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Nessuna Casa trovata.'
            ]);
        }
    }
}
