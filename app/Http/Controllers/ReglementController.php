<?php

namespace App\Http\Controllers;

use App\Models\reglement;
use Illuminate\Http\Request;

class ReglementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reglements = reglement::all();

        return view('reglements.index', compact('reglements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reglements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        reglement::create($request->all());
        return redirect()->route("reglements.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(reglement $reglement)
    {
        return view('reglements.show', compact('reglement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reglement $reglement)
    {
        return view('reglements.edit', compact('reglement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reglement $reglement)
    {
        $reglement->update($request->all());

        return redirect()->route("reglements.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reglement $reglement)
    {
        $reglement->delete();
        return redirect()->route("reglements.index");
    }
}
