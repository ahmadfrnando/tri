<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class ApprovalUsulanBarangBaru extends Model
{
    use HasFactory;

    protected $table = 'usulan_barang_baru';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function status()
    {
        return $this->belongsTo(RefStatusUsulan::class, 'id_status_usulan');
    }
}
