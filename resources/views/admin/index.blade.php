@extends('admin.layout.app')

@section('main-content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="row" style="padding: 10px">
      <h3>All record</h3>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/chart-success.png')}}"
                  alt="chart success"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Total Order</p>
            <h4 class="card-title mb-3">{{$all_order}}</h4>
            
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/chart-success.png')}}"
                  alt="wallet info"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Complete Order</p>
            <h4 class="card-title mb-3">{{$complete_order}}</h4>
           
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/chart-success.png')}}"
                  alt="chart success"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Pending Order</p>
            <h4 class="card-title mb-3">{{$pending_order}}</h4>
            
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/chart-success.png')}}"
                  alt="wallet info"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Total Sell</p>
            <h4 class="card-title mb-3">{{$total_price}}</h4>
            
          </div>
        </div>
      </div>

      <div class="w-100" style="padding: 10px"></div>
      <h3>Today's Record</h3>

      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/wallet-info.png')}}"
                  alt="chart success"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Total Order</p>
            <h4 class="card-title mb-3">{{$today_order}}</h4>
            
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/wallet-info.png')}}"
                  alt="wallet info"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Complete Order</p>
            <h4 class="card-title mb-3">{{$today_complete_order}}</h4>
           
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/wallet-info.png')}}"
                  alt="chart success"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Pending Order</p>
            <h4 class="card-title mb-3">{{$today_pending_order}}</h4>
            
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between mb-4">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{asset('admin/assets/img/icons/unicons/wallet-info.png')}}"
                  alt="wallet info"
                  class="rounded" />
              </div>
              
            </div>
            <p class="mb-1">Total Sell</p>
            <h4 class="card-title mb-3">{{$today_total_price}}</h4>
            
          </div>
        </div>
      </div>
    </div>

    

    <div class="content-backdrop fade"></div>
    <div class="row">
      <div class="col-6" style="padding: 10px">
         <!-- Monthly Sales Chart -->
         <h3>Montly Performance Sales Chart</h3>
         <div>
          <canvas id="myChart"></canvas>
        </div>
      </div>
      <div class="col-6" style="padding: 10px">
        <!-- Daily Performance Chart -->
        <h3>Daily Performance Sales Chart</h3>
        <canvas id="dailySalesChart"></canvas>
     </div>
    </div>
  </div>    
 
 


@endsection

@section('scripts')
<script>
    // Monthly sales data passed from controller
    const monthlySalesLabels = {!! json_encode(array_keys($monthly_sales)) !!};
    const monthlySalesData = {!! json_encode(array_values($monthly_sales)) !!};

    

    // Monthly Sales Chart
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Total Sell',
                data: monthlySalesData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    
</script>

<script>
  // Daily sales data passed from controller
  const dailySalesLabels = {!! json_encode(array_keys($daily_sales)) !!};
  const dailySalesData = {!! json_encode(array_values($daily_sales)) !!};

  // Daily Sales Chart for the current month
  const ctx2 = document.getElementById('dailySalesChart').getContext('2d');
  new Chart(ctx2, {
      type: 'line',  // Line chart for daily sales
      data: {
          labels: dailySalesLabels,  // These labels will be the days of the current month
          datasets: [{
              label: 'Total Sell for Current Month',
              data: dailySalesData,   // Daily sales data for the current month
              backgroundColor: 'rgba(153, 102, 255, 0.2)',
              borderColor: 'rgba(153, 102, 255, 1)',
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });
</script>
@endsection
