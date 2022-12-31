<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $primaryKey = 'block_number';
    public $timestamps = false;
    protected $fillable = ['block_number', 'timestamp'];
}
