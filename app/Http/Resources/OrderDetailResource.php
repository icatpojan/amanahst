<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            // 'product_id',
            // 'order_id',
            'jumlah_pesan' => $this->jumlah,
            'jumlah_harga' => $this->jumlah_harga,
            'name' => $this->product->name,
            'customer_id' => $this->product->customer_id,
            'status' => $this->order->status,
        ];
        // return parent::toArray($request);
    }
}
