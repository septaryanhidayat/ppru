<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpc extends Model
{
    use HasFactory;

    protected $table = 'dpcs';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'head_name',
        'address',
        'order',
    ];
}
