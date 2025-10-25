<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'objective_id',
        'implementing_year',
        'name',
        'description',
        'target_value',
        'actual_value',
        'unit',
        'frequency',
        'code',
    ];

    // 🔗 Relationship
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    // 🔍 Scope for year filtering
    public function scopeYear($query, $year)
    {
        return $query->where('implementing_year', $year);
    }

    protected static function booted()
    {
        // ✅ Cascade year + code from Objective
        static::creating(function ($indicator) {
            $objective = $indicator->objective;

            if (!$objective) {
                throw new \Exception('Objective must exist before creating an Indicator.');
            }

            $indicator->implementing_year = $objective->implementing_year;

            $count = $objective->indicators()->count() + 1;
            $indicator->code = "{$objective->code}-I-" . str_pad($count, 3, '0', STR_PAD_LEFT);
        });

        // 🚫 Prevent changing year/code
        static::updating(function ($indicator) {
            if ($indicator->isDirty('implementing_year') || $indicator->isDirty('code')) {
                throw new \Exception('Cannot modify implementing year or code after creation.');
            }
        });
    }
}
