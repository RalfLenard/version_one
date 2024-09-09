<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
    'animal_id',
    'user_id',
    'animal_name',
    'first_name',
    'last_name',
    'gender',
    'phone_number',
    'address',
    'salary',
    'question1',
    'question2',
    'question3',
    'valid_id',
    'valid_id_with_owner',
    ];


    // Relationship with the Animal model
    public function animalProfile()
    {
        return $this->belongsTo(AnimalProfile::class, 'animal_id');
    }

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'adoption_request_id');
    }
}
