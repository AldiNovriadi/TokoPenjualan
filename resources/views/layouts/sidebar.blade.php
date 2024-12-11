<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#master-data-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-data-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('jenis-barang') }}">
                    <i class="bi bi-circle"></i><span>Jenis Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('barang') }}">
                    <i class="bi bi-circle"></i><span>Barang</span>
                </a>
            </li>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('transaksi-penjualan') }}">
            <i class="bi bi-bar-chart"></i>
            <span>Transaksi Penjualan</span>
        </a>
    </li>

</ul>