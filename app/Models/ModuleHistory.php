<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'name',
        'type',
        'description',
        'speed',
        'temperature',
        'online',
    ];

    public function module(){
        return $this->belongsTo(Module::class);
    }
}
