<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::all();
        return response()->json
        (['success' => true, 
        'data' => $gurus]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:255|unique:gurus',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:gurus',
            'password' => 'required|string|min:8',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'mata_pelajaran' => 'required|string|max:255',
        ]);

        $guru = Guru::create($validated);
        return response()->json(['success' => true, 'data' => $guru], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru = Guru::findOrFail($guru->id);
        return response()->json(['success' => true, 'data' => $guru]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:255|unique:gurus,nik,' . $guru->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:gurus,email,' . $guru->id,
            'password' => 'nullable|string|min:8',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'mata_pelajaran' => 'required|string|max:255',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $guru->update($validated);
        return response()->json(['success' => true, 'data' => $guru]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru, string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return response()->json(['success' => true, 'message' => 'Guru deleted successfully']);
    }
}
