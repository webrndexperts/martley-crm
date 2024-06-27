<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClinicianController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CRMAssessmentController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;

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
Route::post('/user/login', [LoginController::class, 'customLogin'])->name('login.custom')->middleware('guest');

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('profile')->group(function() {
        Route::get('/', [UserController::class, 'profile'])->name('profile.get');
        Route::post('/', [UserController::class, 'updateProfile'])->name('profile.save');
    });

    Route::group(['middleware' => 'admin'], function() {
        /**********************************************************************
                               Clinician routes
        *********************************************************************/
        Route::group(['prefix' => 'clinician'], function() {
            // Route::get('/list', [ClinicianController::class, 'index'])->name('list-clinician');
            // Route::post('/list/table', [ClinicianController::class, 'generateTable'])->name('clinitian.datatable');
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
            Route::get('/create', [PatientController::class, 'create'])->name('create-patient');
            Route::post('/save', [PatientController::class, 'save'])->name('save-patient');
            Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('edit-patient');
            Route::post('/update/{id}', [PatientController::class, 'update'])->name('update-patient');
            Route::get('/active/{id}', [PatientController::class, 'activate'])->name('patient.activate');
            Route::get('/deactive/{id}', [PatientController::class, 'deactivate'])->name('patient.deactivate');

            Route::prefix('assign')->group(function() {
                Route::get('/', [PatientController::class, 'assignPatient'])->name('patient.assignment.get');
                Route::post('/table', [PatientController::class, 'assignPatientTable'])->name('patient.assignment.datatable');
                // Route::get('/patient/{id}', [PatientController::class, 'getAssignmentPatient'])->name('patient.assignment.patient');
                Route::get('/add', [PatientController::class, 'addAssignPatient'])->name('patient.assignment.add');
                Route::post('/save', [PatientController::class, 'submitAssignPatient'])->name('patient.assignment.save');
                Route::get('/edit/{id}', [PatientController::class, 'editAssignPatient'])->name('patient.assignment.edit');
                Route::post('/update', [PatientController::class, 'updateAssignPatient'])->name('patient.assignment.update');
                Route::post('/delete/{id}', [PatientController::class, 'deleteAssignPatient'])->name('patient.assignment.delete');
            });
        });
        
        /**********************************************************************
         *                      Assessment routes
        *********************************************************************/
        Route::group(['prefix' => 'assessment'], function() {
            Route::get('/create', [CRMAssessmentController::class, 'create'])->name('create-assessment');
            Route::post('/save', [CRMAssessmentController::class, 'save'])->name('save.assessment');
            Route::delete('/delete/{assessment}', [CRMAssessmentController::class, 'destroy'])->name('destroy-assessment');
            Route::delete('/questions/{id}', [CRMAssessmentController::class, 'destroyQuestion'])->name('destroy-questions');
        });
    });

    /**********************************************************************
     *          Shared Assessment Routes (Admin and Clinician)
     *********************************************************************/ 
    Route::group(['middleware' => 'adminOrClinician'], function() {

        Route::group(['prefix' => 'assessment'], function() {
            Route::get('/edit/{assessment}', [CRMAssessmentController::class, 'edit'])->name('edit-assessment');
            Route::post('/update/{id}', [CRMAssessmentController::class, 'update'])->name('update-assessment');

            
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
            Route::post('/list/table', [PatientController::class, 'generateTable'])->name('patient.datatable');

            Route::prefix('assign')->group(function() {
                Route::get('/patient/{id}', [PatientController::class, 'getAssignmentPatient'])->name('patient.assignment.patient');
                Route::get('/clinic/patient/{id}', [PatientController::class, 'getClinicPatient'])->name('patient.assignment.clinic');
            });
        });

        Route::group(['prefix' => 'form/assign'], function() {
            Route::get('/', [FormController::class, 'AssignFormList'])->name('assign-form-list');
            Route::post('/table', [FormController::class, 'assignedList'])->name('form.assign.datatable');
            Route::get('/add', [FormController::class, 'AssignForm'])->name('assign-form');
            Route::post('/save', [FormController::class, 'saveAssignedForm'])->name('assigned-form');
            Route::get('/edit/{id}', [FormController::class, 'editAssignedForm'])->name('edit-assigned-form');
            Route::post('/update/{id}', [FormController::class, 'updateAssignedForm'])->name('update-assigned-form');
            Route::delete('/delete/{id}', [FormController::class, 'destroyAssignedForm'])->name('destroy-assigned-form');
        });
    });

    Route::group(['middleware' => 'patient'], function() {
        Route::get('/listing', [ClinicianController::class, 'PatientClinician'])->name('patient-clinician-list');
    });

    Route::group(['prefix' => 'clinician'], function() {
        Route::get('/list', [ClinicianController::class, 'index'])->name('list-clinician');
        Route::post('/list/table', [ClinicianController::class, 'generateTable'])->name('clinitian.datatable');
    });

    Route::group(['prefix' => 'assessment'], function() {
        Route::get('/list', [CRMAssessmentController::class, 'index'])->name('assessment-list');
        Route::get('/show/{assessment}/{user}', [CRMAssessmentController::class, 'show'])->name('show-assessment');
        Route::post('/table/values', [CRMAssessmentController::class, 'generateTable'])->name('assesments.datatable');
        Route::prefix('submit')->group(function () {
            Route::get('/{id}', [CRMAssessmentController::class, 'checkFormSubmit'])->name('assesments.answer.submit-get');
            Route::post('/', [CRMAssessmentController::class, 'submitAnswers'])->name('assesments.answer.submit');
            Route::get('/list/{id}', [CRMAssessmentController::class, 'listSubmissions'])->name('assesments.submit-list');
            Route::post('/list/table', [CRMAssessmentController::class, 'listTable'])->name('assesments.submit-table');
            Route::get('/view/{id}/{user}', [CRMAssessmentController::class, 'viewSubmission'])->name('assesments.answer.submit-view');
        });

        Route::prefix('patient')->group(function () {
            Route::get('/{id}', [CRMAssessmentController::class, 'getPatientSubmittedView'])->name('assessment.patient.submitted');
            Route::post('/table/${id}', [CRMAssessmentController::class, 'getPatientSubmittedData'])->name('assessment.patient.submit.list');
        });
    });
    

    /**********************************************************************
     *                      Form routes
    *********************************************************************/
    Route::resource('forms', FormController::class);

    Route::prefix('forms')->group(function () {
        Route::get('/fields/fetch', [FormController::class, 'fetchFields'])->name('fetch.fields');
        Route::post('/table-values', [FormController::class, 'generateTable'])->name('forms.datatable');
        
        Route::prefix('submit')->group(function () {
            Route::get('/{id}', [FormController::class, 'checkFormSubmit'])->name('forms.submit-get');
            Route::post('/', [FormController::class, 'submitAnswers'])->name('forms.submit');
            Route::get('/list/{id}', [FormController::class, 'listSubmissions'])->name('forms.submit-list');
            Route::post('/list/table', [FormController::class, 'listTable'])->name('forms.submit-table');
            Route::get('/view/{id}/{user}', [FormController::class, 'viewSubmission'])->name('forms.submit-view');
        });

        Route::prefix('patient')->group(function () {
            Route::get('/{id}', [FormController::class, 'getPatientSubmittedView'])->name('forms.patient.submitted');
            Route::post('/table/${id}', [FormController::class, 'getPatientSubmittedData'])->name('forms.patient.submit.list');
        });
    });

    /**********************************************************************
     *                      Sessions routes
    *********************************************************************/
    Route::resource('sessions', SessionController::class);

    Route::prefix('sessions')->group(function () {
        Route::post('/table', [SessionController::class, 'generateTable'])->name('sessions.datatable');
    });
});