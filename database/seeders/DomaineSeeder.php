<?php

namespace Database\Seeders;

use App\Models\Domaine;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DomaineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $this->createDomaine();
    }
    
    public function createDomaine()
    {
        Domaine::create([
            'name' => 'Banque',
        ]);
        Domaine::create([
            'name' => 'Biotechnologie',
        ]); 
        Domaine::create([
            'name' => 'Developpement des affaires',
        ]); 
        Domaine::create([
            'name' => 'Construction',
        ]);
        
        Domaine::create([
            'name' => 'Design',
        ]);
        Domaine::create([
            'name' => 'Distribution',
        ]);
        Domaine::create([
            'name' => 'Enseignement',
        ]);
        Domaine::create([
            'name' => 'Services veterinaires',
        ]);
        Domaine::create([
            'name' => 'Fonction publique',
        ]);
        Domaine::create([
            'name' => 'Sante',
        ]);
        Domaine::create([
            'name' => 'Installation-Entretien-Reparation',
        ]);
        Domaine::create([
            'name' => 'Assurances',
        ]);
        Domaine::create([
            'name' => 'Juridique',
        ]);
        Domaine::create([
            'name' => 'Gestion',
        ]);
        Domaine::create([
            'name' => 'Media-Journalisme',
        ]);
        Domaine::create([
            'name' => 'Services a la clientele',
        ]);
        Domaine::create([
            'name' => 'Pharmaceutiques',
        ]);
        Domaine::create([
            'name' => 'Achat - Approvisionnement',
        ]);
        Domaine::create([
            'name' => 'Controle Qualite',
        ]);
        Domaine::create([
            'name' => 'Immobilier',
        ]);
        Domaine::create([
            'name' => 'Recherche',
        ]);
        
    
        
    }
}
