<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';
    protected $guarded = ['id'];
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'penumpang_id');
    }
}
