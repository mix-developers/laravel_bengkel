<ul class="pc-navbar">
    <li class="pc-item pc-caption">
        <label>{{ env('APP_NAME') }}</label>
    </li>
    {{-- @if (Auth::user()->role == 'super_admin') --}}
    <li class="pc-item"><a href="{{ url('/home') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="layout"></i></span><span class="pc-mtext">Dashboard</span></a></li>
    @if (Auth::user()->role == 'admin')
        <li class="pc-item pc-caption">
            <label>Spare Part</label>
        </li>
        <li class="pc-item"><a href="{{ url('/part') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="settings"></i></span><span class="pc-mtext">Spare Parts</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/part_stok') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="settings"></i></span><span class="pc-mtext">Stok</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Mekanik</label>
        </li>
        <li class="pc-item"><a href="{{ url('/mechanical') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="users"></i></span><span class="pc-mtext">Data Mekanik</span></a>
        <li class="pc-item pc-caption">
            <label>Bank</label>
        </li>
        </li>
        <li class="pc-item"><a href="{{ url('/bank') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Data Bank</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Service Pending</label>
        </li>
        <li class="pc-item"><a href="{{ url('/service/member') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Service Member</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/service/non_member') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Service Non-Member</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Service Process</label>
        </li>
        <li class="pc-item"><a href="{{ url('/service/process') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Data Service</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Service Payment Pending</label>
        </li>
        <li class="pc-item"><a href="{{ url('/service/payment') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="file"></i></span><span class="pc-mtext">Data Payment</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Order</label>
        </li>
        <li class="pc-item"><a href="{{ url('/order') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Data Order</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Ulasan</label>
        </li>
        <li class="pc-item"><a href="{{ url('/rating') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="star"></i></span><span class="pc-mtext">Data Ulasan</span></a>
        </li>
    @endif

    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
        <li class="pc-item pc-caption">
            <label>Laporan</label>
        </li>
        <li class="pc-item"><a href="{{ url('/report/service') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="file-text"></i></span><span class="pc-mtext">Laporan Service</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/report/part') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="file-text"></i></span><span class="pc-mtext">Laporan Stok</span></a>
        </li>
        <li class="pc-item"><a href="{{ url('/report/pengeluaran') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="file-text"></i></span><span class="pc-mtext">Laporan Pengeluaran</span></a>
        </li>
    @endif
    @if (Auth::user()->role == 'customer')
        <li class="pc-item pc-caption">
            <label>Service</label>
        </li>
        <li class="pc-item"><a href="{{ url('/service/member') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Data Service</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Order</label>
        </li>
        <li class="pc-item"><a href="{{ url('/order') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="folder"></i></span><span class="pc-mtext">Data Order</span></a>
        </li>
    @endif

</ul>
