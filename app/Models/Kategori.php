<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['deskripsi', 'kategori'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public static function search($query)
    {
        return self::where('deskripsi', 'LIKE', "%{$query}%")
            ->orWhere('kategori', 'LIKE', "%{$query}%")
            ->get();
    }
}