<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'speed',
        'temperature',
        'online',
        'functional',
        'user_id',
    ];

    public function getFunctionTime()
    {
        $curTime = time();
        return $curTime - $this->created_at->timestamp;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(ModuleHistory::class);
    }
}
