<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function employeStatus()
    {
        return $this->belongsTo(EmployeStatus::class);
    }
}
