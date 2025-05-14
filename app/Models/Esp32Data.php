<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esp32Data extends Model
{
    // use HasFactory;
    protected $table = "esp32_data";
    protected $fillable = ['temperature', 'humidity','LightIntensity','weight'];
}
