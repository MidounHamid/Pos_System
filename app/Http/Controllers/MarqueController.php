<?php

namespace App\Http\Controllers;

use App\Models\marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marques = marque::all();

        return view('marques.index', compact('marques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        marque::create($request->all());
        return redirect()->route("marques.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(marque $marque)
    {
        return view('marques.show', compact('marque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(marque $marque)
    {
        return view('marques.edit', compact('marque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, marque $marque)
    {
        $marque->update($request->all());

        return redirect()->route("marques.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(marque $marque)
    {
        $marque->delete();
        return redirect()->route("marques.index");
    }
}
