<?php

namespace App\Domains\Students\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return \Database\Factories\StudentFactory::new();
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'level',
        'registration_number',
        'status',
        'date_of_birth',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function name(): Attribute
    {
        return Attribute::get(fn () => trim("{$this->first_name} {$this->last_name}"));
    }
}
