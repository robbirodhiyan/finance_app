<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitLog extends Model
{
    use HasFactory;
    protected $table = 'debitlog';
    protected $guarded = ['id'];

    public function debit()
    {
        return $this->belongsTo(Debit::class);
    }
}
