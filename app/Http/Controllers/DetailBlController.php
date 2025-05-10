<?php

namespace App\Http\Controllers;

use App\Models\detail_bl;
use Illuminate\Http\Request;

class DetailBlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details_bl = detail_bl::all(); // Correct variable name

        return view('details_bl.index', compact('details_bl')); // Match variable name here
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('details_bl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        detail_bl::create($request->all());
        return redirect()->route("details_bl.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(detail_bl $detail_bl)
    {
        return view('details_bl.show', compact('detail_bl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(detail_bl $detail_bl)
    {
        return view('details_bl.edit', compact('detail_bl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, detail_bl $detail_bl)
    {
        $detail_bl->update($request->all());

        return redirect()->route("details_bl.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(detail_bl $detail_bl)
    {
        $detail_bl->delete();
        return redirect()->route("details_bl.index");
    }
}
