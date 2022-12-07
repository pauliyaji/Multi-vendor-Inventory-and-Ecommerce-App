<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <title>LIVINGNERO LTD. - Dashboard</title>

   {{-- @if(!Session::has('adminData'))
      <script type="text/javascript">
          window.location.href="{{url('login')}}"
      </script>
    @endif--}}
    <!-- Custom fonts for this template-->
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">


</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{('dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
             {{--   <i class="fas fa-money-bill"></i>--}}
            </div>
            <div class="sidebar-brand-text mx-3">Livingnero <sup>Ltd</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{(url('dashboard'))}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            MASTERS
        </div>

        <!-- Nav Item - Pages Collapse Menu -->

        <!-- STAFF MASTERS  -->

        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff1" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Contacts</span>
            </a>
            <div id="collapseStaff1" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('suppliers.index') }}">Suppliers</a>
                    <a class="collapse-item" href="{{ route('customers.index') }}">Customers</a>
                </div>
            </div>
        </li>

        @if(Auth::user()->roles->first()->id == 1)
        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Factory Management</span>
            </a>
            <div id="collapseStaff2" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('factorystores.index') }}">Raw Materials Supply</a>
                    <a class="collapse-item" href="{{ route('barcodes.index') }}">Create Production Batches</a>
                    <a class="collapse-item" href="{{ route('storetrxs.index') }}">Store Transactions</a>
                    <a class="collapse-item" href="{{ route('storereports.index') }}">Store Reports</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff5" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Production Management</span>
            </a>
            <div id="collapseStaff5" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('barcodes.index') }}">Production Batches</a>
                    <a class="collapse-item" href="{{ route('productionreports.index') }}"> Production Batch Report</a>
                    <a class="collapse-item" href="{{ route('productions.index') }}">List Production Materials</a>
                    <a class="collapse-item" href="{{ route('productions.list') }}">Used Materials Summary</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff6" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Stocks Management</span>
            </a>
            <div id="collapseStaff6" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('stocks.index') }}">List All Stocks</a>
                    <a class="collapse-item" href="{{ route('shops.index') }}">All Shops</a>
                    <a class="collapse-item" href="{{ route('shoptransactions.index') }}">Shop Transactions</a>
                </div>
            </div>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff7" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Sales</span>
            </a>
            <div id="collapseStaff7" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if(Auth::user()->roles->first()->id == 1 )
                    <a class="collapse-item" href="{{ route('shopinventories.index') }}">List Shop Inventory</a>
                    <a class="collapse-item" href="{{ route('transactions.index') }}">List All Sales</a>
                    <a class="collapse-item" href="{{ route('orderdetails.index') }}">All Order Details</a>
                    <a class="collapse-item" href="{{ route('transactions.returns') }}">List Sales Return</a>
                    @endif
                        @if(Auth::user()->roles->first()->id == 4 )
                        <a class="collapse-item" href="{{ route('shopinventories.myshop') }}">My Shop</a>
                        <a class="collapse-item" href="{{ route('transactions.myshop') }}">List My Shop Sales</a>
                        <a class="collapse-item" href="{{ route('pos.create') }}">POS</a>
                        <a class="collapse-item" href="{{ route('orderdetails.myorderdetails') }}">My Order Details</a>
                        <a class="collapse-item" href="{{ route('transactions.myreturns') }}">My Sales Return</a>
                    @endif
                </div>
            </div>
        </li>
        @if(Auth::user()->roles->first()->id == 4 )
        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff8" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Reports</span>
            </a>
            <div id="collapseStaff8" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('reports.generalshopreports') }}">General Shop Report</a>
                    <a class="collapse-item" href="{{ route('reports.shopstockstransactions') }}">Shop-Stock Report</a>
                    <a class="collapse-item" href="{{ route('reports.shopsalesreport') }}">Sales Reports</a>
                    <a class="collapse-item" href="{{ route('reports.shopsalesreturned') }}"> Sales Returned Reports</a>
                    <a class="collapse-item" href="{{ route('reports.shopinvoices') }}"> All Invoices</a>


                </div>
            </div>
        </li>
        @endif
        @if(Auth::user()->roles->first()->id == 1)
        <li class="nav-item">
                <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
                   data-target="#collapseStaff8" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseStaff8" class="collapse @if(request()->is('admin/staff*')) show @endif"
                     aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('reports.index') }}">General Report</a>
                        <a class="collapse-item" href="{{ route('reports.shopreports') }}">General Shop Report</a>
                        <a class="collapse-item" href="{{ route('reports.rawmaterials') }}"> Supply Reports</a>
                        <a class="collapse-item" href="{{ route('reports.productsreport') }}"> Production Report</a>
                        <a class="collapse-item" href="{{ route('reports.stockstransactions') }}">Shop-Stock Report</a>
                        <a class="collapse-item" href="{{ route('reports.salesreport') }}">Sales Reports</a>
                        <a class="collapse-item" href="{{ route('reports.salesreturned') }}"> Sales Returned Reports</a>
                        <a class="collapse-item" href="{{ route('reports.invoices') }}"> All Invoices</a>
                    </div>
                </div>
            </li>
        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Users</span>
            </a>
            <div id="collapseStaff" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ url('users/create') }}">Add New</a>

                    <a class="collapse-item" href="{{ route('users.index') }}">View All</a>
                </div>
            </div>
        </li>
            <li class="nav-item">
                <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
                   data-target="#collapseStaff4" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Administrative Tools</span>
                </a>
                <div id="collapseStaff4" class="collapse @if(request()->is('admin/staff*')) show @endif"
                     aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('paymentmethods.index') }}">Payment Methods</a>
                        <a class="collapse-item" href="{{ route('paymentstatuses.index') }}">Payment Status</a>
                        <a class="collapse-item" href="{{ route('approvalstatuses.index') }}">Approval Status</a>
                        <a class="collapse-item" href="{{ route('units.index') }}">Units of Measure</a>
                        <a class="collapse-item" href="{{ route('rawmaterials.index') }}">Raw Materials</a>
                        <a class="collapse-item" href="{{ route('products.index') }}">Products</a>
                        <a class="collapse-item" href="{{ route('trxtypes.index') }}">Transaction Types</a>
                    </div>
                </div>
            </li>
        <li class="nav-item">
            <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse"
               data-target="#collapseStaff3" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Settings</span>
            </a>
            <div id="collapseStaff3" class="collapse @if(request()->is('admin/staff*')) show @endif"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('roles.index') }}">View Roles</a>
                    <a class="collapse-item" href="{{ route('permissions.index') }}">View Permissions</a>
                </div>
            </div>
        </li>
        @endif

    <!-- STAFF MASTERS  -->



        <!-- LOGOUT -->
        <li class="nav-item active">

            <form method="POST" action="{{ route('logout') }}">

                @csrf
                <a class="nav-link" href="route('logout')" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>

            </form>

        </li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
            {{--    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>--}}

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle" src="{{ asset('/storage/app/public/imgs/'. Auth::user()->photo) }}" height="60" width="60">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a class="dropdown-item" href="route('logout')" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                            </form>

                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="card" style="padding: 10px; margin: 10px;" >
                @if(Session::has('success'))
                    <h4 class="text-success">{{ Session('success') }}</h4>
                @elseif(Session::has('error'))
                    <h4 class="text-danger">{{ Session('error') }}</h4>

                @endif
            </div>
        @include('sweetalert::alert')
          @yield('content')
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Livingnero Ltd. 2022</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a class="btn btn-primary" :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>

    </div>
</div>

@yield('scripts')

</body>

</html>
<?php
/**
 * Created by PhpStorm.
 * User: Paul-Iyaji
 * Date: 10/8/2021
 * Time: 5:46 AM
 */
