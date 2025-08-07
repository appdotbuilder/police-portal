<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Cases
 *
 * @property int $id
 * @property string $case_number
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $priority
 * @property string $category
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $incident_date
 * @property int|null $assigned_officer_id
 * @property int $created_by
 * @property array|null $evidence_files
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $assignedOfficer
 * @property-read \App\Models\User $creator
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Cases newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cases newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cases query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereAssignedOfficerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereCaseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereEvidenceFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereIncidentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cases whereUpdatedAt($value)
 * @method static \Database\Factories\CasesFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Cases extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'case_number',
        'title',
        'description',
        'status',
        'priority',
        'category',
        'location',
        'incident_date',
        'assigned_officer_id',
        'created_by',
        'evidence_files',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'incident_date' => 'datetime',
        'evidence_files' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the officer assigned to this case.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_officer_id');
    }

    /**
     * Get the user who created this case.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include open cases.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope a query to only include high priority cases.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'critical']);
    }
}