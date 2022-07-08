<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardCard extends Model
{
    protected $fillable = [
        'column_id',
        'order',
        'title',
        'description',
    ];

}
