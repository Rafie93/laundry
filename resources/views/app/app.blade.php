<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Juragan Kasir Laundry</title>
	
	<!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon--> 
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon--> 
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
	
	<!-- Styles -->
    <link href="{{asset('assets/fontAwesome/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/mmc-chat.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/lib/sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/nixon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/select2.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('assets/css/lib/bootstrap-datetimepicker.min.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/css/lib/bootstrap-timepicker.min.css')}}" />
    <link href="{{asset('assets/css/lib/sweetalert/sweetalert.css')}}" rel="stylesheet">

	@yield('style')
    @laravelPWA
</head>

<body>

    @include('app.sidebar')
    @include('app.header')
    @include('app.chat-sidebar')
    <!-- END chat Sidebar-->

    <div class="content-wrap">
        <div class="main">
           @yield('content')
        </div><!-- /# main -->
    </div><!-- /# content wrap -->


    <script src="{{asset('assets/js/lib/jquery.min.js')}}"></script><!-- jquery vendor -->
    <script src="{{asset('assets/js/lib/jquery.nanoscroller.min.js')}}"></script><!-- nano scroller -->
    <script src="{{asset('assets/js/lib/sidebar.js')}}"></script><!-- sidebar -->
    <script src="{{asset('assets/js/lib/bootstrap.min.js')}}"></script><!-- bootstrap -->
    <script src="{{asset('assets/js/lib/mmc-common.js')}}"></script>
    <script src="{{asset('assets/js/lib/mmc-chat.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script><!-- scripit init-->
    <script src="{{asset('assets/js/lib/toastr/toastr.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/select2.min.js')}}"></script><!-- scripit init-->
	<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
	<script src="{{asset('assets/js/lib/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/lib/sweetalert/sweetalert.min.js')}}"></script><!-- scripit init-->
	<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase.js"></script>

	<script>
		 $( function() {
			$( ".tanggal" ).datepicker({
					format: 'yyyy-mm-dd',
				});
			$( ".tanggal-time" ).datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
				} );
		  } );
         $('.select2').select2();
	</script>
	<script>
		var firebaseConfig = {
			apiKey: "{{ config('services.firebase.api_key') }}",
			authDomain: "{{ config('services.firebase.auth_domain') }}",
			databaseURL: "{{ config('services.firebase.database_url') }}",
			projectId: "{{ config('services.firebase.project_id') }}",
			storageBucket: "{{ config('services.firebase.storage_bucket') }}",
			messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",	    
			appId: "{{ config('services.firebase.app_id') }}",
			measurementId: "{{ config('services.firebase.measurement_id') }}"
		};
		
		firebase.initializeApp(firebaseConfig);

		var database = firebase.database();
		var lastIndex = 0;

		const messaging = firebase.messaging();
		function initFirebaseMessagingRegistration() {
				messaging
				.requestPermission()
				.then(function () {
					return messaging.getToken()
				})
				.then(function(token) {
					console.log(token);
	
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
	
					$.ajax({
						url: '{{ route("save-push-notification-token") }}',
						type: 'POST',
						data: {
							token: token
						},
						dataType: 'JSON',
						success: function (response) {
						},
						error: function (err) {
							console.log('User Chat Token Error'+ err);
						},
					});
	
				}).catch(function (err) {
					console.log('User Chat Token Error'+ err);
				});
		}  
		
		messaging.onMessage(function(payload) {
			const noteTitle = payload.notification.title;
			const noteOptions = {
				body: payload.notification.body,
				icon: payload.notification.icon,
			};
			new Notification(noteTitle, noteOptions);
		});
	</script>
	<script>
		@if(Session::has('message'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
				toastr.success("{{ session('message') }}");
		@endif

		@if(Session::has('error'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
				toastr.error("{{ session('error') }}");
		@endif

		@if(Session::has('info'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
				toastr.info("{{ session('info') }}");
		@endif

		@if(Session::has('warning'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
				toastr.warning("{{ session('warning') }}");
		@endif
	</script>
	<script>
			 var storeId = <?php echo Auth()->user()->store_id ?> ;
			firebase.database().ref('notification/store-'+storeId).orderByChild('is_read').equalTo("belum")
				.on('value', function(snapshot) {
                var value = snapshot.val();
                var htmls = [];
				var i=0;
                $.each(value, function(index, value){
					if(value) {
						htmls.push('<li>\
							<a href="#">\
								<div class="notification-content">\
									<small class="notification-timestamp pull-right">02:34 PM</small>\
									<div class="notification-heading">'+value.title+'</div>\
									<div class="notification-text">'+value.body+'</div>\
								</div>\
							</a>\
						</li>\
						');
						i++;
					}    	
                lastIndex = index;
                });
                $('#isi_notif').html(htmls);
				if(i>0){
					$('#count_bell').html(i);
				}
			});
	</script>
	@yield('script')

    


</body>

</html>