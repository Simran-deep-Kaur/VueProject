<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'user_id',
        'description',
        'age',
        'profile_image'
    ];

    public static function filter($employeesQuery,$filter)
    {
        if ($filter === 'below18') {
            return $employeesQuery->below18();
        } elseif ($filter === 'above18') {
            return $employeesQuery->above18();
        } elseif ($filter !== null && $filter !== 'all') {
            return $employeesQuery->where('user_id', $filter);
        }
    
        return $employeesQuery;
    }

    public static function searchAndFilter($employeeQuery, $filter, $search)
    {
        return self::filter($employeeQuery, $filter)->search($search);
    }
   
    public function scopeBelow18($query)
    {
        return $query->where('age','<',18);
    }
    
    public function scopeAbove18($query)
    {
        return $query->where('age','>=', 18);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('gender', 'like', '%' . $search . '%')
            ->orWhere('age', 'like', '%' . $search . '%');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}