<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRating extends Model
{
    protected $table = 'category_rating';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        "rate",
        "content",
        "added_date",
        "rider_id",
        "category_id"
    ];
}
