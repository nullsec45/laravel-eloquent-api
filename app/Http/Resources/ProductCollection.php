<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public static $wrap="data";
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // jika wrap nya sama dengan parent wrap, maka pakai wrap parentnya.
            // jika tidak sama dengan wrap parentnya maka dia pakai wrap milik  childnya
            "data" => ProductResource::collection($this->collection)
        ];
    }
}
