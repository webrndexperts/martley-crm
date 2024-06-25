@if(Auth::user()->user_type == 2)
    <section class="section-head">
        <h3 class="section-head">Quick Actions</h3>

        <div class="analytics">
            <a href="{{ route('create-patient') }}" class="analytic">
                <div class="icon"><span class="las la-clock">
                   <i class="fa fa-plus" style="font-size:12px"></i>
                   </span>
                </div>
                <div class="analytic-info">
                   <h4>Create Patinet</h4>
                </div>
            </a>

            <a href="{{ route('create-clinician') }}" class="analytic">
                <div class="icon"><span class="las la-clock">
                   <i class="fa fa-plus" style="font-size:12px"></i>
                   </span>
                </div>
                <div class="analytic-info">
                   <h4>Create Clinician</h4>
                </div>
            </a>

            <a href="{{ route('create-assessment') }}" class="analytic">
                <div class="icon"><span class="las la-clock">
                   <i class="fa fa-plus" style="font-size:12px"></i>
                   </span>
                </div>
                <div class="analytic-info">
                   <h4>Create Assesment</h4>
                </div>
            </a>

            <a href="{{ route('forms.create') }}" class="analytic">
                <div class="icon"><span class="las la-clock">
                   <i class="fa fa-plus" style="font-size:12px"></i>
                   </span>
                </div>
                <div class="analytic-info">
                   <h4>Create Form</h4>
                </div>
            </a>
        </div>
    </section>
@endif