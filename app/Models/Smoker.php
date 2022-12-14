<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smoker extends Model
{
    use HasFactory;
    protected $table = "smoker";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'value',
        'others',
        'image',
    ];
}
