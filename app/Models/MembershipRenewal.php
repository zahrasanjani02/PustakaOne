<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipRenewal extends Model
{
    use HasFactory;

    // Ini supaya kita bisa simpan data pakai ::create([])
    protected $guarded = ['id'];

    // Relasi ke User (Supaya kita tahu siapa yang minta perpanjangan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}