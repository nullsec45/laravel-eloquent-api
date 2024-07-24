<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table="categories",
           $incrementing=true,
           $timestamps=true;

    protected $primaryKey="id",
              $keyType="int";
       
}
