<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'memo_id' => $this->memo_id,
            'title' => $this->title,
            'short_desc' => $this->short_desc,
            'file_path' => $this->file_path,
            'effectivity_date' => $this->effectivity_date,
            'issued_date' => $this->issued_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
