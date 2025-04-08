<?php

namespace App\Http\Controllers;

use App\Models\Domaine;
use App\Models\Recruter;
use Illuminate\Http\Request;
use App\Http\Resources\Recruter\DomaineListRessource;

class RecruterController extends Controller
{
    public function domaineList(){
        $domaines=Domaine::all();
        return DomaineListRessource::collection($domaines); //returns list of domaines
    }

    //fonction pour afficher un recruteur selon son id : 
    public function AfficherRecruiter($id){
        $recruiter = Recruter::with('user')->find($id);
        if(!$recruiter){
            return response()->json(['message'=>'recruiteur not found']);
        }
        return response()->json($recruiter);
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
            'domaine_id',
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
    
}
