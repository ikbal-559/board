<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardCardsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'column_id' => $this->column_id,
            'order' => $this->order,
            'title' => $this->title,
            'description' => $this->description,
            'created' => Carbon::parse($this->created_at)->format('d M')
        ];
    }
}
