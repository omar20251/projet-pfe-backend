<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidatureOffre;
use App\Models\Candidate;
use App\Models\Offre;
use App\Models\Recruter;
use Illuminate\Support\Facades\DB;

class CandidatureOffreController extends Controller
{
    public function updateStatut(Request $request, $candidate_id, $offre_id)
    {
        $request->validate([
            'status' => 'required|in:accepté,refusé',
        ]);

        $entry = CandidatureOffre::where('candidate_id', $candidate_id)
                                  ->where('offre_id', $offre_id)
                                  ->first();

        if (!$entry) {
            return response()->json(['message' => 'Candidature non trouvée.'], 404);
        }

        $entry->status = $request->status;
        $entry->save();

        return response()->json(['message' => "Statut mis à jour avec succès à : {$request->status}"]);
    }

    public function getAllApplications()
    {
        $applications = DB::table('candidate_offre')
            ->join('candidates', 'candidate_offre.candidate_id', '=', 'candidates.id')
            ->join('users as candidate_users', 'candidates.user_id', '=', 'candidate_users.id')
            ->join('offres', 'candidate_offre.offre_id', '=', 'offres.id')
            ->join('recruters', 'offres.recruiter_id', '=', 'recruters.id')
            ->join('users as recruiter_users', 'recruters.user_id', '=', 'recruiter_users.id')
            ->select(
                'candidate_offre.*',
                'candidate_users.first_name as candidate_first_name',
                'candidate_users.last_name as candidate_last_name',
                'candidate_users.email as candidate_email',
                'candidates.civility',
                'candidates.birth_date',
                'candidates.Governorate',
                'offres.title as job_title',
                'offres.entreprise_name',
                'offres.place as job_location',
                'offres.salary',
                'recruiter_users.first_name as recruiter_first_name',
                'recruiter_users.last_name as recruiter_last_name',
                'recruiter_users.email as recruiter_email'
            )
            ->orderBy('candidate_offre.created_at', 'desc')
            ->get();

        return response()->json($applications);
    }

    public function getRecruiterApplications(Request $request)
    {
        $user = auth()->user();

        // Get the recruiter record for the authenticated user
        $recruiter = Recruter::where('user_id', $user->id)->first();

        if (!$recruiter) {
            return response()->json(['message' => 'Recruiter not found'], 404);
        }

        $applications = DB::table('candidate_offre')
            ->join('candidates', 'candidate_offre.candidate_id', '=', 'candidates.id')
            ->join('users as candidate_users', 'candidates.user_id', '=', 'candidate_users.id')
            ->join('offres', 'candidate_offre.offre_id', '=', 'offres.id')
            ->where('offres.recruiter_id', $recruiter->id)
            ->select(
                'candidate_offre.*',
                'candidate_users.first_name as candidate_first_name',
                'candidate_users.last_name as candidate_last_name',
                'candidate_users.email as candidate_email',
                'candidates.civility',
                'candidates.birth_date',
                'candidates.Governorate',
                'offres.title as job_title',
                'offres.entreprise_name',
                'offres.place as job_location',
                'offres.salary'
            )
            ->orderBy('candidate_offre.created_at', 'desc')
            ->get();

        return response()->json($applications);
    }
}
