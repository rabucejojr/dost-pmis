<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Objective extends Model
{
    use HasFactory;

    protected $fillable = [
        'perspective_id',
        'name',
        'description',
        'code',
    ];

    public function perspective()
    {
        return $this->belongsTo(Perspective::class);
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }

    public function scopeYear($query, $year)
    {
        return $query->where('implementing_year', $year);
    }

    protected static function booted()
    {
        static::creating(function ($objective) {
            $perspective = $objective->perspective;

            if (!$perspective) {
                throw new \Exception('Perspective must exist before creating an Objective.');
            }

            // Always cascade year from parent
            $objective->implementing_year = $perspective->implementing_year;

            // Generate code within the same perspective
            $count = $perspective->objectives()->count() + 1;
            $objective->code = "{$perspective->code}-O-" . str_pad($count, 3, '0', STR_PAD_LEFT);
        });

        // Prevent changing year/code after creation
        static::updating(function ($objective) {

            $perspective = $objective->perspective;

            if (!$perspective) {
                throw new \Exception('Perspective must exist before creating an Objective.');
            }

            $count = $perspective->objectives()->count() + 1;
            $objective->code = "{$perspective->code}-O-" . str_pad($count, 2, '0', STR_PAD_LEFT);

            if ($perspective->isDirty('implementing_year') || $perspective->isDirty('code')) {
                throw new \Exception('Cannot modify implementing year or code after creation.');
            }
        });


        // Prevent editing year/code
        static::updating(function ($objective) {
            if ($objective->isDirty('implementing_year') || $objective->isDirty('code')) {
                throw new \Exception('Cannot modify implementing year or code after creation.');
            }
        });

    }
}
