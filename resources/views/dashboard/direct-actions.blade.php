<!-- <div class="actions-direct">
   @if(Auth::user()->user_type == 2)
   	<div class="row">
   		<h2>Quick Actions</h2>
   
              <div class="col-md-3">
                  <div class="create_card ">
                  <a href="{{ route('create-patient') }}" class="card">
                      <p>
                          <i class="fa fa-user-plus" aria-hidden="true"></i>
                          <span>Create Patient</span>
                      </p>
                  </a>
   </div>
              </div>
   
              <div class="col-md-3">
              <div class="create_card ">
                  <a href="{{ route('create-clinician') }}" class="card">
                      <p>
                          <i class="fa fa-user-plus" aria-hidden="true"></i>
                          <span>Create Clinician</span>
                      </p>
                  </a>
              </div>
   </div>
   
              <div class="col-md-3">
              <div class="create_card ">
                  <a href="{{ route('create-assessment') }}" class="card">
                      <p>
                          <i class="fa fa-user-plus" aria-hidden="true"></i>
                          <span>Create Assesment</span>
                      </p>
                  </a>
              </div>
   </div>
   
              <div class="col-md-3">
              <div class="create_card ">
                  <a href="{{ route('forms.create') }}" class="card">
                      <p>
                          <i class="fa fa-user-plus" aria-hidden="true"></i>
                          <span>Create Form</span>
                      </p>
                  </a>
              </div>
   </div>
   	</div>
   @endif
   </div> -->
   <main>
   <section class="section-head">
      <h3 class="section-head">Dashboard</h3>
      <div class="analytics">
         <div class="analytic">
            <div class="analytic-icon"><span class="las la-eye">
               <i class="fa fa-eye" style="font-size:20px"></i>
               </span>
            </div>
            <div class="analytic-info">
               <h4>Total views</h4>
               <h1>10.3M</h1>
            </div>
         </div>
         <div class="analytic">
            <div class="analytic-icon"><span class="las la-clock">
               <i class="fa fa-clock-o" style="font-size:20px"></i>
               </span>
            </div>
            <div class="analytic-info">
               <h4>Watch time (hrs)</h4>
               <h1>20.9k <small class="text-danger">5%</small></h1>
            </div>
         </div>
         <div class="analytic">
            <div class="analytic-icon"><span class="las la-users">
               <i class="fa fa-user" style="font-size:20px"></i>
               </span>
            </div>
            <div class="analytic-info">
               <h4>Subscribers</h4>
               <h1>1.3k <small class="text-success">12%</small></h1>
            </div>
         </div>
         <div class="analytic">
            <div class="analytic-icon"><span class="las la-heart">
               <i class="fa fa-heart" style="font-size:20px;"></i>
               </span>
            </div>
            <div class="analytic-info">
               <h4>Total likes</h4>
               <h1>3.4M </h1>
            </div>
         </div>
      </div>
   </section>
   <section class="section-head">
      <div class="block-grid">
         <div class="revenue-card">
            <h3 class="section-head">Total Revenue</h3>
            <div class="rev-content">
               <img src="https://martelly.ca/crm/public/new/img/small-ico.png" alt="profile"> 
               <div class="rev-info">
                  <h3>Mohsen Alizade</h3>
                  <h1>3.5M <small>Subscribers</small></h1>
               </div>
               <div class="rev-sum">
                  <h4>Total income</h4>
                  <h2>$70.859</h2>
               </div>
            </div>
         </div>
         <div class="graph-card">
            <div class="h-full bg-[#f5f6fa]">
               <div class="w-full max-w-2xl mx-auto p-5">
                  <div class="bg-white rounded-md shadow p-3 sm:p-5">
                     <p class="text-base font-semibold text-[#351b5c] mb-3">Line Chart with Gradient Background Fill</p>
                     <canvas id="line-chart" class="w-full"></canvas>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <table class="dashboard">
  <tr>
    <th scope="col">Player</th>
    <th scope="col">Gloobles</th>
    <th scope="col">Za'taak</th>
  </tr>
  <tr>
    <th scope="row">TR-7</th>
    <td>7</td>
    <td>4,569</td>
  </tr>
  <tr>
    <th scope="row">Khiresh Odo</th>
    <td>7</td>
    <td>7,223</td>
  </tr>
  <tr>
    <th scope="row">Mia Oolong</th>
    <td>9</td>
    <td>6,219</td>
  </tr>
</table>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
<script>
   // bebgin line chart display
   var lineChart = document.getElementById("line-chart").getContext('2d')
   
   // line chart options
   var options = {
     borderWidth: 2,
     cubicInterpolationMode: 'monotone', // make the line curvy over zigzag
     pointRadius: 2,
     pointHoverRadius: 5,
     pointHoverBackgroundColor: '#fff',
     pointHoverBorderWidth: 4
   }
   
   // create linear gradients for line chart
   var gradientOne = lineChart.createLinearGradient(0,0,0,lineChart.canvas.clientHeight)
   gradientOne.addColorStop(0, 'rgba(51, 169, 247, 0.3)')
   gradientOne.addColorStop(1, 'rgba(0, 0, 0, 0)')
   
   var gradientTwo = lineChart.createLinearGradient(0,0,0,lineChart.canvas.clientHeight)
   gradientTwo.addColorStop(0, 'rgba(195, 113, 239, 0.15)')
   gradientTwo.addColorStop(1, 'rgba(0, 0, 0, 0)')
   
   
   new Chart(
     lineChart,
     {
         type: 'line',
         data: {
             labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
             datasets: [
                 {
                     label: 'Spending',
                     data: [310,300,370,295,350,300,230,290],
                     ...options,
                     borderColor: '#c371ef',
                     fill: 'start',
                     backgroundColor: gradientTwo
                 },
                 {
                     label: 'Emergency',
                     data: [150,230,195,260,220,300,320,490],
                     ...options,
                     borderColor: '#33a9f7',
                     fill: 'start',
                     backgroundColor: gradientOne
                 }
             ]
         },
         options: {
             plugins: {
                 legend: {
                     display: false, // hide display data about the dataset
                 },
                 tooltip: { // modify graph tooltip
                     backgroundColor: 'rgba(53, 27, 92, 0.8)',
                     caretPadding: 5,
                     boxWidth: 5,
                     usePointStyle: 'triangle',
                     boxPadding: 3
                 }
             },
             scales: {
                 x: {
                     grid: {
                         display: false // set display to false to hide the x-axis grid
                     },
                     beginAtZero: true
                 },
                 y: {
                     ticks: {
                         callback: function(value, index, values) {
                             return '$ ' + value // prefix '$' to the dataset values
                         },
                         stepSize: 100
                     }
                 }
             }
         }
     }
   )
     
</script>