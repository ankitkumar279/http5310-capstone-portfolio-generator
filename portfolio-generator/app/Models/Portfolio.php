<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    // Allow mass assignment for fields
    protected $fillable = [
        'user_id', 'title', 'template_choice',
        'profile_photo', 'full_name', 'short_bio',
        'location', 'github_link', 'linkedin_link', 'twitter_link',
        'status'
    ];

    // Relationship: a portfolio can have many education entries
    public function educations()
    {
        return $this->hasMany(Education::class);
    }

   public function workExperiences()
{
    return $this->hasMany(WorkExperience::class, 'portfolio_id', 'id');
}


    // (Optional) relationship for experience, skills, projects will be similar
}
