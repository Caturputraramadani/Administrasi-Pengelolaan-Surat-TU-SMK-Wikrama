<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;
    protected $fillable = [
        'letter_code', 'name_type', 'content', 'recipients', 'notulis',
        // Tambahkan properti yang diperlukan di sini
    ];

    // Definisikan relasi jika diperlukan
    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
   
    public function notulisUser()
    {
        return $this->belongsTo(User::class, 'notulis');
    }

    public function getLetterCountAttribute()
    {
        return $this->letters->count();
    }


    public function recipientsUsers()
    {
        return $this->hasManyThrough(User::class, Letter::class, 'letter_type_id', 'id', 'id', 'notulis')
            ->distinct();
    }
}
