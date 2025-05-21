<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKondisiBarang extends Model
{
    use HasFactory;

    protected $table = 'ref_kondisi_barang';

    protected $guarded = [];
}
