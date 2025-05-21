<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handphone extends Model
{
    use HasFactory;

    protected $table = 'handphone';

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($handphone) {
            BarangMasuk::where('id_handphone', $handphone->id)->delete();
            BarangKeluar::where('id_handphone', $handphone->id)->delete();
            DataBarangRusak::where('id_handphone', $handphone->id)->delete();
        });
    }

    public function ram()
    {
        return $this->belongsTo(RefRamHandphone::class, 'id_ram');
    }

    public function kondisi()
    {
        return $this->belongsTo(RefKondisiBarang::class, 'id_kondisi');
    }

    public function tipe()
    {
        return $this->belongsTo(RefTipeHandphone::class, 'id_tipe_handphone');
    }

    public function status()
    {
        return $this->belongsTo(RefStatusHandphone::class, 'id_status');
    }

    public function getBadgeKondisi()
    {
        $kondisi = $this->kondisi;
        if (!$kondisi) {
            return '<span class="badge text-bg-secondary">-</span>';
        }

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
    public function getBadgeStatus()
    {
        $status = $this->status;

        if (!$status) {
            return '<span class="badge text-bg-secondary">-</span>';
        }

        switch ($status->id) {
            case 1:
                return '<span class="badge text-bg-primary">' . $status->status_handphone . '</span>';
                break;
            case 2:
                return '<span class="badge text-bg-danger">' . $status->status_handphone . '</span>';
                break;
            case 3:
                return '<span class="badge text-bg-warning">' . $status->status_handphone . '</span>';
                break;
            case 4:
                return '<span class="badge text-bg-success">' . $status->status_handphone . '</span>';
                break;
            case 100:
                return '<span class="badge text-bg-secondary">' . $status->status_handphone . '</span>';
                break;

            default:
                return '<span class="badge text-bg-secondary">Tidak Tersedia</span>';
                break;
        }
    }
}
