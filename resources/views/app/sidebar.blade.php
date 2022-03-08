    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                    <ul>
                    <li class="{{ (request()->segment(1) == 'dashboard' ) ? 'active' : '' }} "><a href="{{Route('dashboard')}}"><i class="ti-home"></i> Dashboard </a> </li>
                    <li class="{{ (request()->segment(1) == 'satuan' ||
                        request()->segment(1) == 'category' || 
                        request()->segment(1) == 'layanan' ) ? 'active open' : '' }} ">
                        <a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> 
                            Default Laundry <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li class="{{ (request()->segment(1) == 'satuan' ) ? 'active' : '' }}"><a href="{{Route('satuan')}}"><i class="ti-briefcase"></i> Satuan</a></li>
                            <li class="{{ (request()->segment(1) == 'category' ) ? 'active' : '' }}"><a href="{{Route('category')}}"><i class="ti-layout-grid2"></i> Category</a></li>
                            <li class="{{ (request()->segment(1) == 'layanan' ) ? 'active' : '' }}"><a href="{{Route('layanan')}}"><i class="ti-package"></i> Layanan</a></li>
                        </ul>
                    </li>
                    @if (Auth::user()->role==11)
                        <li class="{{ (request()->segment(1) == 'member' ) ? 'active' : '' }} "><a href="{{Route('member')}}"><i class="glyphicon glyphicon-user"></i> Member</a></li>
                        <li class="{{ (request()->segment(1) == 'news' ) ? 'active' : '' }} "><a href="{{Route('news')}}"><i class="ti-layout-media-right-alt"></i> News</a></li>
                        <li class="{{ (request()->segment(1) == 'stores' ) ? 'active' : '' }} "><a href="{{Route('stores')}}"><i class="ti-microsoft-alt"></i> Store</a></li>
                        <li class="{{ (request()->segment(1) == 'products' || request()->segment(1) == 'category' ) ? 'active open' : '' }} "><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> Product <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li class="{{ (request()->segment(1) == 'category' ) ? 'active' : '' }}"><a href="{{Route('category')}}"><i class="ti-layout-grid2"></i> Kategori</a></li>
                            <li class="{{ (request()->segment(1) == 'products' ) ? 'active' : '' }}"><a href="{{Route('products')}}"><i class="ti-briefcase"></i> Product</a></li>
  
                        </ul>
                    </li>    
                    @endif
                

                    @if (Auth::user()->IN_STORE())
                    <li class="{{ (request()->segment(1) == 'order' ) ? 'active open' : '' }} ">
                                     <a class="sidebar-sub-toggle"><i class="ti-shopping-cart-full"></i> Order <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li class="{{ (request()->segment(1) == 'order' && request()->segment(2) == 'process') ? 'active' : '' }} ">
                            <a href="{{Route('order')}}"><i class="ti-shopping-cart"></i> Order Proses</a></li>		
                        <li class="{{ (request()->segment(1) == 'order' && request()->segment(2) == 'history' ) ? 'active' : '' }} ">
                            <a href="{{Route('order.history')}}"><i class="glyphicon glyphicon-time"></i> History Order</a></li>		
                   
                    </ul>
                     <li class="{{ (request()->segment(1) == 'event' ) ? 'active open' : '' }} ">
                         <a class="sidebar-sub-toggle"><i class="glyphicon glyphicon-calendar"></i> Subscription <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>   
                        <li class="{{ (request()->segment(2) == 'running'  ||
                                        request()->segment(2) == 'list' ||
                                        ( request()->segment(1) == 'event' &&  request()->segment(2) == 'create') ) ? 'active' : '' }} ">
                            <a href="{{Route('event.running')}}"><i class="glyphicon glyphicon-calendar"></i> Events </a></li>

                         <li class="{{ (request()->segment(1) == 'order' ) ? 'active' : '' }} ">
                            <a href="{{Route('order')}}"><i class="ti-shopping-cart"></i> Bundle</a></li>		
                   
                         <li class="{{ (request()->segment(1) == 'event/running' ) ? 'active' : '' }} ">
                            <a href="{{Route('event.running')}}"><i class="glyphicon glyphicon-calendar"></i> Reservation etc </a></li>   
                    </ul>
                   <li class="{{ (request()->segment(1) == 'product' ||
                                 request()->segment(1) == 'category' || 
                                 request()->segment(1) == 'special' ||
                                 request()->segment(1) == 'pairing' ||
                                 request()->segment(1) == 'bundle' ||
                                 request()->segment(1) == 'promo' ) ? 'active open' : '' }} "><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> Product <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li class="{{ (request()->segment(1) == 'category' ) ? 'active' : '' }}"><a href="{{Route('category')}}"><i class="ti-layout-grid2"></i> Category</a></li>
                            <li class="{{ (request()->segment(1) == 'product' ) ? 'active' : '' }}"><a href="{{Route('product')}}"><i class="ti-briefcase"></i> Product</a></li>
                            <li class="{{ (request()->segment(1) == 'special' ) ? 'active' : '' }}"><a href="{{Route('product.special')}}"><i class="ti-package"></i> Produk Spesial</a></li>
                            <li class="{{ (request()->segment(1) == 'pairing' ) ? 'active' : '' }}"><a href="{{Route('pairing')}}"><i class="ti-package"></i> Product Pairing</a></li>
                            <li class="{{ (request()->segment(1) == 'promo' ) ? 'active' : '' }}"><a href="{{Route('product.promo')}}"><i class="glyphicon glyphicon-tag"></i> Product Promo</a></li>
                            <li class="{{ (request()->segment(1) == 'bundle' ) ? 'active' : '' }}"><a href="{{Route('product.bundle')}}"><i class="glyphicon glyphicon-tag"></i> Product Bundle</a></li>
                        </ul>
                    </li>
                     <li class="{{ (request()->segment(1) == 'member' ) ? 'active' : '' }} ">
                            <a href="{{Route('member')}}"><i class="glyphicon glyphicon-user"></i> Member</a>
                    </li>	       
                    @endif
					@if (in_array(Auth::user()->role,[11,12]))
                        <li class="{{ (request()->segment(1) == 'voucher' ) ? 'active' : '' }} ">
                            <a href="{{Route('voucher')}}"><i class="glyphicon glyphicon-gift"></i> Voucher</a></li>					

                        <li class="{{ (request()->segment(1) == 'users' || 
                                 request()->segment(1) == 'access' ||
                                 request()->segment(1) == 'setting' ||
                                 request()->segment(1) == 'seat' ||
                                 request()->segment(1) == 'tax' ||
                                 request()->segment(1) == 'slider' ||
                                 request()->segment(1) == 'courier' ||
                                 request()->segment(1) == 'worktime' ||
                                 request()->segment(1) == 'paymentmethod' ||
                                 request()->segment(1) == 'regions' ) ? 'active open' : '' }}"><a class="sidebar-sub-toggle"><i class="ti-settings"></i> Master & System <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                              <li class="{{ (request()->segment(1) == 'slider' ) ? 'active' : '' }} "><a href="{{Route('slider')}}"><i class="glyphicon glyphicon-film"></i> Slider</a></li>					
                                @if (Auth::user()->role==11)
                                    <li class="{{ (request()->segment(1) == 'paymentmethod' ) ? 'active' : '' }}">
                                        <a href="{{Route('paymentmethod')}}"><i class="ti-money"></i> Payment Method</a>
                                    </li>
                                     <li class="{{ (request()->segment(1) == 'courier' ) ? 'active' : '' }}">
                                        <a href="{{Route('courier')}}"><i class="glyphicon glyphicon-plane"></i> Courier</a>
                                    </li>
                                    {{-- <li class="{{ (request()->segment(1) == 'regions' ) ? 'active' : '' }}"><a href="#"><i class="ti-world"></i> Regions</a></li> --}}
                                @endif
                                @if (Auth::user()->role==12)
                                      <li class="{{ (request()->segment(1) == 'seat' ) ? 'active' : '' }}">
                                        <a href="{{Route('seat')}}"><i class="ti-tablet"></i> Table / Seat</a></li>
                                     <li class="{{ (request()->segment(1) == 'tax' ) ? 'active' : '' }}">
                                        <a href="{{Route('tax')}}"><i class="ti-money"></i> Tax</a></li>
 
                                @endif
                                <li class="{{ (request()->segment(1) == 'users' ) ? 'active' : '' }}"><a href="{{Route('user')}}">
                                    <i class="ti-user"></i> 
                                    @if (Auth::user()->role==11)
                                        User
                                    @else 
                                        User & Kurir
                                    @endif
                                </a></li>
                                {{-- <li class="{{ (request()->segment(1) == 'access' ) ? 'active' : '' }}"><a href="#"><i class="ti-key"></i> Access</a></li> --}}
                                <li class="{{ (request()->segment(1) == 'worktime' ) ? 'active' : '' }}">
                                    <a href="{{Route('worktime')}}"><i class="ti-settings"></i> Work Time</a></li>
                            </ul>
                        </li>
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

