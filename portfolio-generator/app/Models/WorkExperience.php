<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id', 'company_name', 'position', 'start_date', 'end_date', 'description'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
