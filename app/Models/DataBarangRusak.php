<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarangRusak extends Model
{
    use HasFactory;

    protected $table = 'data_barang_rusak';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($dataBarangRusak) {
            $dataBarangRusak->handphone->update(['id_kondisi' => $dataBarangRusak->id_kondisi]);
        });
        static::deleted(function ($dataBarangRusak) {
            $dataBarangRusak->handphone->update(['id_kondisi' => 1]);
            $path = 'storage/' . $dataBarangRusak->bukti_barang_rusak;
            if ($dataBarangRusak->bukti_barang_rusak && file_exists($path)) {
                unlink($path);
            }
        });
    }

    public function handphone()
    {
        return $this->belongsTo(Handphone::class, 'id_handphone');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kondisi()
    {
        return $this->belongsTo(RefKondisiBarang::class, 'id_kondisi');
    }
}
