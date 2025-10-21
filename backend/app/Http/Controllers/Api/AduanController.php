<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aduan;
use Illuminate\Support\Facades\Validator;

class AduanController extends Controller
{
    // Menampilkan semua aduan (bisa difilter dengan status)
    public function index(Request $request)
    {
        $status = $request->query('status'); // ?status=terkirim
        $query = Aduan::query();

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

    // Menyimpan aduan baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'user_id' => 'required|int|max:100',
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
            'user_id' => $request->user_id,
            'status' => '1', // default status ketika baru dikirim
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Aduan berhasil ditambahkan!',
            'data' => $aduan
        ], 201);
    }

    // Menampilkan aduan milik warga login
    public function getByWarga(Request $request)
    {
        $user = $request->user(); // user login (misalnya auth:api)
        $aduans = Aduan::where('user_id', $user->name)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $aduans
        ]);
    }

    // Untuk RT: ubah status aduan (diproses / selesai)
    public function updateStatus(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'status' => 'required|in:1,2,3'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $aduan = Aduan::findOrFail($id);

    // optional: cek apakah RT berwenang untuk aduan ini
    // if ($aduan->rt_id !== auth()->user()->id) {
    //     return response()->json(['message'=>'Unauthorized'], 403);
    // }

    $aduan->update(['status' => $request->status]);

    return response()->json([
        'success' => true,
        'message' => 'Status aduan berhasil diperbarui!',
        'data' => $aduan
    ]);
}
}
