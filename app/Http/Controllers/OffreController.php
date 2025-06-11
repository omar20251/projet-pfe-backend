<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Offre;
use App\Models\Recruter;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    //create an offer
    public function register(Request $request){
        $request->validate([ // validate : the field recruiter_id must be present in the request body in postman
            'recruiter_id' => 'required|exists:recruters,id',//exists:recruters,id → Checks if the provided recruiter_id actually exists in the recruters table's id column.

            // Add other validation rules...
        ]);
        $offre = Offre::create([
            'title' => $request->title,
            'entreprise_name' => $request->entreprise_name,
            'place' => $request->place,
            'open_postes' => $request->open_postes,
            'experience' => $request->experience,
            'education_level' => $request->education_level,
            'language' => $request->language,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary' => $request->salary,
            'publication_date' => $request->publication_date,
            'expiration_date' => $request->expiration_date,
            'skills' => $request->skills,
            'contract_type' => $request->contract_type,
            'statut' => $request->statut ?? 'en attente de validation',
            'recruiter_id' => $request->recruiter_id
            
            
        ]);
        return response()->json($offre, 201);
    }

     //fonction pour afficher la liste des offres : 
     public function ListeOffre(){
        $offre = Offre::all();
        return response()->json($offre);
    }
    //fonction pour afficher la liste des offres valide : 
    public function ListeOffreValide(){
        
        $offre_valide= Offre::where('statut','valide')->with('recruter')->get();
        return response()->json($offre_valide);
    }
    //fonction pour afficher la liste des offres non valide : 
    public function ListeOffreNonValide(){
        
        $offre_non_valide= Offre::where('statut','non valide')->with('recruter')->get();
        return response()->json($offre_non_valide);
    }
    //fonction pour afficher la liste des offres en attente de validation : 
    public function ListeOffreEnAttente(){
        
        $offre_en_attente= Offre::where('statut','en attente de validation')->with('recruter')->get();
        return response()->json($offre_en_attente);
    }
    //fonction pour afficher un offre selon son id : 
    public function AfficherOffre($id){
        $offre = Offre::find($id); 
        if(!$offre){
            return response()->json(['message'=>'offre not found']);
        }
        return response()->json($offre);
    }

    //fonction pour update un offre selon son id : 
    public function UpdateOffre(Request $request,$id){
        $offre = Offre::find($id);
        if(!$offre){
            return response()->json(['message'=>'offre not found']);
        }
        // Update the offre fields
        $offre->update($request->only([
            'title',
            'entreprise_name',
            'place',
            'open_postes',
            'experience',
            'education_level',
            'language',
            'description',
            'requirements',
            'salary',
            'publication_date',
            'expiration_date',
            'skills',
            'contract_type',
            'statut',
            'recruiter_id'
        ]));
        return response()->json([
            'message' => 'offre updated successfully',
            'candidate' => $offre
        ]);
    }
    //delete offre : 
    public function deleteOffre($id)
    {
        $offre = Offre::find($id);

        if (!$offre) {
            return response()->json(['message' => 'Offre not found']);
        }

        $offre->delete();

        return response()->json(['message' => 'Offre deleted successfully']);
    }

    //--------candidate-offre relationships : ---------------
    
    
    
}
