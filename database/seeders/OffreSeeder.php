<?php

namespace Database\Seeders;

use App\Models\Offre;
use App\Models\Recruter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OffreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createJobOffers();
    }

    public function createJobOffers()
    {
        // Get existing recruiters
        $recruiters = Recruter::all();
        
        if ($recruiters->isEmpty()) {
            // If no recruiters exist, create some using factory
            $recruiters = Recruter::factory()->count(3)->create();
        }

        // Create specific job offers for each recruiter
        foreach ($recruiters as $recruiter) {
            // Each recruiter posts 2-4 job offers
            $jobCount = rand(2, 4);
            
            for ($i = 0; $i < $jobCount; $i++) {
                Offre::create([
                    'title' => $this->getJobTitle($i),
                    'entreprise_name' => $recruiter->entreprise_name,
                    'place' => $this->getRandomPlace(),
                    'open_postes' => rand(1, 3),
                    'experience' => $this->getRandomExperience(),
                    'education_level' => $this->getRandomEducation(),
                    'language' => $this->getRandomLanguage(),
                    'description' => $this->getJobDescription($this->getJobTitle($i)),
                    'requirements' => $this->getJobRequirements($this->getJobTitle($i)),
                    'salary' => rand(1000, 4000),
                    'publication_date' => now()->subDays(rand(1, 30)),
                    'expiration_date' => now()->addDays(rand(30, 90)),
                    'skills' => $this->getJobSkills($this->getJobTitle($i)),
                    'contract_type' => $this->getRandomContractType(),
                    'statut' => $this->getRandomStatus(),
                    'recruiter_id' => $recruiter->id,
                ]);
            }
        }

        // Create additional random job offers using factory
        Offre::factory()->count(15)->create();
    }

    private function getJobTitle($index)
    {
        $titles = [
            'Développeur Full Stack',
            'Designer UI/UX',
            'Chef de Projet IT',
            'Développeur Mobile',
            'Data Analyst',
            'Consultant IT',
            'Administrateur Système',
            'Développeur Frontend',
            'Développeur Backend',
            'Product Manager'
        ];
        
        return $titles[$index % count($titles)];
    }

    private function getRandomPlace()
    {
        $places = ['Tunis', 'Sfax', 'Sousse', 'Monastir', 'Ariana', 'Bizerte', 'Nabeul'];
        return $places[array_rand($places)];
    }

    private function getRandomExperience()
    {
        $experiences = ['Débutant', '1-2 ans', '3-5 ans', '5+ ans'];
        return $experiences[array_rand($experiences)];
    }

    private function getRandomEducation()
    {
        $educations = ['Bac+2', 'Bac+3', 'Bac+5', 'Master', 'Ingénieur'];
        return $educations[array_rand($educations)];
    }

    private function getRandomLanguage()
    {
        $languages = ['Français', 'Anglais', 'Français/Anglais', 'Trilingue'];
        return $languages[array_rand($languages)];
    }

    private function getRandomContractType()
    {
        $types = ['CDI', 'CDD', 'Stage', 'Freelance'];
        return $types[array_rand($types)];
    }

    private function getRandomStatus()
    {
        $statuses = ['valide', 'en attente de validation', 'non valide'];
        $weights = [70, 20, 10]; // 70% valid, 20% pending, 10% invalid
        
        $random = rand(1, 100);
        if ($random <= 70) return 'valide';
        if ($random <= 90) return 'en attente de validation';
        return 'non valide';
    }

    private function getJobDescription($title)
    {
        $descriptions = [
            'Développeur Full Stack' => 'Nous recherchons un développeur full stack expérimenté pour rejoindre notre équipe dynamique. Vous serez responsable du développement d\'applications web complètes, de la conception à la mise en production.',
            'Designer UI/UX' => 'Rejoignez notre équipe créative en tant que designer UI/UX. Vous concevrez des interfaces utilisateur intuitives et des expériences utilisateur exceptionnelles pour nos applications web et mobiles.',
            'Chef de Projet IT' => 'Nous cherchons un chef de projet IT pour gérer nos projets de développement logiciel. Vous coordonnerez les équipes, gérerez les délais et assurerez la qualité des livrables.',
            'default' => 'Excellente opportunité de carrière dans une entreprise innovante. Rejoignez une équipe passionnée et contribuez à des projets stimulants dans un environnement de travail collaboratif.'
        ];
        
        return $descriptions[$title] ?? $descriptions['default'];
    }

    private function getJobRequirements($title)
    {
        $requirements = [
            'Développeur Full Stack' => 'Maîtrise de JavaScript, React, Node.js, bases de données relationnelles. Expérience avec Git, méthodologies Agile. Capacité à travailler en équipe.',
            'Designer UI/UX' => 'Maîtrise de Figma, Adobe XD, Sketch. Connaissance des principes de design, prototypage, tests utilisateur. Portfolio requis.',
            'Chef de Projet IT' => 'Expérience en gestion de projet, certification PMP/Scrum Master appréciée. Excellentes compétences en communication et leadership.',
            'default' => 'Formation supérieure dans le domaine concerné. Excellentes compétences en communication. Capacité à travailler en équipe et sous pression.'
        ];
        
        return $requirements[$title] ?? $requirements['default'];
    }

    private function getJobSkills($title)
    {
        $skills = [
            'Développeur Full Stack' => 'JavaScript, React, Node.js, MongoDB, Git',
            'Designer UI/UX' => 'Figma, Adobe XD, Prototyping, User Research, Wireframing',
            'Chef de Projet IT' => 'Gestion de projet, Scrum, Agile, Leadership, Communication',
            'Développeur Mobile' => 'Flutter, React Native, iOS, Android, Firebase',
            'default' => 'Communication, Travail en équipe, Résolution de problèmes'
        ];
        
        return $skills[$title] ?? $skills['default'];
    }
}
