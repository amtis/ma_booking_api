<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    const ORDER_BY = [
        'slug',
        'title',
        'start_date',
        'price'
    ];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'price',
    ];

    protected $casts = [
        'price' => 'float'
    ];
}
