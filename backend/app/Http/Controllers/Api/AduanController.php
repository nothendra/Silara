<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aduan;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Validator;

class AduanController extends Controller
{
    // Menampilkan semua aduan - RT & ADMIN ONLY
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Cek role
        if (!in_array($user->role, ['rt', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hanya RT dan Admin yang bisa melihat semua laporan.',
                'your_role' => $user->role
            ], 403);
        }

        $status = $request->query('status');
        $query = Aduan::with('user:id,name,email');

        if ($status) {
            if (!in_array((int) $status, [1, 2, 3])) {
                return response()->json([
                    'success' => false,
                    'message' => "Status tidak valid. Gunakan 1, 2, atau 3."
                ], 400);
            }
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

    // Menyimpan aduan baru - WARGA ONLY
    public function store(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'warga') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Warga yang bisa membuat laporan.'
            ], 403);
        }

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

        $aduan->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Aduan berhasil ditambahkan!',
            'data' => $aduan
        ], 201);
    }

    // Menampilkan aduan milik warga login - WARGA ONLY
    public function getByWarga(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'warga') {
            return response()->json([
                'success' => false,
                'message' => 'Endpoint ini hanya untuk Warga.'
            ], 403);
        }

        $status = $request->query('status');
        $query = Aduan::where('user_id', $user->id)->with('user:id,name,email');

        if ($status && in_array((int) $status, [1, 2, 3])) {
            $query->where('status', $status);
        }

        $aduans = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $aduans
        ], 200);
    }

    // Menampilkan detail aduan
    public function show($id)
    {
        $aduan = Aduan::with(['user:id,name,email'])->find($id);

        if (!$aduan) {
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan'
            ], 404);
        }

        $user = auth()->user();

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

    // RT: Kirim rekomendasi - RT ONLY
    public function sendRecommendation(Request $request, $id)
    {
        $user = $request->user();
        
        if ($user->role !== 'rt') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya RT yang bisa mengirim rekomendasi.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'recommended_status' => 'required|integer|in:1,2,3',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $aduan = Aduan::find($id);

        if (!$aduan) {
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan'
            ], 404);
        }

        $existingPending = Recommendation::where('aduan_id', $id)
            ->where('rt_id', auth()->id())
            ->where('approval_status', 'pending')
            ->exists();

        if ($existingPending) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengirim rekomendasi untuk aduan ini.'
            ], 400);
        }

        $recommendation = Recommendation::create([
            'aduan_id' => $id,
            'rt_id' => auth()->id(),
            'recommended_status' => $request->recommended_status,
            'notes' => $request->notes,
            'approval_status' => 'pending',
        ]);

        $recommendation->load(['aduan.user:id,name,email', 'rt:id,name,email']);

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil dikirim ke Admin!',
            'data' => $recommendation
        ], 201);
    }

    // ADMIN: Lihat rekomendasi - ADMIN ONLY
    public function getRecommendations(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang bisa melihat rekomendasi.'
            ], 403);
        }

        $status = $request->query('status', 'pending');
        $query = Recommendation::with([
            'aduan.user:id,name,email',
            'rt:id,name,email',
            'admin:id,name,email'
        ])->where('approval_status', $status);

        $recommendations = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => "Daftar rekomendasi: $status",
            'data' => $recommendations
        ], 200);
    }

    // ADMIN: Handle rekomendasi - ADMIN ONLY
    public function handleRecommendation(Request $request, $recommendationId)
    {
        $user = $request->user();
        
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang bisa approve/reject rekomendasi.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $recommendation = Recommendation::with(['aduan', 'rt:id,name,email'])->find($recommendationId);

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Rekomendasi tidak ditemukan'
            ], 404);
        }

        if ($recommendation->approval_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Rekomendasi sudah diproses'
            ], 400);
        }

        $action = $request->action;

        $recommendation->update([
            'approval_status' => $action === 'approve' ? 'approved' : 'rejected',
            'approved_by' => auth()->id(),
            'admin_notes' => $request->admin_notes,
            'approved_at' => now(),
        ]);

        if ($action === 'approve') {
            $recommendation->aduan->update([
                'status' => $recommendation->recommended_status
            ]);
        }

        $recommendation->load(['aduan.user:id,name,email', 'rt:id,name,email', 'admin:id,name,email']);

        return response()->json([
            'success' => true,
            'message' => $action === 'approve' 
                ? 'Rekomendasi disetujui! Status berhasil diperbarui.' 
                : 'Rekomendasi ditolak.',
            'data' => $recommendation
        ], 200);
    }

    // ADMIN: Ubah status langsung - ADMIN ONLY
    public function updateStatus(Request $request, $id)
    {
        $user = $request->user();
        
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang bisa mengubah status langsung.'
            ], 403);
        }

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
            'message' => 'Status berhasil diperbarui!',
            'data' => $aduan
        ], 200);
    }
}