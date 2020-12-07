<nav class="sidebar-nav">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dash') }}">
                <i class="nav-icon icon-speedometer"></i> Dashboard
            </a>
        </li>

        <li class="nav-title">MANAJEMEN PRODUK</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category.index') }}">
                <i class="nav-icon icon-target"></i> Kategori
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="nav-icon icon-cursor"></i> transaksi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembeli.index') }}">
                <i class="nav-icon icon-user"></i> Customer
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href={{ route('produk.index') }}>
                <i class="nav-icon icon-basket"></i> produk
            </a>
        </li>
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-settings"></i> Pengaturan
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('trash') }}">
                        <i class="nav-icon icon-puzzle"></i>User black list
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
