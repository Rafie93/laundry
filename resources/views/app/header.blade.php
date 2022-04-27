  <div class="header">
        <div class="pull-left">
                        <div class="logo">
                <a href="index.html">
                    <img id="logoImg" 
                    src="{{asset('logo/logojk.png')}}" 
                    data-logo_big="{{asset('logo/logojk.png')}}"
                    data-logo_small="{{asset('logo/logojk.png')}}"
                    alt="OC" />
                </a>
            </div>
            <div class="hamburger sidebar-toggle">
                <span class="ti-menu"></span>
            </div>
        </div>

        <div class="pull-right p-r-15">
            <ul>
                <li class="header-icon dib"><i class="ti-bell">
                    <span class="badge badge-warning" id="count_bell"></span>
                </i>
                    <div class="drop-down">
                        <div class="dropdown-content-heading">
                            <span class="text-left">Recent Notifications</span>
                        </div>
                        <div class="dropdown-content-body">
                            <ul>
                                <span id="isi_notif"></span>

                                <li class="text-center">
                                    <a href="#" class="more-link">See All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
              
                <li class="header-icon dib"><img class="avatar-img" src="{{asset('assets/images/avatar/1.jpg')}}" alt="" /> <span class="user-avatar">
                    {{Auth::user()->fullname}}
                    <i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">
                   
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="{{Route('myprofile')}}"><i class="ti-user"></i> <span>Profile</span></a></li>
                                <li><a href="#"><i class="ti-write"></i> <span>My Log</span></a></li>
                                <li><a href="#"><i class="ti-email"></i> <span>Inbox</span></a></li>
                                <li><a href="#"><i class="ti-settings"></i> <span>Setting</span></a></li>
                                <li><a href="{{ route('logout') }}"  
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="ti-close"></i> Logout</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>