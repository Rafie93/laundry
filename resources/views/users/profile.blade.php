@extends('app.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <h1>Profile</h1>
                </div>
            </div>
        </div>
       
    </div>
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card alert">
                    <div class="card-body">
                        <div class="user-profile">
                            <div class="row">
                                {{-- <div class="col-lg-4">
                                    <div class="user-photo m-b-30">
                                        <img class="img-responsive" src="assets/images/user-profile.jpg" alt="" />
                                    </div>
                                 
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="user-profile-name">{{$data->fullname}}</div>
                                    <div class="user-Location"><i class="ti-location-pin"></i> 
                                        @if ($data->store_id != null)
                                            {{$data->stores->city->name}}
                                        @endif
                                    </div>
                                    <div class="user-job-title">{{$data->IS_ROLE()}}</div>
                                
                                    <div class="user-send-message">
                                        <a class="btn btn-primary btn-addon" href="{{Route('profile.change')}}"><i class="glyphicon glyphicon-edit"></i>Change Profile</a>
                                        <a class="btn btn-warning btn-addon" href="{{Route('profile.password.reset')}}"><i class="glyphicon glyphicon-lock"></i>Change Password</a>
                                    </div>
                                    <div class="custom-tab user-profile-tab">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">About</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="1">
                                                <div class="contact-information">
                                                    <h4>information</h4>
                                                     
                                                    <div class="birthday-content">
                                                        <span class="contact-title">Birthday:</span>
                                                        <span class="birth-date">{{$data->birthday}}</span>
                                                    </div>
                                                    <div class="phone-content">
                                                        <span class="contact-title">Phone:</span>
                                                        <span class="phone-number">{{$data->phone}}</span>
                                                    </div>
                                                  
                                                    <div class="email-content">
                                                        <span class="contact-title">Email:</span>
                                                        <span class="contact-email">{{$data->email}}</span>
                                                    </div>
                                                     <div class="gender-content">
                                                        <span class="contact-title">Gender:</span>
                                                        <span class="gender">{{$data->gender}}</span>
                                                    </div>
                                                    <div class="skype-content">
                                                        <span class="contact-title">Status:</span>
                                                        <span class="contact-skype">{{$data->IS_STATUS()}}</span>
                                                    </div>
                                                    <div class="address-content">
                                                        <span class="contact-title">Address:</span>
                                                        <span class="address">
                                                            @if ($data->store_id!=null)
                                                                {{$data->stores->address}}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /# column -->
          
        </div><!-- /# row -->
      
    </div>
</div>
@endsection