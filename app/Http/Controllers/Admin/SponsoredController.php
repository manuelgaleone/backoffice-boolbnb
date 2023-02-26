<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsored;
use App\Http\Requests\StoreSponsoredRequest;
use App\Http\Requests\UpdateSponsoredRequest;

class SponsoredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsoreds = Sponsored::orderByDesc('id')->get();
        //dd($sponsoreds);
        return view('admin.sponsored.index', compact('sponsoreds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sponsored.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSponsoredRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSponsoredRequest $request)
    {
        $val_data = $request->validated();

        $slug_data = Sponsored::createSlug($val_data['title']);

        $val_data['slug'] =  $slug_data;

        $sponsored = Sponsored::create($val_data);

        return to_route('admin.sponsored.index')->with('message', "The Sponsored: $sponsored->title added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponsored  $sponsored
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsored $sponsored)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsored  $sponsored
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsored $sponsored)
    {
        $sponsoreds = Sponsored::all();
        return view('admin.sponsored.edit', compact('sponsored'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSponsoredRequest  $request
     * @param  \App\Models\Sponsored  $sponsored
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSponsoredRequest $request, Sponsored $sponsored)
    {
        $val_data = $request->validated();

        $slug_data = Sponsored::createSlug($val_data['title']);

        $val_data['slug'] =  $slug_data;

        $sponsored->update($val_data);

        return to_route('admin.sponsored.index')->with('message', "The Sponsored: $sponsored->title update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsored  $sponsored
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsored $sponsored)
    {
        $sponsored->delete();
        return redirect()->route('admin.sponsored.index')->with('message', "The Sponsored: $sponsored->title deleted successfully");
    }
}
