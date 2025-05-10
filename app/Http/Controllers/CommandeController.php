<?php

namespace App\Http\Controllers;

use App\Models\commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = commande::all();

        return view('commandes.index', compact('commandes'));    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        commande::create($request->all());
        return redirect()->route("commandes.index");    }

    /**
     * Display the specified resource.
     */
    public function show(commande $commande)
    {
        return view('commandes.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(commande $commande)
    {
        return view('commandes.edit', compact('commande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, commande $commande)
    {
        $commande->update($request->all());

        return redirect()->route("commandes.index");    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(commande $commande)
    {
        $commande->delete();
        return redirect()->route("commandes.index");    }
}
