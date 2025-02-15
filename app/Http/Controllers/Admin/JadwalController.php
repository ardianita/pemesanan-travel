<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalRequest;
use App\Http\Resources\JadwalResource;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(ResponseFormatter $responseFormatter)
    {
        $jadwals = JadwalResource::collection(Jadwal::all());
        try {
            return $responseFormatter->success($jadwals, 'Berhasil!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', 400);
        }
    }

    public function store(JadwalRequest $jadwalRequest, ResponseFormatter $responseFormatter)
    {
        $data = $jadwalRequest->validated();
        $jadwal = Jadwal::create($data);
        try {
            return $responseFormatter->success($jadwal, 'Berhasil Dibuat!', 201);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', 400);
        }
    }

    public function show(Jadwal $jadwal, ResponseFormatter $responseFormatter)
    {
        $data = new JadwalResource($jadwal);
        try {
            return $responseFormatter->success($data, 'Berhasil!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', 400);
        }
    }

    public function update(JadwalRequest $jadwalRequest, Jadwal $jadwal, ResponseFormatter $responseFormatter)
    {
        $data = $jadwalRequest->validated();
        $jadwal->update($data);
        try {
            return $responseFormatter->success($jadwal, 'Berhasil Diubah!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Error!', 400);
        }
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Berhasil Dihapus!',
            ],
        ], 200);
    }
}
