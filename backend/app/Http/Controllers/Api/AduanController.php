<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aduan;
use Illuminate\Support\Facades\Validator;

class AduanController extends Controller
{
    // Menampilkan semua aduan (bisa difilter dengan status) - HANYA RT & ADMIN
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Aduan::with('user:id,name,email'); // Load relasi user

        if ($status) {
            $query->where('status', $status);
        }

        $aduan = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => $status 
                ? "Daftar aduan dengan status '$status'" 
                : "Daftar semua aduan",
            'data' => $aduan
        ], 200);
    }

    // Menyimpan aduan baru - WARGA
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
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
            'user_id' => auth()->id(),
            'status' => 1,
        ]);

        // Load relasi user
        $aduan->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Aduan berhasil ditambahkan!',
            'data' => $aduan
        ], 201);
    }

    // Menampilkan aduan milik warga login - WARGA
    public function getByWarga(Request $request)
    {
        $user = $request->user();
        $aduans = Aduan::where('user_id', $user->id)
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $aduans
        ], 200);
    }

    // Menampilkan detail aduan tertentu
    public function show($id)
    {
        $aduan = Aduan::with('user:id,name,email')->find($id);

        if (!$aduan) {
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan'
            ], 404);
        }

        $user = auth()->user();
        
        // Hanya RT, Admin, atau pemilik aduan yang bisa akses
        if (!in_array($user->role, ['rt', 'admin']) && $aduan->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke aduan ini'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $aduan
        ], 200);
    }

    // Untuk RT & Admin: ubah status aduan
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|integer|in:1,2,3'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $aduan = Aduan::with('user:id,name,email')->find($id);

        if (!$aduan) {
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan'
            ], 404);
        }

        $aduan->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status aduan berhasil diperbarui!',
            'data' => $aduan
        ], 200);
    }
}