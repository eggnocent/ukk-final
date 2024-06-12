<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = ['merk', 'seri', 'spesifikasi', 'stok', 'kategori_id', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public static function search($query)
    {
        return self::where('merk', 'LIKE', "%{$query}%")
            ->orWhere('seri', 'LIKE', "%{$query}%")
            ->orWhere('spesifikasi', 'LIKE', "%{$query}%")
            ->orWhere('foto', 'LIKE', "%{$query}%")
            ->orWhere('kategori_id', 'LIKE', "%{$query}%")
            ->get();
    }
}