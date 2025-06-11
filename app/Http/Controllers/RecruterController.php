<?php

namespace App\Http\Controllers;

use App\Models\Domaine;
use App\Models\Recruter;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Resources\Recruter\DomaineListRessource;

class RecruterController extends Controller
{
    public function domaineList(){
        $domaines=Domaine::all();
        return DomaineListRessource::collection($domaines); //returns list of domaines
    }

    //fonction pour afficher la liste des recruiters : 
    public function ListeRecruiter(){
        $recruiter = Recruter::all();
        return response()->json($recruiter);
    }

    //fonction pour afficher la liste des recruiters valide : 
    public function ListeRecruiterValide(){
        
        $recruiter_valide= Recruter::whereHas('user', function ($query) {
            $query->where('statut', 'valide');
        })->with('user')->get();

        return response()->json($recruiter_valide);
    }

    //fonction pour afficher la liste des recruiters non valide :

    public function ListeRecruiterNonValide(){
        
        $recruiter_non_valide= Recruter::whereHas('user', function ($query) {
            $query->where('statut', 'non valide');
        })->with('user')->get();

        return response()->json($recruiter_non_valide);
    }

    //fonction pour afficher la liste des recruiters en attente de validation :

    public function ListeRecruiterEnattente(){
        
        $recruiter_en_attente= Recruter::whereHas('user', function ($query) {
            $query->where('statut','en attente de validation');
        })->with('user')->get();
        return response()->json($recruiter_en_attente);
    }

    //fonction pour afficher un recruteur selon son id : 
    public function AfficherRecruiter($id){
        $recruiter = Recruter::with('user')->find($id);
        if(!$recruiter){
            return response()->json(['message'=>'recruiteur not found']);
        }
        return response()->json(
            $recruiter->makeHidden(['id', 'user_id','role','created_at','updated_at','statut','email_verified_at','remember_token',''])
        );
    }

    //fonction pour update un recruiter selon son id : 
    public function UpdateRecruiter(Request $request,$id){
        $recruiter = Recruter::with('user')->find($id);
        if(!$recruiter){
            return response()->json(['message'=>'recruiteur not found']);
        }

    
        // Update the recruiter fields
        $recruiter->update($request->only([
            'entreprise_name',
            'website',
            'phone',
            'address',
            'logo',
            'entreprise_description',
            'unique_identifier',
            'domaine',
        ]));
        // Update the linked user fields
        if ($recruiter->user) {
            $recruiter->user->update($request->only([
                'first_name',
                'last_name',
                'email',
                'password' // hash it if changed
            ]));
        }

        return response()->json([
            'message' => 'Recruiter and user updated successfully',
            'recruiter' => $recruiter->load('user')
        ]);

        // return response()->json([
        //     'message' => 'Recruiter updated successfully',
        //     'recruiter' => $recruiter
        // ]);


    }

    //delete a recruiter selon son id : 
    public function DeleteRecruiter($id){
        $recruiter=Recruter::find($id);
        if(!$recruiter){
            return response()->json(['message'=>'recruiteur not found']);
        }
        // Delete the user associated with the recruiter
        if ($recruiter->user) {
            $recruiter->user->delete();
        }
        // Then delete the recruiter
        $recruiter->delete();
        return response()->json([
            'message' => 'Recruiter and related user deleted successfully',
        ]);
        
    }
    //consulter son profil recruiter
    public function consulterProfil()
    {
        $user = auth()->user();
        $recruiter = Recruter::where('user_id', $user->id)->with('user')->first();

        if (!$recruiter) {
            return response()->json(['message' => 'Profil recruiter non trouvé'], 404);
        }

        return response()->json([
            'id' => $recruiter->id,
            'entreprise_name' => $recruiter->entreprise_name,
            'website' => $recruiter->website,
            'phone' => $recruiter->phone,
            'address' => $recruiter->address,
            'logo' => $recruiter->logo,
            'entreprise_description' => $recruiter->entreprise_description,
            'unique_identifier' => $recruiter->unique_identifier,
            'domaine' => $recruiter->domaine,
            'user_id' => $recruiter->user_id,
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

    //update own recruiter profile
    public function updateOwnProfile(Request $request){
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $recruiter = Recruter::where('user_id', $user->id)->with('user')->first();
        if (!$recruiter) {
            return response()->json(['message' => 'Recruiter profile not found'], 404);
        }

        // Update the recruiter fields
        $recruiter->update($request->only([
            'entreprise_name',
            'website',
            'phone',
            'address',
            'logo',
            'entreprise_description',
            'unique_identifier',
            'domaine',
        ]));

        // Update the linked user fields
        if ($recruiter->user) {
            $recruiter->user->update($request->only([
                'first_name',
                'last_name',
                'email',
            ]));
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'recruiter' => $recruiter->load('user')
        ]);
    }

    //supprimer son profil
    public function DeleteProfil(){
    $user = auth()->user(); // Get the logged-in user
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    // Find the recruiter by the user_id
    $recruiter = Recruter::where('user_id', $user->id)->first();
    if (!$recruiter) {
        return response()->json(['error' => 'Recruiter profile not found'], 404);
    }
    // Delete user and recruiter
    $user->delete();
    $recruiter->delete();

    return response()->json([
        'message' => 'Recruiter and related user deleted successfully',
    ]);
}
    
}
