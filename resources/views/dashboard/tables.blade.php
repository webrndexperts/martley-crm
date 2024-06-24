<div class="section-head direction-section">
	@if(Auth::user()->user_type == 2)
		<div class="half-grid">
		    <div class="table">
		        <h3>Clinitians List</h3>
		        <table class="dashboard datatable_clinic">
		            <tr>
		                <th scope="col">S.No</th>
		                <th scope="col">Name</th>
		                <th scope="col">Description</th>
		            </tr>

		            @foreach($forms as $k => $form)
		                <tr>
		                    <th scope="row">{{ $k + 1 }}</th>
		                    <td>{{ $form->name }}</td>
		                    <td>{{ $form->description }}</td>
		                </tr>
		            @endforeach
		        </table>
		    </div>

		    <div class="table">
		        <h3>Patients List</h3>
		        <table class="dashboard datatable_patient">
		            <tr>
		                <th scope="col">S.No</th>
		                <th scope="col">Name</th>
		                <th scope="col">Description</th>
		            </tr>

		            @foreach($forms as $k => $form)
		                <tr>
		                    <th scope="row">{{ $k + 1 }}</th>
		                    <td>{{ $form->name }}</td>
		                    <td>{{ $form->description }}</td>
		                </tr>
		            @endforeach
		        </table>
		    </div>
		</div>
	@endif

    <div class="half-grid">
        <div class="table">
            <h3>Assessments List</h3>
            <table class="dashboard datatable_assesment">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                </tr>

                @foreach($assesments as $k => $assesment)
                    <tr>
                        <th scope="row">{{ $k + 1 }}</th>
                        <td>{{ $form->name }}</td>
                        <td>{{ $form->description }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="table">
            <h3>Forms List</h3>
            <table class="dashboard datatable_form">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                </tr>

                @foreach($forms as $k => $form)
                    <tr>
                        <th scope="row">{{ $k + 1 }}</th>
                        <td>{{ $form->name }}</td>
                        <td>{{ $form->description }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>