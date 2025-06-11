<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Candidate;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //envoyer un feedback : 
    public function addFeedback(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->first();

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        $feedback = Feedback::create([
        'message' => $request->message,
        'candidate-id' => $candidate->id // Get ID from authenticated candidate
        ]);

        return response()->json(['message' => 'Feedback sent successfully', 'feedback' => $feedback], 201);
    }
    //consulter feedback : 
    public function showFeedback()
    {
        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->first();

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        $feedbacks = Feedback::where('candidate-id', $candidate->id)
            ->select('message')
            ->get();

        return response()->json($feedbacks);
    }
    //modifier feedback : 
    public function updateFeedback(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->first();

        $feedback = Feedback::where('candidate-id', $candidate->id)->first();

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback->message = $request->message;
        $feedback->save();

        return response()->json(['message' => 'Feedback updated']);
    }
    //supprimer feedback : 
    public function deleteFeedback()
    {
        $user = auth()->user();
        $candidate = Candidate::where('user_id', $user->id)->first();

        $feedback = Feedback::where('candidate-id', $candidate->id)->first();

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully']);
    }

}
