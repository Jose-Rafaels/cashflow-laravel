<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <!-- Sidenav Menu Heading (Core)-->
                <a class="nav-link <?= isset($dashboard) ? 'active' : '' ?>" href="{{ route('dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?= isset($absensi) ? 'active' : '' ?>" href="{{ route('transactions.index') }}">
                    <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                    Transaction
                </a>
                <a class="nav-link <?= isset($toko) ? 'active' : '' ?>" href="{{ route('payment-methods.index') }}">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Payment
                </a>
                <a class="nav-link <?= isset($toko) ? 'active' : '' ?>" href="{{ route('categories.index') }}">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Category
                </a>

            </div>
        </div>
    </nav>
</div>
