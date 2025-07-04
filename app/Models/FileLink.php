<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FileLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'storage_path',
        'description',
        'access_code',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }
}