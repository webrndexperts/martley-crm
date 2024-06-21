<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Clinician;
use App\Models\ClinicianPatient;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $data = array();

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
            }

            return view('dashboard.index', $data);
        } else {
            return view('auth.login');
        }
    }
}
