<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('transactions.index') }}">
                    <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                    Transaction
                </a>
                <a class="nav-link" href="{{ route('payment-methods.index') }}">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Payment
                </a>
                <a class="nav-link" href="{{ route('categories.index') }}">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Category
                </a>
                <a class="nav-link mb-auto" href="{{ route('profile.edit') }}">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Profile
                </a>
            </div>
        </div>
           
        
    </nav>
</div>
