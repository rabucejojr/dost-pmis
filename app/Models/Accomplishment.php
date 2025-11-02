<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_title',
        'implementing_year',
        'budget_utilized',
        'status',
    ];

    protected $casts = [
        'budget_utilized' => 'decimal:2',
        'implementing_year' => 'integer',
    ];

    // 🔗 Relationship: Each accomplishment belongs to one project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Accessors & scopes (same as before)
    public function getFormattedBudgetAttribute(): string
    {
        return '₱'.number_format($this->budget_utilized, 2);
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function scopeYear($query, $year)
    {
        return $year ? $query->where('implementing_year', $year) : $query;
    }

    public function scopeStatus($query, $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }
}
