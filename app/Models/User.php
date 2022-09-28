<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $fillable = ['first_name', 'last_name', 'middle_name', 'job_position', 'email', 'phone_number', 'linkedin', 'facebook', 'instagram'];
    public $hidden = ['created_at', 'updated_at'];
}
