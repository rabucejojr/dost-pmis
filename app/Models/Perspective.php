<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perspective extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'implementing_year',
        'name',
        'description',
        'code',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    // Scope for year filtering
    public function scopeYear($query, $year)
    {
        return $query->where('implementing_year', $year);
    }

    // Auto-generate code before creation
    protected static function booted()
    {
        static::creating(function ($perspective) {
            // Ensure year is provided
            if (! $perspective->implementing_year) {
                throw new \Exception('Implementing year is required for Perspective.');
            }

            // Count only within the same year
            $count = self::where('implementing_year', $perspective->implementing_year)->count() + 1;
            $perspective->code = "{$perspective->implementing_year}-P-".str_pad($count, 2, '0', STR_PAD_LEFT);
        });
    }
}
