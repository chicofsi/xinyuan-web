
<div class="left-side sticky-left-side">

    <!--logo and iconic logo start-->
    <div class="logo">
        <a href="{{route('dashboard')}}"><img src="{{asset('img/logo.png')}}" alt=""></a>
    </div>

    <div class="logo-icon text-center">
        <a href="{{route('dashboard')}}"><img src="{{asset('img/logo_icon.png')}}" alt=""></a>
    </div>
    <!--logo and iconic logo end-->

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                
            </div>

            
        </div>

        {{-- sidebar nav start --}}
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li @if (\Request::is('dashboard')) class="active" @endif><a href="{{route('dashboard')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>

            @if(Auth::guard('web')->check())
            
                <li @if (\Request::is('dashboard/area')) class="active" @endif ><a href="{{url('/dashboard/area')}}"><i class="fas fa-warehouse"></i> <span>Manage Area</span></a></li>

                <li @if (\Request::is('dashboard/company')) class="active" @endif ><a href="{{url('/dashboard/company')}}"><i class="fas fa-warehouse"></i> <span>Manage Company</span></a></li>
                    
                <li class="menu-list @if (\Request::is('dashboard/employee/*')||\Request::is('dashboard/employee')) active @endif"><a href=""><i class="fas fa-id-badge"></i> <span>Employee</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{{url('/dashboard/employee')}}"> Manage Sales</a></li>
                        @foreach ($areas as $area)
                        <li><a href="{{url('/dashboard/employee/'.$area->id)}}"> Manage Sales {{$area->name}}</a></li>
                        @endforeach
                        <li><a href="{{url('/dashboard/employee/target')}}"> Manage Sales Target</a></li>
                    </ul>
                </li>

                
            
                <li class="menu-list @if (\Request::is('dashboard/product/*')||\Request::is('dashboard/product')) active @endif"><a href=""><i class="fas fa-cubes"></i> <span>Product</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{{url('/dashboard/product/factories')}}"> Manage Product Factories</a></li>
                        <li><a href="{{url('/dashboard/product/type')}}"> Manage Product Type</a></li>
                        <li><a href="{{url('/dashboard/product/size')}}"> Manage Product Size</a></li>
                        <li><a href="{{url('/dashboard/product/weight')}}"> Manage Product Net Weight</a></li>
                        <li><a href="{{url('/dashboard/product/grossweight')}}"> Manage Product Gross Weight</a></li>
                        <li><a href="{{url('/dashboard/product/colour')}}"> Manage Product Colour</a></li>
                        <li><a href="{{url('/dashboard/product/logo')}}"> Manage Product Logo</a></li>
                        <li><a href="{{url('/dashboard/product')}}"> Manage Product</a></li>
                    </ul>
                </li>
                <li class="menu-list @if (\Request::is('dashboard/warehouse/*')||\Request::is('dashboard/warehouse')) active @endif"><a href=""><i class="fas fa-warehouse"></i> <span>Warehouse & Stock</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{{url('/dashboard/warehouse/')}}"> Manage Warehouse</a></li>
                    </ul>
                    <ul class="sub-menu-list">
                        <li><a href="{{url('/dashboard/warehouse/product')}}"> All Product Stock</a></li>
                    </ul>
                </li>

            @endif
                <li class="menu-list @if (\Request::is('dashboard/customer/*')||\Request::is('dashboard/customer')) active @endif"><a href=""><i class="fas fa-users"></i> <span>Customer</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{{url('/dashboard/customer/level')}}"> Manage Customer Level</a></li>
                        <li><a href="{{url('/dashboard/customer')}}"> Manage Customer</a></li>
                        @foreach ($areas as $area)
                        <li><a href="{{url('/dashboard/customer/'.$area->id)}}"> Manage Customer {{$area->name}}</a></li>
                        @endforeach

                        <li><a href="{{url('/dashboard/customer/summary')}}"> Customer Summary</a></li>
                    </ul>
                </li>

                <li class="menu-list @if (\Request::is('dashboard/bank/*')||\Request::is('dashboard/bank')) active @endif"><a href=""><i class="fas fa-credit-card"></i> <span>Payment Account</span></a>
                    <ul class="sub-menu-list">
                        @if(Auth::guard('web')->check())
                        <li @if (\Request::is('dashboard/bank')) class="active" @endif ><a href="{{url('/dashboard/bank')}}"><i class="fas fa-cash-register"></i> <span>Manage Bank</span></a></li>
                        <li @if (\Request::is('dashboard/bank/account')) class="active" @endif ><a href="{{url('/dashboard/bank/account')}}"><i class="fas fa-cash-register"></i> <span>Manage Payment Account</span></a></li>
                        @endif

                    </ul>
                </li>
                

                <li @if (\Request::is('dashboard/transaction')) class="active" @endif ><a href="{{url('/dashboard/transaction')}}"><i class="fas fa-cash-register"></i> <span>Manage Transaction</span></a></li>

                <li @if (\Request::is('dashboard/transaction/refund')) class="active" @endif ><a href="{{url('/dashboard/transaction/refund')}}"><i class="fas fa-cash-register"></i> <span>Refund History</span></a></li>
                
                <li @if (\Request::is('dashboard/payment')) class="active" @endif ><a href="{{url('/dashboard/payment')}}"><i class="fas fa-cash-register"></i> <span>Manage Payment</span></a></li>

                <li @if (\Request::is('dashboard/payment/giro')) class="active" @endif ><a href="{{url('/dashboard/payment/giro')}}"><i class="fas fa-cash-register"></i> <span>Manage Giro</span></a></li>

                <li @if (\Request::is('dashboard/payment/history')) class="active" @endif ><a href="{{url('/dashboard/payment/history')}}"><i class="fas fa-cash-register"></i> <span>Payment History</span></a></li>


                <li @if (\Request::is('dashboard/purchase')) class="active" @endif ><a href="{{url('/dashboard/purchase')}}"><i class="fas fa-cash-register"></i> <span>Manage Purchase</span></a></li>
                <li @if (\Request::is('dashboard/purchase/payment')) class="active" @endif ><a href="{{url('/dashboard/purchase/payment')}}"><i class="fas fa-cash-register"></i> <span>Purchase Payment</span></a></li>
                <li @if (\Request::is('dashboard/value-management')) class="active" @endif ><a href="{{url('/dashboard/value-management')}}"><i class="fas fa-cash-register"></i> <span>Product Value</span></a></li>
                <li @if (\Request::is('dashboard/currency-profit-loss')) class="active" @endif ><a href="{{url('/dashboard/currency-profit-loss')}}"><i class="fas fa-cash-register"></i> <span>Currency Profit & Loss</span></a></li>

                <li @if (\Request::is('dashboard/asset')) class="active" @endif ><a href="{{url('/dashboard/asset/')}}"><i class="fas fa-warehouse"></i> <span>Assets Management</span></a></li>

                @if(Auth::guard('web')->check())
                <li class="menu-list @if (\Request::is('dashboard/finance/*')||\Request::is('dashboard/finance')) active @endif"><a href=""><i class="fas fa-cash-register"></i> <span>Finance</span></a>
                    <ul class="sub-menu-list">
                        <li @if (\Request::is('dashboard/finance/reports')) class="active" @endif ><a href="{{url('/dashboard/finance/reports')}}"> <span>Reports</span></a></li>
                        <li @if (\Request::is('dashboard/finance')) class="active" @endif ><a href="{{url('/dashboard/finance')}}"> <span>Cash & Bank</span></a></li>
                        <li @if (\Request::is('dashboard/finance/sales')) class="active" @endif ><a href="{{url('/dashboard/finance/sales')}}"> <span>Sales</span></a></li>
                        <li @if (\Request::is('dashboard/finance/purchase')) class="active" @endif ><a href="{{url('/dashboard/finance/purchase')}}"> <span>Purchases</span></a></li>
                        <li @if (\Request::is('dashboard/finance/expenses')) class="active" @endif ><a href="{{url('/dashboard/finance/expenses')}}"> <span>Expenses</span></a></li>

                        <li @if (\Request::is('dashboard/finance/contact')) class="active" @endif ><a href="{{url('/dashboard/finance/contact/')}}"> <span>Contact</span></a></li>
                        <li @if (\Request::is('dashboard/finance/product')) class="active" @endif ><a href="{{url('/dashboard/finance/product/')}}"> <span>Product</span></a></li>
                        
                        <li @if (\Request::is('dashboard/finance/chart/1')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/1')}}"><span>Accounts Receivable (A/R)</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/2')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/2')}}"><span>Other Current Assets</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/3')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/3')}}"><span>Cash & Bank</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/4')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/4')}}"><span>Inventory</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/5')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/5')}}"><span>Fixed Assets</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/6')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/6')}}"><span>Other Assets</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/7')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/7')}}"><span>Depreciation & Amortization</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/8')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/8')}}"><span>Account Payable (A/P)</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/10')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/10')}}"><span>Other Current Liabilities</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/11')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/11')}}"><span>Long Term Liabilities</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/12')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/12')}}"><span>Equity   </span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/13')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/13')}}"><span>Income</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/14')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/14')}}"><span>Other Income</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/15')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/15')}}"><span>Cost of Goods Sold</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/16')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/16')}}"><span>Expenses</span></a></li>
                        <li @if (\Request::is('dashboard/finance/chart/17')) class="active" @endif ><a href="{{url('/dashboard/finance/chart/17')}}"><span>Other Expense</span></a></li>
                    </ul>
                </li>
                @endif

                

                
            <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" ><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>



            {{-- <li class="menu-list"><a href=""><i class="fa fa-laptop"></i> <span>Layouts</span></a>
                <ul class="sub-menu-list">
                    <li><a href="blank_page.html"> Blank Page</a></li>
                    <li><a href="boxed_view.html"> Boxed Page</a></li>
                    <li><a href="leftmenu_collapsed_view.html"> Sidebar Collapsed</a></li>
                    <li><a href="horizontal_menu.html"> Horizontal Menu</a></li>

                </ul>
            </li>
            <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>UI Elements</span></a>
                <ul class="sub-menu-list">
                    <li><a href="general.html"> General</a></li>
                    <li><a href="buttons.html"> Buttons</a></li>
                    <li><a href="tabs-accordions.html"> Tabs & Accordions</a></li>
                    <li><a href="typography.html"> Typography</a></li>
                    <li><a href="slider.html"> Slider</a></li>
                    <li><a href="panels.html"> Panels</a></li>
                </ul>
            </li>
            <li class="menu-list"><a href=""><i class="fa fa-cogs"></i> <span>Components</span></a>
                <ul class="sub-menu-list">
                    <li><a href="grids.html"> Grids</a></li>
                    <li><a href="gallery.html"> Media Gallery</a></li>
                    <li><a href="calendar.html"> Calendar</a></li>
                    <li><a href="tree_view.html"> Tree View</a></li>
                    <li><a href="nestable.html"> Nestable</a></li>

                </ul>
            </li>

            <li><a href="fontawesome.html"><i class="fa fa-bullhorn"></i> <span>Fontawesome</span></a></li>

            <li class="menu-list"><a href=""><i class="fa fa-envelope"></i> <span>Mail</span></a>
                <ul class="sub-menu-list">
                    <li><a href="mail.html"> Inbox</a></li>
                    <li><a href="mail_compose.html"> Compose Mail</a></li>
                    <li><a href="mail_view.html"> View Mail</a></li>
                </ul>
            </li>

            <li class="menu-list"><a href=""><i class="fa fa-tasks"></i> <span>Forms</span></a>
                <ul class="sub-menu-list">
                    <li><a href="form_layouts.html"> Form Layouts</a></li>
                    <li><a href="form_advanced_components.html"> Advanced Components</a></li>
                    <li><a href="form_wizard.html"> Form Wizards</a></li>
                    <li><a href="form_validation.html"> Form Validation</a></li>
                    <li><a href="editors.html"> Editors</a></li>
                    <li><a href="inline_editors.html"> Inline Editors</a></li>
                    <li><a href="pickers.html"> Pickers</a></li>
                    <li><a href="dropzone.html"> Dropzone</a></li>
                </ul>
            </li>
            <li class="menu-list"><a href=""><i class="fa fa-bar-chart-o"></i> <span>Charts</span></a>
                <ul class="sub-menu-list">
                    <li><a href="flot_chart.html"> Flot Charts</a></li>
                    <li><a href="morris.html"> Morris Charts</a></li>
                    <li><a href="chartjs.html"> Chartjs</a></li>
                    <li><a href="c3chart.html"> C3 Charts</a></li>
                </ul>
            </li>
            <li class="menu-list"><a href="#"><i class="fa fa-th-list"></i> <span>Data Tables</span></a>
                <ul class="sub-menu-list">
                    <li><a href="basic_table.html"> Basic Table</a></li>
                    <li><a href="dynamic_table.html"> Advanced Table</a></li>
                    <li><a href="responsive_table.html"> Responsive Table</a></li>
                    <li><a href="editable_table.html"> Edit Table</a></li>
                </ul>
            </li>

            <li class="menu-list"><a href="#"><i class="fa fa-map-marker"></i> <span>Maps</span></a>
                <ul class="sub-menu-list">
                    <li><a href="google_map.html"> Google Map</a></li>
                    <li><a href="vector_map.html"> Vector Map</a></li>
                </ul>
            </li>
            <li class="menu-list"><a href=""><i class="fa fa-file-text"></i> <span>Extra Pages</span></a>
                <ul class="sub-menu-list">
                    <li><a href="profile.html"> Profile</a></li>
                    <li><a href="invoice.html"> Invoice</a></li>
                    <li><a href="pricing_table.html"> Pricing Table</a></li>
                    <li><a href="timeline.html"> Timeline</a></li>
                    <li><a href="blog_list.html"> Blog List</a></li>
                    <li><a href="blog_details.html"> Blog Details</a></li>
                    <li><a href="directory.html"> Directory </a></li>
                    <li><a href="chat.html"> Chat </a></li>
                    <li><a href="404.html"> 404 Error</a></li>
                    <li><a href="500.html"> 500 Error</a></li>
                    <li><a href="registration.html"> Registration Page</a></li>
                    <li><a href="lock_screen.html"> Lockscreen </a></li>
                </ul>
            </li>
            <li><a href="login.html"><i class="fa fa-sign-in"></i> <span>Login Page</span></a></li> --}}

        </ul>
        <!--sidebar nav end-->

    </div>
</div>
