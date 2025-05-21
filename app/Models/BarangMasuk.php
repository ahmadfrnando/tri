<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($barangMasuk) {
            Handphone::where('id', $barangMasuk->id_handphone)->update(['id_kondisi' => $barangMasuk->id_kondisi, 'id_status' => 1]);
        });

        static::updated(function ($barangMasuk) {
            Handphone::where('id', $barangMasuk->id_handphone)->update(['id_kondisi' => $barangMasuk->id_kondisi]);
        });

        static::deleted(function ($barangMasuk) {
            Handphone::where('id', $barangMasuk->id_handphone)->update(['id_status' => 100]);
            Handphone::where('id', $barangMasuk->id_handphone)->update(['id_kondisi' => null]);
            $path = 'storage/' . $barangMasuk->bukti_barang_masuk;
            if ($barangMasuk->bukti_barang_masuk && file_exists($path)) {
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

    public function getBadgeKondisi()
    {
        $kondisi = $this->kondisi;

        switch ($kondisi->id) {
            case 1:
                return '<span class="badge text-bg-primary">' . $kondisi->kondisi_barang . '</span>';
                break;
            case 2:
                return '<span class="badge text-bg-warning">' . $kondisi->kondisi_barang . '</span>';
                break;
            case 3:
                return '<span class="badge text-bg-danger">' . $kondisi->kondisi_barang . '</span>';
                break;
            case 4:
                return '<span class="badge text-bg-success">' . $kondisi->kondisi_barang . '</span>';
                break;

            default:
                return '<span class="badge text-bg-secondary">Tidak Tersedia</span>';
                break;
        }
    }
}
