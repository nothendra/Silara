<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aduan;
use Illuminate\Support\Facades\Validator;

class AduanController extends Controller
{
    public function index()
    {
        $aduan = Aduan::latest()->get();
        return response()->json(['data' => $aduan], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'nama_pengadu' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('aduan', 'public');
        }

        $aduan = Aduan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'tanggal' => $request->tanggal,
            'nama_pengadu' => $request->nama_pengadu,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Aduan berhasil ditambahkan!',
            'data' => $aduan
        ], 201);
    }
}
