<?php

namespace App\Http\Controllers;

use App\Models\unite;
use Illuminate\Http\Request;

class UniteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unites = unite::all();

        return view('unites.index', compact('unites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        unite::create($request->all());
        return redirect()->route("unites.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(unite $unite)
    {
        return view('unites.show', compact('unite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(unite $unite)
    {
        return view('unites.edit', compact('unite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, unite $unite)
    {
        $unite->update($request->all());

        return redirect()->route("unites.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(unite $unite)
    {
        $unite->delete();
        return redirect()->route("unites.index");
    }
}
