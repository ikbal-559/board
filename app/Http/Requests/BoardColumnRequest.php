<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardColumnRequest extends FormRequest
{
     public function rules()
    {
        return [
            'title' => 'required|string|max:1000'
        ];
    }

}
