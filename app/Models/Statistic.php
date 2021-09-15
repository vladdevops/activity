<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Statistic extends Model
{
    use HasFactory;

    protected $guarded = ['uuid'];
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $fillable = [
        'url',
    ];

    public $incrementing = false;
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Str::uuid();
        });
    }
}
