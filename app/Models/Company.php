<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'email'
    ];
    // protected $guarded = [];

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'id', 'company_id');
    }
}
