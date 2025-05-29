<?php

use App\Models\Offre;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\dummyAPI;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureOffre;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RecruterController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidatureOffreController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\QuizController;

Route::get("test", [AuthController::class, 'getUsers']);

//-------------------recruiter routes------------------
//afficher liste des recruiters : 
Route::get('ListeRecruiter',[RecruterController::class, 'ListeRecruiter']);
//afficher liste des recruiters valide : 
Route::get('ListeRecruiterValide',[RecruterController::class, 'ListeRecruiterValide']);
//afficher liste des recruiters non valide : 
Route::get('ListeRecruiterNonValide',[RecruterController::class, 'ListeRecruiterNonValide']);
//afficher liste des recruiters en attente de validation : 
Route::get('ListeRecruiterEnattente',[RecruterController::class, 'ListeRecruiterEnattente']);

//recruiter or candidate register  : 
Route::post("register", [RegisterController::class, 'register']);
//afficher recruter  : 
Route::get('/recruiter/{id}',[RecruterController::class, 'AfficherRecruiter']);
//update recruiter : 
Route::put('/update/recruiter/{id}',[RecruterController::class, 'UpdateRecruiter']);
//delete recruiter by id (admin job): 
Route::put('/delete/recruiter/{id}',[RecruterController::class, 'DeleteRecruiter']);
//delete recruiter: 
Route::middleware('auth:sanctum')->put('/delete/recruiter',[RecruterController::class, 'DeleteProfil']);
//accepter/eliminer un candidat
Route::put('/candidat/{candidate_id}/offre/{offre_id}/status', [CandidatureOffreController::class, 'updateStatut']);






//-------------------candidate routes------------------
//afficher liste des candidats : 
Route::get('ListeCandidate',[CandidateController::class, 'ListeCandidate']);
//afficher liste des candidats valide : 
Route::get('ListeCandidateValide',[CandidateController::class, 'ListeCandidateValide']);
//afficher liste des candidats non valide : 
Route::get('ListeCandidateNonValide',[CandidateController::class, 'ListeCandidateNonValide']);
//afficher liste des candidats en attente de validation : 
Route::get('ListeCandidateEnattente',[CandidateController::class, 'ListeCandidateEnattente']);

//afficher candidate : 
Route::get('/candidate/{id}',[CandidateController::class, 'AfficherCandidate']);
//update candidate : 
Route::put('/update/candidate/{id}',[CandidateController::class, 'UpdateCandidate']);
//delete candidate : 
Route::put('/delete/candidate/{id}',[CandidateController::class, 'DeleteCandidate']);
//consulter son profil:
Route::middleware('auth:sanctum')->get('/consulter/profil/candidate',[CandidateController::class, 'consulterProfil'])->middleware('auth');
//postuler a un offre : 
Route::middleware('auth:sanctum')->post('/candidature/postuler', [CandidateController::class, 'postuler']);
//voir postulation : 
Route::get('/candidature/mes-postulations', [CandidateController::class, 'voirPostulations']);
//supprimer postulation
Route::delete('/candidature/supprimer', [CandidateController::class, 'supprimerPostulation']);

//-------------------offre routes------------------
//ajouter une offre:
Route::post('register/offre', [OffreController::class, 'register']);
//afficher offre : 
Route::get('/offre/{id}',[OffreController::class, 'AfficherOffre']);
//afficher liste des offres :
Route::get('ListeOffre', [OffreController::class, 'ListeOffre']);
//afficher liste des offres valides :
Route::get('ListeoffreValide',[OffreController::class, 'ListeOffreValide']);
//afficher liste des offres non valides :
Route::get('ListeoffreNonValide',[OffreController::class, 'ListeOffreNonValide']);
//afficher liste des offres en attente de validation :
Route::get('ListeOffreEnAttente',[OffreController::class, 'ListeOffreEnAttente']);
//update offre : 
Route::put('/update/offre/{id}',[OffreController::class, 'UpdateOffre']);
//delete offre : 
Route::put('/delete/offre/{id}',[OffreController::class, 'deleteOffre']);



//-------------------feedback routes------------------

//envoyer un feedback : 
Route::middleware('auth:sanctum')->post('/addfeedback', [FeedbackController::class, 'addFeedback']);
//voir feedback : 
Route::middleware('auth:sanctum')->get('/showfeedback', [FeedbackController::class, 'showFeedback']);
//modifier feedback : 
Route::middleware('auth:sanctum')->put('/updatefeedback', [FeedbackController::class, 'updateFeedback']);
//supprimer feedback : 
Route::middleware('auth:sanctum')->put('/deletefeedback', [FeedbackController::class, 'deleteFeedback']);



//-------------------adminroutes------------------
//update (candidate,offre) statut : 
Route::put('/candidature/updatestatus/{candidate_id}/{offre_id}', [CandidatureOffreController::class, 'updateStatut']);




Route::get("domains", [RecruterController::class, 'domaineList']);
Route::post("login", [AuthController::class, 'login'])->name('login');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("data",[dummyAPI::class,'getData']);
Route::get("list",[DeviceController::class,'list']);
Route::get("login", [AuthController::class, 'login']);

// Email verification routes
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification email sent']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

//*****************QCM AI routes***************//

/*Route::prefix('quiz')->middleware('auth:sanctum')->group(function () {
    // Générer un nouveau quiz
    Route::post('/generate', [QuizController::class, 'generateQuiz']);
    
    // Récupérer les questions d'un quiz
    Route::get('/{quizRequestId}/questions', [QuizController::class, 'getQuizQuestions']);
    
    // Soumettre les réponses
    Route::post('/{quizRequestId}/submit', [QuizController::class, 'submitAnswers']);
    
    // Historique des quiz d'un candidat
    Route::get('/candidate/{candidateId}/history', [QuizController::class, 'getCandidateQuizHistory']);

});
*/

Route::POST('/api/generate-quiz',[QuizController::class,'generateQuiz']) ;
