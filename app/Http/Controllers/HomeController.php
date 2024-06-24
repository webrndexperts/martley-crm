<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Clinician;
use App\Models\ClinicianPatient;
use App\Models\CRMAssessment;
use App\Models\Form;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getValues() {
        $data = array();

        return $data;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $data = $this->getValues();

            $assesments = CRMAssessment::with('submited');
            $forms = Form::with('submited');

            if(Auth::user()->user_type == '2' || Auth::user()->user_type == '3') {
                $patient = Patient::Query();

                if(Auth::user()->user_type == '3') {
                    $clinic = Clinician::where('user_id', Auth::user()->id)->first();
                    $assigned = ClinicianPatient::where('clinician_id', $clinic->id)->pluck('patient_id')->toArray();
                    $patient = $patient->whereIn('id', $assigned);
                } else {
                    $data['clinitianCount'] = Clinician::count();
                }

                $data['patientCount'] = $patient->count();
            } else {
                $assesments = $assesments->assigned();
                $forms = $forms->assigned();
            }

            $data['assesmentCount'] = $assesments->count();
            $data['formCount'] = $forms->count();

            $data['assesments'] = $assesments->limit(5)->latest()->get();
            $data['forms'] = $forms->limit(5)->latest()->get();

            return view('dashboard.index', $data);
        } else {
            return view('auth.login');
        }
    }
}
