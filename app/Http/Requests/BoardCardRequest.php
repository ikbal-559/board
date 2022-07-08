<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardCardRequest extends FormRequest
{
     public function rules()
    {
        return [
            'title' => 'required|string|max:1000',
            'column_id' => 'required',
            'description' => 'required',
        ];
    }

}
