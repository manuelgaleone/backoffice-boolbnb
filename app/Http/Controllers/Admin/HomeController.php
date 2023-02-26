<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use App\Models\Message;
use App\Models\Service;
use App\Http\Requests\StoreHomeRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateHomeRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Home $home)
    {
        $homes = Auth::user()->homes->sortDesc();
        /* dd(Auth::user()->homes); */
        /* $homes = Home::orderByDesc('id')->get(); */
        //dd($homes);
        return view('admin.homes.index', compact('homes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.homes.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeRequest $request, Home $home)
    {
        //pescare il valore di adress inserito nel form
        //montare questo valore nella chiamata api
        // . 'qualcosa' .' '.'qualcosaqualcosa'
        $val_data = $request->validated();

        $api_key = 'Tch0NAfmIoUvMhD8OyuIvJnGGUrV2269';

        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/search/' . $val_data['address'] . '.JSON?key=' . $api_key);

        $jsonData = $response->json();

        /* dd($jsonData['results'][0]['position']); */
        $val_data['latitude'] = $jsonData['results'][0]['position']['lat'];
        /* dd($val_data['latitude']); */
        $val_data['longitude'] = $jsonData['results'][0]['position']['lon'];

        if ($request->hasFile('cover_image')) {

            $cover_image = Storage::put('uploads', $val_data['cover_image']);
            $val_data['cover_image'] = $cover_image;
        }

        $slug_data = Home::createSlug($val_data['title']);

        $val_data['slug'] =  $slug_data;

        $val_data['user_id'] = Auth::id();

        $home = Home::create($val_data);

        if ($request->has('services')) {
            $home->services()->attach($val_data['services']);
        }

        return to_route('admin.homes.index')->with('message', "The home: $home->title added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home, Service $service, Message $message)
    {
        if ($home->user_id === Auth::user()->id) {
            $homes = Auth::user()->homes;

            $home_id = $home->id;
            $messages = DB::table('messages')->when($home_id, function ($query, $home_id) {
                $query->where('home_id', $home_id);
            })->get();

            $messages = $messages->map(function ($message) {
                $message->created_at = Carbon::parse($message->created_at)->format('H:i d-m-Y');
                return $message;
            });

            $services = Service::all();
            return view('admin.homes.show', compact('home', 'services', 'messages',));
        } else {
            $homes = Auth::user()->homes;
            return redirect()->route('admin.homes.index', compact('homes'))->with('message', "Non puoi accedere a questa casa!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        /* dd($home->user_id); */

        if ($home->user_id === Auth::user()->id) {
            $services = Service::all();
            return view('admin.homes.edit', compact('home', 'services'));
        } else {
            $homes = Auth::user()->homes;
            return redirect()->route('admin.homes.index', compact('homes'))->with('message', "Non puoi accedere a questa casa!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomeRequest  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeRequest $request, Home $home)
    {
        $val_data = $request->validated();

        $api_key = '1W1nNbKly7WXl6NvYnr7983RJJawL26E';

        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/search/' . $val_data['address'] . '.JSON?key=' . $api_key);

        $jsonData = $response->json();

        /* dd($jsonData['results'][0]['position']); */
        $val_data['latitude'] = $jsonData['results'][0]['position']['lat'];
        /* dd($val_data['latitude']); */
        $val_data['longitude'] = $jsonData['results'][0]['position']['lon'];

        if ($request->hasFile('cover_image')) {

            if ($home->cover_image) {
                Storage::delete($home->cover_image);
            }

            $cover_image = Storage::put('uploads', $val_data['cover_image']);
            //dd($cover_image);
            // replace the value of cover_image inside $val_data
            $val_data['cover_image'] = $cover_image;
        }

        $slug_data = Home::createSlug($val_data['title']);
        $val_data['slug'] =  $slug_data;
        //$home = Home::create($val_data);
        $home->update($val_data);


        if ($request->has('services')) {
            $home->services()->sync($val_data['services']);
        } else {
            $home->services()->sync([]);
        }

        /* if (array_key_exists('services', $val_data)) {
            $home->services()->sync($val_data['services']);
        } */

        // return redirect()->route('admin.homes.index');
        return to_route('admin.homes.index')->with('message', "The home: $home->title update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        if ($home->cover_image) {
            Storage::delete($home->cover_image);
        }

        // return redirect()->route('products.index');
        $home->delete();
        return redirect()->route('admin.homes.index')->with('message', "The home: $home->title deleted successfully");
    }

    public function dateFormatter(Message $message)
    {
    }
}
