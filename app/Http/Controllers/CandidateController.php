<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\CandidatureOffre;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{

    //fonction pour afficher la liste des candidats :
    public function ListeCandidate(){
        $candidate = Candidate::with('user')->get();
        return response()->json($candidate);
    }

    //fonction pour afficher la liste des candidats valide : 
    public function ListeCandidateValide(){
        
        $candidate_valide= Candidate::whereHas('user', function ($query) {
            $query->where('statut', 'valide');
        })->with('user')->get();

        return response()->json($candidate_valide);
    }

    //fonction pour afficher la liste des candidats non valide :

    public function ListeCandidateNonValide(){
        
        $candidate_non_valide= Candidate::whereHas('user', function ($query) {
            $query->where('statut', 'non valide');
        })->with('user')->get();

        return response()->json($candidate_non_valide);
    }

    //fonction pour afficher la liste des candidats en attente de validation :

    public function ListeCandidateEnattente(){
        
        $candidate_en_attente= Candidate::whereHas('user', function ($query) {
            $query->where('statut','en attente de validation');
        })->with('user')->get();
        return response()->json($candidate_en_attente);
    }

    //fonction pour afficher un candidat selon son id : (partie admin)
    public function AfficherCandidate($id){
        $candidate = Candidate::with('user')->find($id); //the with('user') here is to show also the candidate related fields in the users table 
        if(!$candidate){
            return response()->json(['message'=>'candidate not found']);
        }
        return response()->json($candidate);
    }
    //fonction pour consulter son profil :
        public function consulterProfil()
    {
        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->with('user')->first();

        if (!$candidate) {
            return response()->json(['message' => 'Profil candidat non trouvé'], 404);
        }

        return response()->json([
            'id' => $candidate->id,
            'civility' => $candidate->civility,
            'birth_date' => $candidate->birth_date,
            'Governorate' => $candidate->Governorate,
            'user_id' => $candidate->user_id,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'statut' => $user->statut,
            ]
        ]);
    }

    //fonction pour update un candidat selon son id : 
    public function UpdateCandidate(Request $request,$id){
        $candidate = Candidate::with('user')->find($id);
        if(!$candidate){
            return response()->json(['message'=>'candidate not found']);
        }
        // Update the candidate fields
        $candidate->update($request->only([
            'civility',
            'birth_date',
            'Governorate',
        ]));
        // Update the linked user fields
        if ($candidate->user) {
            $candidate->user->update($request->only([
                'first_name',
                'last_name',
                'email',
                'password' // hash it if changed
            ]));

        }

        return response()->json([
            'message' => 'candidate and user updated successfully',
            'candidate' => $candidate->load('user')
        ]);

        // return response()->json([
        //     'message' => 'Recruiter updated successfully',
        //     'recruiter' => $recruiter
        // ]);


    }

    //delete a candidate selon son id : 
    public function DeleteCandidate($id){
        $candidate=Candidate::with('user')->find($id);
        if(!$candidate){
            return response()->json(['message'=>'candidate not found']);
        }
        // Delete the user associated with the candidate
        if ($candidate->user) {
            $candidate->user->delete();
        }
        // Then delete the candidate
        $candidate->delete();
        return response()->json([
            'message' => 'canidate and related user deleted successfully',
        ]);
        
    }
    //postuler a un offre : 
    public function postuler(Request $request)
    {
        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->first();
        

        if (!$candidate) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }

        // Vérifie si déjà postulé
        $existe = CandidatureOffre::where('candidate_id', $candidate->id)
                    ->where('offre_id', $request->offre_id)
                    ->first();

        if ($existe) {
            return response()->json(['message' => 'Déjà postulé à cette offre'], 400);
        }

        try {
            CandidatureOffre::create([
                'candidate_id' => $candidate->id,
                'offre_id' => $request->offre_id,
                'status' => 'en attente'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur serveur',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json(['message' => 'Postulation enregistrée']);
    }

    //voir postulation :
    public function voirPostulations()
    {
        try {
            $user = auth()->user();
            $candidate = Candidate::where('user_id', $user->id)->first();

            if (!$candidate) {
                return response()->json(['message' => 'Candidat non trouvé'], 404);
            }

            $postulations = DB::table('candidate_offre')
                            ->join('offres', 'offres.id', '=', 'candidate_offre.offre_id')
                            ->where('candidate_offre.candidate_id', $candidate->id)
                            ->select('offres.*', 'candidate_offre.status', 'candidate_offre.created_at', 'candidate_offre.updated_at')
                            ->get();

            return response()->json($postulations);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur serveur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //supprimer postulation : 
    public function supprimerPostulation(Request $request)
    {
        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->first();

        DB::table('candidate_offre')
            ->where('candidate_id', $candidate->id)
            ->where('offre_id', $request->offre_id)
            ->delete();

        return response()->json(['message' => 'Postulation supprimée avec succès']);
    }


}
