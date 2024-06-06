<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClinicianController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CRMAssessmentController;
use App\Http\Controllers\FormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {return redirect()->route('login');});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', function () {
//     if (Auth::check()) {
//         switch (Auth::user()->user_type) {
//             case 2:
//                 return redirect()->route('home');
//             case 3:
//                 return redirect()->route('clinician-dashboard');
//             case 4:
//                 return redirect()->route('home');
//             default:
//                 return redirect()->route('login');
//         }
//     } else {
//         return redirect()->route('login');
//     }
// });


Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    // Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => 'admin'], function() {

         /**********************************************************************
                               Clinician routes
         *********************************************************************/

        Route::group(['prefix' => 'clinician'], function() {
            Route::get('/list', [ClinicianController::class, 'index'])->name('list-clinician');
            Route::get('/create', [ClinicianController::class, 'create'])->name('create-clinician');
            Route::post('/save', [ClinicianController::class, 'save'])->name('save-clinician');
            Route::get('/edit/{id}', [ClinicianController::class, 'edit'])->name('edit-clinician');
            Route::post('/update/{id}', [ClinicianController::class, 'update'])->name('update-clinician');
            Route::get('/active/{id}', [ClinicianController::class, 'activeClinician'])->name('active-clinician');
            Route::get('/deactive/{id}', [ClinicianController::class, 'deactiveClinician'])->name('deactive-clinician');
        });
    
        /**********************************************************************
                               Patient routes
         *********************************************************************/

        Route::group(['prefix' => 'patient'], function() {
            Route::get('/list', [PatientController::class, 'index'])->name('list-patient');
            Route::get('/create', [PatientController::class, 'create'])->name('create-patient');
            Route::post('/save', [PatientController::class, 'save'])->name('save-patient');
            Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('edit-patient');
            Route::post('/update/{id}', [PatientController::class, 'update'])->name('update-patient');
        });
    
        
        /**********************************************************************
         *                      Assessment routes
         *********************************************************************/

        Route::group(['prefix' => 'assessment'], function() {
            // Route::get('/list', [CRMAssessmentController::class, 'index'])->name('assessment-list');
            Route::get('/create', [CRMAssessmentController::class, 'create'])->name('create-assessment');
            Route::post('/save', [CRMAssessmentController::class, 'save'])->name('save.assessment');
            Route::get('/edit/{assessment}', [CRMAssessmentController::class, 'edit'])->name('edit-assessment');
            Route::post('/update/{id}', [CRMAssessmentController::class, 'update'])->name('update-assessment');
            // Route::get('/show/{assessment}', [CRMAssessmentController::class, 'show'])->name('show-assessment');
            Route::delete('/delete/{assessment}', [CRMAssessmentController::class, 'destroy'])->name('destroy-assessment');
            Route::delete('/questions/{id}', [CRMAssessmentController::class, 'destroyQuestion'])->name('destroy-questions');
        });
    });

        /**********************************************************************
         *          Shared Assessment Routes (Admin and Clinician)
         *********************************************************************/
        
    Route::group(['middleware' => 'adminOrClinician'], function() {

        Route::group(['prefix' => 'assessment'], function() {
            Route::get('/list', [CRMAssessmentController::class, 'index'])->name('assessment-list');
            Route::get('/show/{assessment}', [CRMAssessmentController::class, 'show'])->name('show-assessment');
        });

    });

    Route::group(['middleware' => 'clinician'], function() {
        
    });
    

    /**********************************************************************
     *                      Form routes
     *********************************************************************/

    Route::resource('forms', FormController::class);

    Route::get('/fields/fetch', [FormController::class, 'fetchFields'])->name('fetch.fields');

    Route::prefix('forms')->group(function () {
        Route::post('/table-values', [FormController::class, 'generateTable'])->name('forms.datatable');
        Route::post('/submit', [FormController::class, 'submitAnswers'])->name('forms.submit');
    });
});