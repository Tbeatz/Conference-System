<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // For API tokens, optional
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ConferenceSubmission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'position',
        'department',
        'organization',
        'field' // if using role relationship
    ];

    /**
     * Attributes hidden from array/json.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts for attributes.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * A user belongs to a role.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleName)
    {
        // return $this->roles()->where('name', $roleName)->exists();
        return $this->role && $this->role->name === $roleName;
    }
    public function conferenceSubmission()
    {
        return $this->hasMany(ConferenceSubmission::class);
    }
    public function journalSubmission()
    {
        return $this->hasMany(JournalSubmission::class);
    }
    public function reviewSchedules()
    {
        return $this->hasMany(ReviewSchedule::class, 'reviewer1_id')
            ->orWhere('reviewer2_id', $this->id)
            ->orWhere('reviewer3_id', $this->id);
    }
}