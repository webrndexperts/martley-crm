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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

        // Admin Routes For Clinician
        Route::group(['middleware' => 'admin'], function() {

        Route::get('/list/clinician', [ClinicianController::class, 'index'])->name('list-clinician');
        Route::get('/create/clinician', [ClinicianController::class, 'create'])->name('create-clinician');
        Route::post('/save/clinician', [ClinicianController::class, 'save'])->name('save-clinician');
        Route::get('/edit/clinician/{id}', [ClinicianController::class, 'edit'])->name('edit-clinician');
        Route::post('/update/clinician/{id}', [ClinicianController::class, 'update'])->name('update-clinician');
        Route::get('/active-clinician/{id}', [ClinicianController::class, 'activeClinician'])->name('active-clinician');
        Route::get('/deactive-clinician/{id}', [ClinicianController::class, 'deactiveClinician'])->name('deactive-clinician');

        // Admin Routes For Patient
        Route::get('/list/patient', [PatientController::class, 'index'])->name('list-patient');
        Route::get('/create/patient', [PatientController::class, 'create'])->name('create-patient');
        Route::post('/save/patient', [PatientController::class, 'save'])->name('save-patient');
        Route::get('/edit/patient/{id}', [PatientController::class, 'edit'])->name('edit-patient');
        Route::post('/update/patient/{id}', [PatientController::class, 'update'])->name('update-patient');

        // Admin Routes For Assessment
        Route::get('/list/assessment', [CRMAssessmentController::class, 'index'])->name('assessment-list');
        Route::get('/create/assessment', [CRMAssessmentController::class, 'create'])->name('create-assessment');
        Route::post('/save/assessment', [CRMAssessmentController::class, 'save'])->name('save.assessment');
        Route::get('assessments/{assessment}/edit', [CRMAssessmentController::class, 'edit'])->name('edit-assessment');
        Route::post('assessments/{id}', [CRMAssessmentController::class, 'update'])->name('update-assessment');
        Route::get('assessments/{assessment}', [CRMAssessmentController::class, 'show'])->name('show-assessment');
        Route::delete('assessments/{assessment}/delete', [CRMAssessmentController::class, 'destroy'])->name('destroy-assessment');
        Route::delete('assessments/questions/{id}', [CRMAssessmentController::class, 'destroyQuestion'])->name('destroy-questions');
    });

});

Route::resource('forms', FormController::class);
