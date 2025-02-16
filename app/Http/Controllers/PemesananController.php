<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\ResponseFormatter;
use App\Http\Requests\PemesananRequest;
use App\Http\Resources\PemesananResource;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index(ResponseFormatter $responseFormatter)
    {
        $data = PemesananResource::collection(Pemesanan::with(['jadwal', 'penumpang'])->get());
        try {
            return $responseFormatter->success($data, 'Berhasil!', '200');
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', '400');
        }
    }

    public function store(PemesananRequest $pemesananRequest, ResponseFormatter $responseFormatter)
    {
        $data = $pemesananRequest->validated();

        $jadwal = Jadwal::where('id', $data['jadwal_id'])->first();

        if ($jadwal['sisa'] >= $data['kuantitas']) {
            $total_harga = $data['kuantitas'] * $jadwal['harga'];
            $pemesanan = Pemesanan::create([
                'jadwal_id' => $data['jadwal_id'],
                'penumpang_id' => auth()->user()->penumpang->id,
                'kuantitas' => $data['kuantitas'],
                'total' => $total_harga,
            ]);
            $total_pemesanan = Pemesanan::where('jadwal_id', $data['jadwal_id'])->pluck('kuantitas')->sum();
            $sisa = $jadwal['kuota'] - $total_pemesanan;

            $jadwal->update([
                'sisa' => $sisa,
                'status' => ($sisa == 0 ? 0 : 1),
            ]);

            try {
                return $responseFormatter->success($pemesanan, 'Berhasil Dibuat!', '201');
            } catch (\Throwable $th) {
                return $responseFormatter->error($th, 'Error!', '400');
            }
        } else {
            return response()->json([
                'message' => 'Hanya tersisa ' . $jadwal['sisa'] . ' kuota',
                'code' => '400',
            ]);
        }
    }

    public function show(Pemesanan $pemesanan, ResponseFormatter $responseFormatter)
    {
        $data = new PemesananResource($pemesanan->load('jadwal', 'penumpang'));
        try {
            return $responseFormatter->success($data, 'Berhasil!', '200');
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', '400');
        }
    }

    public function update(Pemesanan $pemesanan, PemesananRequest $pemesananRequest, ResponseFormatter $responseFormatter)
    {
        $data = $pemesananRequest->validated();

        $jadwal = Jadwal::where('id', $data['jadwal_id'])->first();

        if ($jadwal['sisa'] >= $data['kuantitas']) {
            $total_harga = $data['kuantitas'] * $jadwal['harga'];
            $pemesanan->update([
                'jadwal_id' => $data['jadwal_id'],
                'kuantitas' => $data['kuantitas'],
                'total' => $total_harga,
            ]);
            $total_pemesanan = Pemesanan::where('jadwal_id', $data['jadwal_id'])->pluck('kuantitas')->sum();
            $sisa = $jadwal['kuota'] - $total_pemesanan;

            $jadwal->update([
                'sisa' => $sisa,
                'status' => ($sisa == 0 ? 0 : 1),
            ]);

            try {
                return $responseFormatter->success($pemesanan, 'Berhasil Dibuat!', '201');
            } catch (\Throwable $th) {
                return $responseFormatter->error($th, 'Error!', '400');
            }
        } else {
            return response()->json([
                'message' => 'Hanya tersisa ' . $jadwal['sisa'] . ' kuota',
                'code' => '400',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();
        $jadwal = Jadwal::where('id', $pemesanan['jadwal_id'])->first();
        $total_pemesanan = Pemesanan::where('jadwal_id', $pemesanan['jadwal_id'])->pluck('kuantitas')->sum();
        $sisa = $jadwal['kuota'] - $total_pemesanan;
        $jadwal->update([
            'sisa' => $sisa,
            'status' => ($sisa == 0 ? 0 : 1),
        ]);

        try {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Berhasil Dihapus!',
                ],
            ], 200);
        } catch (\Throwable $th) {
        }
    }
}
