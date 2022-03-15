<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger" style="height: 100vh;">
    <!-- Brand Logo -->
    <a href="" class="brand-link text-center">
       <!--  <img src="{{ asset('public/images/pricon_logo2.png') }}"
            alt="OITL"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
            {{-- <i class="brand-image elevation-3 mt-2 fas fa-book-reader"></i> --}} -->
        <span class="brand-text font-weight-light">Grinding Inventory System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-3">
            
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- !--< Add icons to the links using the .nav-icon class with font-awesome or any other icon font library --> --}}
                <li class="nav-item has-treeview">
                    <a href="../RapidX/" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Go to Rapidx</p>
                    </a>
                </li>
                    
                    <li class="nav-item has-treeview">
                        <a href="../grinding_inventory" class="nav-link">
                            {{-- <i class="nav-icon fa fa-users"></i> --}}
                            <i class="nav-icon fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </li>

                
                    <li class="nav-header font-weight-bold" style="font-size: 1rem">Grinding Management</li>
                
                    <div class="nav-item has-treeview" id="ppc-id"  style="display: none;">
                        <a href="ppc" class="nav-link">
                        <li>
                            
                            <i class="nav-icon fas fa-pallet"></i>
                                <p>Basemold</p>
                        </li>
                        </a>

                    </div>

                    
                    <div class="nav-item has-treeview" id="grinding-id" style="display: none;">
                        <a href="grinding_receiving" class="nav-link">
                        <li>
                            <i class="nav-icon fas fa-file-download"></i>
                                <p>Production Receiving</p>
                        </li>
                        </a>

                       
                    </div>

                    <div class="nav-item has-treeview" id="grinding-id1" style="display: none;">
                        <a href="grinding_asset" class="nav-link">
                            <li>
                                
                                <i class="nav-icon fas fa-folder"></i>
                                    <p>Production Assets</p>
                            </li>
                        </a>
                    </div>

                   
                    <div class="nav-item has-treeview" id="grinding-id2" style="display: none;">
                        <a href="transaction_history" class="nav-link">
                        <li>
                            
                                <i class="fas fa-history"></i>
                                <p>Transaction History</p>
                        </li>
                        </a>

                    </div>

                    <div class="nav-item has-treeview" id="admin-id" style="display: none;">
                        <a href="administrator" class="nav-link">
                        <li>
                            
                                <i class="nav-icon fa fa-users"></i>
                                <p>User Management</p>
                        </li>
                        </a>

                    </div>
                   
                
                    {{-- <li class="nav-header">PRODUCTION</li> --}}
                    {{-- <li class="nav-item has-treeview">
                        <a href="grinding_recieving" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Recieving</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="grinding_asset" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Assets</p>
                        </a>
                    </li>  --}}
             
                    {{-- <li class="nav-header">ADMINISTRATOR</li> --}}
                    {{-- <li class="nav-item has-treeview">
                        <a href="administrator" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li> --}}

              
            </ul>
        </nav>
    </div>


</aside>
