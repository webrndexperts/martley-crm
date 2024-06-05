<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View, Auth;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\FormField;

class FormController extends Controller
{
    protected function __constructor() {}

    /**
     * Function to generate form Values.
     * @param $listing Laravel Array of objects from query.
     * 
     * @return Array values.
     */
    protected function generateTableValues($listing) {
        $data = array();

        foreach ($listing as $key => $row) {
            $data[$key]['id'] = $row->id;
            $data[$key]['name'] = ($row->name)?ucwords($row->name):"";
            $data[$key]['report'] = ($row->report)?$row->report:"";
            $data[$key]['created_at'] = $row->created_at;
            $data[$key]['profile'] = $row->profile;
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('forms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array();
        return view('forms.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = 'error'; $message = 'Unable to add new form';

        try {
            $newArray = array_values($request->form);
            $form = new Form;

            // $form->user_id = Auth::user()->id;
            $form->user_id = 1;
            $form->name = $request->name;
            $form->submit = $request->button;

            if($form->save()) {
                foreach ($newArray as $key => $value) {
                    $fields = new FormField;

                    $fields->form_id = $form->id;
                    $fields->type = $value['type'];
                    $fields->label = $value['label'];
                    $fields->options = json_encode($value['options']);

                    $fields->save();
                }

                $type = 'success'; $message = 'New record has been created.';
            }
        } catch(\Exception $err) {
            $message = $err->getMessage();
        }

        return redirect('forms')->with($type, $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['form'] = Form::where('id', 1)->with('fields')->first();

        return view('forms.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = 'error'; $message = 'Something went wrong while updating form values.';

        try {
            $newArray = array_values($request->form);
            $form = Form::find(base64_decode($id));

            $form->name = $request->name;
            $form->submit = $request->button;

            if($form->save()) {
                foreach ($newArray as $key => $value) {

                    // dd($value);

                    if($value && isset($value['id'])) {
                        FormField::updateOrCreate([
                            'id' => $value['id'],
                            'form_id' => base64_decode($id)
                        ], [
                            'type' => $value['type'],
                            'label' => $value['label'],
                            'options' => json_encode($value['options']),
                        ]);
                    } else {
                        $fields = new FormField;

                        $fields->form_id = base64_decode($id);
                        $fields->type = $value['type'];
                        $fields->label = $value['label'];
                        $fields->options = json_encode($value['options']);

                        $fields->save();
                    }
                }

                $type = 'success'; $message = 'Form Updated Successfully.';
            }

            if($request->removed) {
                FormField::whereIn('id', explode(',', $request->removed))->delete();
            }
        } catch(\Exception $err) {
            $message = $err->getMessage();
        }

        return redirect()->back()->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Form::where('id', $id)->delete();
        $ids = FormField::where('form_id', $id)->pluck('id')->toArray();
        
        FormField::whereIn('id', $ids)->delete();
        FormAnswer::where('form_id', $id)->whereIn('form_field_id', $ids)->delete();

        return redirect()->back()->with('success', 'Form Deleted Successfully.');
    }

    public function generateTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user_id',
            3 => 'created_at'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $forms = Form::Query();

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $forms = $forms->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        }

        $counts = $forms->count();
        $forms = $forms->orderBy($order, $dir);
        if($limit >= 0) {
            $forms = $forms->offset($start)->limit($limit)->get();
        }

        $forms = $forms->with([ 'user', 'forms' ])->get();

        $values = $this->generateTableValues($forms);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),  
            "recordsTotal" => intval($counts),  
            "recordsFiltered" => intval($counts), 
            "data" => $values   
        );

        return json_encode($json_data);  
    }

    // API function to get empty fields data.
    public function fetchFields() {
        $html = View::make('forms.includes.fields')->render();
        return response()->json(['html' => $html]);
    }
}
