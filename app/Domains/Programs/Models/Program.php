<?php

namespace App\Domains\Programs\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return \Database\Factories\ProgramFactory::new();
    }

    protected $fillable = [
        'name',
        'slug',
        'code',
        'department',
        'overview',
        'career_opportunities',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
