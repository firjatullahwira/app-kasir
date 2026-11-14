<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'nama' => $this->nama,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'category' => [
                'id' => $this->category?->id,
                'nama_kategori' => $this->category?->nama_kategori,
            ],
        ];
    }
}
