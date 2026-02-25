<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class TemplatePreviewController extends Controller
{
    public function show(string $key)
    {
        $allowed = ['minimal', 'business', 'designer', 'developer'];
        abort_unless(in_array($key, $allowed, true), 404);

        $skills = collect([
            (object)['name' => 'Laravel', 'level' => 90],
            (object)['name' => 'React / Next.js', 'level' => 85],
            (object)['name' => 'MySQL / PostgreSQL', 'level' => 80],
            (object)['name' => 'UI/UX', 'level' => 75],
        ]);

        $experiences = collect([
            (object)[
                'role' => 'Junior Full Stack Developer',
                'company_name' => 'Demo Company',
                'start_date' => '2025',
                'end_date' => 'Present',
                'description' => 'Built features, fixed bugs, integrated APIs, and improved UI performance.',
            ],
            (object)[
                'role' => 'Web Developer Intern',
                'company_name' => 'Demo Studio',
                'start_date' => '2024',
                'end_date' => '2025',
                'description' => 'Worked on responsive pages, components, and UX improvements.',
            ],
        ]);

        $projects = collect([
    (object)[
        'title' => 'PortfolioGen',
        'description' => 'SaaS portfolio generator with wizard steps and professional templates.',
        'tech_stack' => 'Laravel • MySQL • Bootstrap',
        'image_path' => null,
        'live_url' => 'https://ankitkumar279.github.io/ankitkumar.com/',
        'github_url' => 'https://github.com/ankitkumar279',
    ],
    (object)[
        'title' => 'SkillShift Reports UI',
        'description' => 'Modern report UI with sections, nav, and export actions.',
        'tech_stack' => 'Next.js • TypeScript • Tailwind',
        'image_path' => null,
        'live_url' => 'https://example.com',
        'github_url' => 'https://github.com/ankitkumar279',
    ],
]);

        $educations = collect([
            (object)[
                'degree' => 'PG Diploma — Computer Application Development',
                'institution_name' => 'Conestoga College',
                'start_date' => '2024',
                'end_date' => '2025',
            ],
            (object)[
                'degree' => 'Web Development',
                'institution_name' => 'Humber Polytechnic',
                'start_date' => '2025',
                'end_date' => 'Present',
            ],
        ]);

        $portfolio = (object)[
            'id' => 0,
            'user_id' => 0, 
            'full_name' => 'Ankit Kumar',
            'job_title' => 'Full Stack Developer',
            'location' => 'Toronto, ON',
            'short_bio' => 'Demo preview data. This shows exactly how your portfolio will look with this template.',
            'email' => 'ankit@example.com',


            'linkedin_url' => 'https://linkedin.com/in/ankitkumar',
            'github_url' => 'https://github.com/ankitkumar279',
            'twitter_url' => '',
            'photo_path' => null,
            'skills' => $skills,
            'projects' => $projects,
            'experiences' => $experiences,
            'educations' => $educations,
        ];
        return view("templates.$key", compact('portfolio'));
    }
}