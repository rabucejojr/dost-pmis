<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'position',
        'contact_no',
        'email',
    ];

    /**
     * Relationship: Each staff belongs to one project.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
