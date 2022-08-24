<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = "image";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'image',
        'latitude',
        'longitude',
        'patient',
        'date',
        'name',
        'email',
        'birthdate',
        'age',
        'gender',
        'covid',
        'pathology',
    ];

    public function healthProblem()
    {
        return $this->hasOne(Health::class,'image','id');
    }

    public function medication()
    {
        return $this->hasOne(Medication::class,'image','id');
    }

    public function smoker()
    {
        return $this->hasOne(Smoker::class,'image','id');
    }
}
