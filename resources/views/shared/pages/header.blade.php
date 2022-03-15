<!-- Navbar -->
<nav class="navbar navbar-expand navbar-dark border-bottom fixed-top py-1" >
    <!-- Left navbar links -->
    <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item">
            <h4 class="nav-link"><img src="{{ asset('public/image/pricon_logo2.png') }}" style="height: 40px;"><b>Grinding Inventory System </b></h4>
        </li>
        <span class="text-white">|</span>
       <!--  <li class="nav-item d-none d-lg-inline-block">
            <a class="nav-link text-muted txtWorkInstruction"><h6 style="margin-top: 2px" class="text-white" disabled> Dashboard</h6></a>
        </li> -->

        
    </ul>

    <!-- Right navbar links -->
    {{-- <ul class="navbar-nav ml-auto ">
        <span id="aLogout" data-toggle="modal" data-target="#modalLogout" style="cursor: pointer; color: white;">
            <i class="fas fa-sign-out-alt fa-lg mr-2 nav-link"></i>Logout
        </span>
         --}}
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                @auth
                    {{ Auth::user()->name }}
                @endauth
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <span href="#" class="dropdown-item" id="aLogout" data-toggle="modal" data-target="#modalLogout">
                    <i class="fas fa-user mr-2"></i>Logout
                </span>
            </div>
        </li> --}}
    {{-- </ul> --}}
</nav>

