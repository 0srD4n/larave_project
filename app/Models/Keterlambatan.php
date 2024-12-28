<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model
{
    protected $table = 'keterlambatan_siswa';
    protected $fillable = ['user_id', 'waktu_keterlambatan', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}