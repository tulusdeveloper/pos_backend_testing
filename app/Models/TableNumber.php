<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableNumber extends Model
{
    use HasFactory;

    protected $table = 'table_numbers';
    
    protected $fillable = [
        'number', 
    ];
}
