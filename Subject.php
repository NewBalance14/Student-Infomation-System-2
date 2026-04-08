<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'units',
        'department',
        'year_level',
        'semester',
    ];

    // Cast units to integer
    protected $casts = [
        'units' => 'integer',
    ];

    /**
     * The students that belong to the subject.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withPivot('grade')
            ->withTimestamps();
    }
}