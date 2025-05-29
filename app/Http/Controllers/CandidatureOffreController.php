<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidatureOffre;

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
}
