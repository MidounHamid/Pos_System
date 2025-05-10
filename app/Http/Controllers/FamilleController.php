<?php

namespace App\Http\Controllers;

use App\Models\famille;
use Illuminate\Http\Request;

class FamilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familles = famille::all();

        return view('familles.index', compact('familles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('familles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        famille::create($request->all());
        return redirect()->route("familles.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(famille $famille)
    {
        return view('familles.show', compact('famille'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(famille $famille)
    {
        return view('familles.edit', compact('famille'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, famille $famille)
    {
        $famille->update($request->all());

        return redirect()->route("familles.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(famille $famille)
    {
        $famille->delete();
        return redirect()->route("familles.index");
    }
}
