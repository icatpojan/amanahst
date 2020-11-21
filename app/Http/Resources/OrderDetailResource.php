<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Product;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        dd($this->Product);
        return [

            'id' => $this->id,
            // 'product_id',
            // 'order_id',
            'jumlah_pesan' => $this->jumlah,
            'jumlah_harga' => $this->jumlah_harga,
            'name' => $this->Product->name,
            'customer_id' => $this->Product->customer_id,
            'status' => $this->Order->status,
        ];
        // return parent::toArray($request);
    }
}
