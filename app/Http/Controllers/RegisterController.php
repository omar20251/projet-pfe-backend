<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recruter;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
       // dd($request->all());
        // Validate input data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'role' => $request->role,
            'statut' => $request->statut ?? 'en attente de validation',
            
        ]);
        
        if ($request->role == 2) { // recruiter
            Recruter::create([
                'user_id' => $user->id, //The user_id field in the recruters table must be populated with the id of the user created in the previous step.
                'entreprise_name' => $request->entreprise_name,
                'website' => $request->website,
                'phone' => $request->phone,
                'address' => $request->address,
                'logo' => $request->logo ?? null,
                'entreprise_description' => $request->entreprise_description,
                'unique_identifier' => $request->unique_identifier,
                'domaine' => $request->domaine,
            ]);
        }

        if ($request->role == 3) { // candidate
            Candidate::create([
            'user_id' => $user->id,
            'civility' => $request->civility,
            'birth_date' => $request->birth_date,
            'Governorate' => $request->Governorate,
            ]);
        }

        

        // Send the email verification notification
        $user->sendEmailVerificationNotification();

        // Create token for the user
        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'user' => $user,
            'token' => $token,
            'domaine' => $request->domaine
        ], 201);
    }
}
