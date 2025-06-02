<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URLTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'is_safe',
        'details',
    ];

    protected $casts = [
        'is_safe' => 'boolean',
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $table = 'url_tests';

}