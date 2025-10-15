<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'activity_title',
        'description',
        'start_date',
        'end_date',
        'status',
        'rescheduled_date',
        'remarks',
    ];

    /**
     * Relationship: Each activity belongs to one project.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
