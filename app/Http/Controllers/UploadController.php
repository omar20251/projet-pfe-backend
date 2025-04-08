<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;

// class UploadController extends Controller
// {
//     public function uploadLogo(Request $request)
// {
//     $request->validate([
//         'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     if ($request->hasFile('logo')) {
//         $file = $request->file('logo');
//         $fileName = time() . '.' . $file->getClientOriginalExtension();
//         $path = $file->storeAs('logos', $fileName, 'public');
//             $usre = User::where('id',auth()->id())->first();
//             $usre->update([
//                 'logo'=>$request->file
//             ]);
//         // Save path in database
//         auth()->user()->update(['logo' => $path]);

//         return back()->with('success', 'Logo uploaded successfully!');
//     }

//     return back()->with('error', 'Failed to upload logo.');
// }
// } 

