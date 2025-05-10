<?php

namespace App\Http\Controllers;

use App\Models\mode_reglement;
use Illuminate\Http\Request;

class ModeReglementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mode_reglements = mode_reglement::all();

        return view('mode_reglements.index', compact('mode_reglements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mode_reglements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        mode_reglement::create($request->all());
        return redirect()->route("mode_reglements.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(mode_reglement $mode_reglement)
    {
        return view('mode_reglements.show', compact('mode_reglement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(mode_reglement $mode_reglement)
    {
        return view('mode_reglements.edit', compact('mode_reglement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, mode_reglement $mode_reglement)
    {
        $mode_reglement->update($request->all());

        return redirect()->route("mode_reglements.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mode_reglement $mode_reglement)
    {
        $mode_reglement->delete();
        return redirect()->route("mode_reglements.index");
    }
}
