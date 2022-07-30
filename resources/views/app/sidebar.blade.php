    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                    <ul>
                    <li class="{{ (request()->segment(1) == 'dashboard' ) ? 'active' : '' }} "><a href="{{Route('dashboard')}}"><i class="ti-home"></i> Dashboard </a> </li>
                    @if (auth()->user()->isSuperAdmin())
                        <li class="{{ (request()->segment(1) == 'slider' ) ? 'active' : '' }} ">
                            <a href="{{Route('slider')}}"><i class="ti-layout-media-overlay-alt"></i> Slider </a> </li>

                        <li class="{{ (request()->segment(1) == 'purchase' ) ? 'active' : '' }} ">
                                <a href="{{Route('purchase')}}"><i class="ti-blackboard"></i>Transaksi Langganan </a> </li>

                        <li class="{{ (request()->segment(1) == 'outlet' ) ? 'active' : '' }} ">
                            <a href="{{Route('outlet')}}"><i class="ti-harddrives"></i>Outlet </a> </li>

                        <li class="{{ (request()->segment(1) == 'paket' ) ? 'active' : '' }} ">
                                <a href="{{Route('paket')}}"><i class="ti-package"></i>Paket Berlangganan </a> </li>

                        <li class="{{ (request()->segment(1) == 'user' ) ? 'active' : '' }} ">
                                <a href="{{Route('user')}}"><i class="ti-user"></i>User </a> </li>

                        <li class="{{ (request()->segment(1) == 'satuan' ||
                            request()->segment(1) == 'category' || 
                            request()->segment(1) == 'method' || 
                            request()->segment(1) == 'layanan' ) ? 'active open' : '' }} ">
                            <a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> 
                                Default Laundry <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li class="{{ (request()->segment(1) == 'satuan' ) ? 'active' : '' }}"><a href="{{Route('satuan')}}"><i class="ti-briefcase"></i> Satuan</a></li>
                                <li class="{{ (request()->segment(1) == 'category' ) ? 'active' : '' }}"><a href="{{Route('category')}}"><i class="ti-layout-grid2"></i> Category</a></li>
                                <li class="{{ (request()->segment(1) == 'layanan' ) ? 'active' : '' }}"><a href="{{Route('layanan')}}"><i class="ti-package"></i> Layanan</a></li>
                                <li class="{{ (request()->segment(1) == 'method' ) ? 'active' : '' }}"><a href="{{Route('method')}}"><i class="ti-package"></i> Metode Pembayaran</a></li>

                            </ul>
                        </li>
                    @else 
                    <li class="{{ (request()->segment(1) == 'purchase' ) ? 'active' : '' }} ">
                        <a href="{{Route('purchase')}}"><i class="ti-blackboard"></i>History Langganan </a> </li>

                        @if (auth()->user()->role==2||auth()->user()->role==3)
                        <li class="{{ (request()->segment(1) == 'outlet' ) ? 'active' : '' }} ">
                            <a href="{{Route('outlet')}}"><i class="ti-harddrives"></i>Outlet </a> </li>

                            <li class="{{ (request()->segment(1) == 'users' ) ? 'active' : '' }} ">
                                <a href="{{Route('user')}}"><i class="ti-user"></i>Pegawai </a> </li>
                                
                            <li class="{{ (request()->segment(1) == 'satuan' ||
                                request()->segment(1) == 'category' || 
                                request()->segment(1) == 'method' || 
                                request()->segment(1) == 'layanan' ) ? 'active open' : '' }} ">
                                <a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> 
                                    Master Data <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                                <ul>
                                    <li class="{{ (request()->segment(1) == 'satuan' ) ? 'active' : '' }}"><a href="{{Route('satuan')}}"><i class="ti-briefcase"></i> Satuan</a></li>
                                    <li class="{{ (request()->segment(1) == 'category' ) ? 'active' : '' }}"><a href="{{Route('category')}}"><i class="ti-layout-grid2"></i> Category</a></li>
                                    <li class="{{ (request()->segment(1) == 'layanan' ) ? 'active' : '' }}"><a href="{{Route('layanan')}}"><i class="ti-package"></i> Layanan</a></li>
                                    <li class="{{ (request()->segment(1) == 'method' ) ? 'active' : '' }}"><a href="{{Route('method')}}"><i class="ti-package"></i> Metode Pembayaran</a></li>

                                </ul>
                            </li>
                        @endif
                        
                    @endif
                   
                
                 
					<li><a href="{{ route('logout') }}"  
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="ti-close"></i> Logout</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </ul>
               
            </div>
        </div>
    </div><!-- /# sidebar -->

