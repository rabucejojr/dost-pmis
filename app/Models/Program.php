<?php

namespace App\Models;

use App\Enums\ProgramType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'description',
        'slug',
        'type',
    ];

    protected $casts = [
        'type' => ProgramType::class,
    ];

    protected function label(): string
    {
        return $this->type->label();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
