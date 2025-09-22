<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
    ];

    // Optional: if your table name is NOT `roles`, uncomment and set this:
    // protected $table = 'your_table_name';

    /**
     * Get all users for this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
