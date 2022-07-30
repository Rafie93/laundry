@extends('app.app')
@section('content')
     <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                               
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li class="active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-1">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Total Berlangganan </div>
                                        <div class="stat-digit"> {{$totalBerlangganan}}</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-2">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Total Free</div>
                                        <div class="stat-digit"> {{$totalBelumBerlangganan}}</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-3">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Total Outlet</div>
                                        <div class="stat-digit"> {{$totalOutlet}}</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-4">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Total User App</div>
                                        <div class="stat-digit"> {{$totalUser}}</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Pendapatan Paket Berlangganan </h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                            <li class="card-collapse"><i class="fa fa-window-restore"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="pendapatan-chart  card-content">
                                    <canvas id="pendapatan-chart"></canvas>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <!-- /# row -->
                                     
                 <!-- /# card -->
             </div>
             <!-- /# column -->
         </div>
         <!-- /# row -->
     </div>
     <!-- /# main content -->
 </div>
@endsection
@section('script')
<script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
{{-- <script src="assets/js/lib/chart-js/chartjs-init.js"></script> --}}
<!-- // Chart js -->
{{-- <script src="assets/js/scripts.js"></script> --}}


<script>
     $(document).ready(function() {
        $.ajax({
                url: "{{ route('dashboard.getPendapatanBerlangganan') }}",
                type: "GET",
                dataType: 'json',
                success: function(rtnData) {
                    $.each(rtnData, function(dataType, data) {
                        // alert(data.datasets);

                        var ctx = document.getElementById("pendapatan-chart").getContext("2d");
                        var config = {
                            type: 'bar',
                            defaultFontFamily: 'Montserrat',
                            data: {
                                datasets: data.datasets,
                                labels: data.labels
                            },
                            options: {
                            legend: {
                                display: false
                            }
                          
                        }
                          
                        };
                        window.myLine = new Chart(ctx, config);
                    });
                },
                error: function(rtnData) {
                    alert('error' + rtnData);
                }
            });
 
      
    });
    
</script>
    
@endsection