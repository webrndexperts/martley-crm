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
Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::group(['middleware' => ['auth']], function () {

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
            // Route::get('/list', [PatientController::class, 'index'])->name('list-patient');
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
            // Route::get('/list', [CRMAssessmentController::class, 'index'])->name('assessment-list');
            Route::get('/show/{assessment}', [CRMAssessmentController::class, 'show'])->name('show-assessment');

            // Assign assessment

            Route::get('/assigned-list', [CRMAssessmentController::class, 'AssignAssessmentList'])->name('assign-assessment-list');
            Route::get('/assign-assessment', [CRMAssessmentController::class, 'AssignAssessment'])->name('assign-assessment');
            Route::post('/save-assigned-assessment', [CRMAssessmentController::class, 'saveAssignedAssessment'])->name('assigned-assessment');
            Route::get('/edit-assigned-assessment/{id}', [CRMAssessmentController::class, 'editAssignedAssessment'])->name('edit-assigned-assessment');
            Route::post('/update-assigned-assessment/{id}', [CRMAssessmentController::class, 'updateAssignedAssessment'])->name('update-assigned-assessment');
            Route::delete('/delete-assigned-assessment/{id}', [CRMAssessmentController::class, 'destroyAssignedAssessment'])->name('destroy-assigned-assessment');

        });

        Route::group(['prefix' => 'patient'], function() {
            Route::get('/list', [PatientController::class, 'index'])->name('list-patient');
        });

        Route::group(['prefix' => 'form'], function() {
            Route::get('/assigned-list', [FormController::class, 'AssignFormList'])->name('assign-form-list');
            Route::get('/assign-form', [FormController::class, 'AssignForm'])->name('assign-form');
            Route::post('/save-assigned-form', [FormController::class, 'saveAssignedForm'])->name('assigned-form');
            Route::get('/edit-assigned-form/{id}', [FormController::class, 'editAssignedForm'])->name('edit-assigned-form');
            Route::post('/update-assigned-form/{id}', [FormController::class, 'updateAssignedForm'])->name('update-assigned-form');
            Route::delete('/delete-assigned-form/{id}', [FormController::class, 'destroyAssignedForm'])->name('destroy-assigned-form');

        });

    });

    Route::group(['middleware' => 'patient'], function() {

        Route::get('/list', [ClinicianController::class, 'PatientClinician'])->name('patient-clinician-list');

    });

    Route::group(['prefix' => 'assessment'], function() {
        Route::get('/list', [CRMAssessmentController::class, 'index'])->name('assessment-list');
        Route::post('/table/values', [CRMAssessmentController::class, 'generateTable'])->name('assesments.datatable');
        Route::prefix('submit')->group(function () {
            Route::post('/list/{id}', [CRMAssessmentController::class, 'listSubmission'])->name('assesments.submit-list');
        });
    });
    

    /**********************************************************************
     *                      Form routes
     *********************************************************************/

    Route::resource('forms', FormController::class);

    Route::get('/fields/fetch', [FormController::class, 'fetchFields'])->name('fetch.fields');

    Route::prefix('forms')->group(function () {
        Route::post('/table-values', [FormController::class, 'generateTable'])->name('forms.datatable');
        
        Route::prefix('submit')->group(function () {
            Route::get('/{id}', [FormController::class, 'checkFormSubmit'])->name('forms.submit-get');
            Route::post('/', [FormController::class, 'submitAnswers'])->name('forms.submit');
            Route::get('/list/{id}', [FormController::class, 'listSubmissions'])->name('forms.submit-list');
            Route::post('/list/table', [FormController::class, 'listTable'])->name('forms.submit-table');
            Route::get('/view/{id}/{user}', [FormController::class, 'viewSubmission'])->name('forms.submit-view');
        });
    });
});