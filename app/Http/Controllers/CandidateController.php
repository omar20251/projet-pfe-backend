<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    //fonction pour afficher un candidat selon son id : 
    public function AfficherCandidate($id){
        $candidate = Candidate::with('user')->find($id); //the with('user') here is to show also the candidate related fields in the users table 
        if(!$candidate){
            return response()->json(['message'=>'candidate not found']);
        }
        return response()->json($candidate);
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
}
