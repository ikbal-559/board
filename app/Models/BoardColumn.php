<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardColumn extends Model
{
    protected $fillable = [
        'title'
    ];

    public function cards()
    {
        return $this->hasMany(BoardCard::class, 'column_id')->orderBy('order', 'asc');
    }
}
