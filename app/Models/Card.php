<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $appends = ['animal_traits'];
    public function getAnimalTraitsAttribute()
    {
        return $this->hasOne(AnimalTrait::class, 'id', 'animal_traits_id')->getResults();
    }
}
