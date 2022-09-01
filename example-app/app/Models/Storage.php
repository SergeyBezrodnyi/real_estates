<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RealEstate;

class Storage extends Model
{
    use HasFactory;

    protected $table = 'storages';

    /**
     * @var array
     */
    protected $fillable = [
        'real_estate_id',
        'file_name',
        's3_path'
    ];
}
