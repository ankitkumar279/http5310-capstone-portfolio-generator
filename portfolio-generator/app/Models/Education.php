<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'educations';

    protected $fillable = [
        'portfolio_id', 'institution_name', 'degree', 'start_date', 'end_date'
    ];

    // Each education belongs to a portfolio
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
