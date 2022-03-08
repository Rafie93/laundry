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
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-1">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Today Shipping </div>
                                        <div class="stat-digit"> <i class="fa fa-dollar-sign"></i>10</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-3">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Task Completed</div>
                                        <div class="stat-digit"> 500</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-4">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Today Progress</div>
                                        <div class="stat-digit"> 100%</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    </div>
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
    <script src="assets/js/lib/chart-js/chartjs-init.js"></script>
    <!-- // Chart js -->
    <!--  Datamap -->
    <script src="assets/js/lib/datamap/d3.min.js"></script>
    <script src="assets/js/lib/datamap/topojson.js"></script>
    <script src="assets/js/lib/datamap/datamaps.world.min.js"></script>
    <script src="assets/js/lib/datamap/datamap-init.js"></script>
    <script src="assets/lib/lobipanel/js/lobipanel.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        $( function() {
            initFirebaseMessagingRegistration();
        });
   </script>
@endsection