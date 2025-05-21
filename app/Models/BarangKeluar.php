<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';

    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($barangKeluar) {
            Handphone::where('id', $barangKeluar->id_handphone)->update(['id_status' => 2, 'id_kondisi' => $barangKeluar->id_kondisi]);
        });

        static::updated(function ($barangKeluar) {
            Handphone::where('id', $barangKeluar->id_handphone)->update(['id_kondisi' => $barangKeluar->id_kondisi]);
        });

        static::deleted(function ($barangKeluar) {
            Handphone::where('id', $barangKeluar->id_handphone)->update(['id_status' => 1]);
            $id_kondisi_masuk = BarangMasuk::where('id_handphone', $barangKeluar->id_handphone)->first()->id_kondisi;
            Handphone::where('id', $barangKeluar->id_handphone)->update(['id_kondisi' => $id_kondisi_masuk]);
            $path = 'bukti-barang-keluar/' . $barangKeluar->bukti_baerang_keluar;
            if ($barangKeluar->bukti_baerang_keluar && file_exists($path)) {
                unlink($path);
            }
        });
    }

    public function handphone()
    {
        return $this->belongsTo(Handphone::class, 'id_handphone');
    }

    public function kondisi()
    {
        return $this->belongsTo(RefKondisiBarang::class, 'id_kondisi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
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
