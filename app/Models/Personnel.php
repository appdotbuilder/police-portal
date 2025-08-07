<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Personnel
 *
 * @property int $id
 * @property string $badge_number
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property string $rank
 * @property string $department
 * @property string $status
 * @property \Illuminate\Support\Carbon $hire_date
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $gender
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_phone
 * @property array|null $documents
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereBadgeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereEmergencyContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereHireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel active()
 * @method static \Database\Factories\PersonnelFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Personnel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'badge_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'rank',
        'department',
        'status',
        'hire_date',
        'address',
        'birth_date',
        'gender',
        'emergency_contact_name',
        'emergency_contact_phone',
        'documents',
        'notes',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personnel';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hire_date' => 'date',
        'birth_date' => 'date',
        'documents' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the officer's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope a query to only include active personnel.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by department.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $department
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}