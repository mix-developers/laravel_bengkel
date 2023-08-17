<ul class="pc-navbar">
    <li class="pc-item pc-caption">
        <label>{{ env('APP_NAME') }}</label>
    </li>
    {{-- @if (Auth::user()->role == 'super_admin') --}}
    <li class="pc-item"><a href="{{ url('/admin') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="layout"></i></span><span class="pc-mtext">Dashboard</span></a></li>

    <li class="pc-item pc-caption">
        <label>Master Data</label>
    </li>
    <li class="pc-item"><a href="{{ url('/admin/slider') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="image"></i></span><span class="pc-mtext">Iklan</span></a>
    </li>
    <li class="pc-item"><a href="{{ url('/admin/customer') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="user-check"></i></span><span class="pc-mtext">Customer</span></a>
    </li>
    @if (Auth::user()->role == 'super_admin')
        <li class="pc-item"><a href="{{ url('/admin/subdivision') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="map"></i></span><span class="pc-mtext">Cabang</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/admin/statuses') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="map"></i></span><span class="pc-mtext">Status Pengiriman</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/admin/transportation') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="briefcase"></i></span><span class="pc-mtext">Transportasi</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/admin/package_price') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="credit-card"></i></span><span class="pc-mtext">Paket Harga</span></a>
        </li>
    @endif
    <li class="pc-item pc-caption">
        <label>Transaksi</label>
    </li>
    <li class="pc-item"><a href="{{ url('/admin/order') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="box"></i></span><span class="pc-mtext">Input Paket</span></a>
    </li>
    <li class="pc-item"><a href="{{ url('/admin/invoice') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="file"></i></span><span class="pc-mtext">Invoice</span></a>
    </li>
    <li class="pc-item"><a href="{{ url('/admin/update_status') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="file"></i></span><span class="pc-mtext">Update Status</span></a>
    </li>

    @if (Auth::user()->role == 'super_admin')
        <li class="pc-item pc-caption">
            <label>Akun</label>
        </li>
        <li class="pc-item pc-hasmenu">
            <a href="javascript:void(0)" class="pc-link"><span class="pc-micon"><i data-feather="users"></i></span><span
                    class="pc-mtext">Modul User</span><span class="pc-arrow"><i
                        data-feather="chevron-right"></i></span></a>
            <ul class="pc-submenu">
                <li class="pc-item"><a href="{{ url('admin/user') }}" class="pc-link ">Akun Admin</a></li>
            </ul>
        </li>
    @endif
    <li class="pc-item pc-caption">
        <label>Laporan</label>
    </li>
    <li class="pc-item"><a href="{{ url('/admin/report') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="inbox"></i></span><span class="pc-mtext">laporan
            </span></a></li>

</ul>
