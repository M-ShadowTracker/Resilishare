<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

   public function answers()
{
    return $this->hasMany(QuizAnswer::class, 'question_id'); // correspond au nom réel
}
}