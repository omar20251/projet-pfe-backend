<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\Recruter;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffreFactory extends Factory
{
    protected $model = Offre::class;

    public function definition(): array
    {
        $contractTypes = ['CDI', 'CDD', 'Stage', 'Freelance', 'Temps partiel'];
        $experienceLevels = ['Débutant', '1-2 ans', '3-5 ans', '5-10 ans', '10+ ans'];
        $educationLevels = ['Bac', 'Bac+2', 'Bac+3', 'Bac+5', 'Master', 'Doctorat'];
        $languages = ['Français', 'Anglais', 'Arabe', 'Français/Anglais', 'Trilingue'];
        $statuts = ['valide', 'en attente de validation', 'non valide'];
        
        $jobTitles = [
            'Développeur Full Stack',
            'Développeur Frontend',
            'Développeur Backend',
            'Designer UI/UX',
            'Chef de Projet',
            'Analyste Business',
            'Administrateur Système',
            'Ingénieur DevOps',
            'Data Scientist',
            'Consultant IT',
            'Architecte Solution',
            'Testeur QA',
            'Product Manager',
            'Scrum Master',
            'Développeur Mobile'
        ];

        $skills = [
            ['React', 'Node.js', 'JavaScript', 'TypeScript'],
            ['Vue.js', 'PHP', 'Laravel', 'MySQL'],
            ['Angular', 'Java', 'Spring Boot', 'PostgreSQL'],
            ['Python', 'Django', 'Flask', 'MongoDB'],
            ['C#', '.NET', 'SQL Server', 'Azure'],
            ['Flutter', 'Dart', 'Firebase', 'Mobile Development'],
            ['Docker', 'Kubernetes', 'AWS', 'CI/CD'],
            ['Figma', 'Adobe XD', 'Sketch', 'Prototyping']
        ];

        $places = [
            'Tunis', 'Sfax', 'Sousse', 'Monastir', 'Bizerte', 
            'Gabès', 'Ariana', 'Ben Arous', 'Nabeul', 'Kairouan'
        ];

        $selectedSkills = $this->faker->randomElements($this->faker->randomElement($skills), 3);
        
        return [
            'title' => $this->faker->randomElement($jobTitles),
            'entreprise_name' => $this->faker->company(),
            'place' => $this->faker->randomElement($places),
            'open_postes' => $this->faker->numberBetween(1, 5),
            'experience' => $this->faker->randomElement($experienceLevels),
            'education_level' => $this->faker->randomElement($educationLevels),
            'language' => $this->faker->randomElement($languages),
            'description' => $this->faker->paragraph(4),
            'requirements' => $this->faker->paragraph(3),
            'salary' => $this->faker->numberBetween(800, 5000),
            'publication_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+60 days'),
            'skills' => implode(', ', $selectedSkills),
            'contract_type' => $this->faker->randomElement($contractTypes),
            'statut' => $this->faker->randomElement($statuts),
            'recruiter_id' => Recruter::factory(),
        ];
    }
}
