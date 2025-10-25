<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'user_id',
        'title',
        'description',
        'location',
        'status',
        'budget',
        'start_date',
        'end_date',
        'project_leader',
        'contact_email',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    // 🔗 Relationships
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(ProjectStaff::class);
    }
    // app/Models/Project.php
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function perspectives(): HasMany
    {
        return $this->hasMany(Perspective::class);
    }
    public function accomplishments()
    {
        return $this->hasMany(Accomplishment::class);
    }

}
