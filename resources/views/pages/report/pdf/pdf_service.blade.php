<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css') }}/pdf/bootstrap.min.css" media="all" />
    <style>
        body {
            font-family: 'times new roman';
            font-size: 16px;
        }

        .page_break {
            page-break-before: always;
        }

        table.table_custom th,
        table.table_custom td {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid;
            padding: 5px;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
</head>

<body>
    <main class="mt-0">
        <table class="" style="font-size: 18px; padding:5px; width:100%; border:0px;">
            <tr>
                <td style="width: 20%">
                    <img style="width: 130px;" src="{{ public_path('img') }}/favicon.png">
                </td>
                <td class="text-center" style="width: 80%">
                    <strong style="font-size: 22px;">BENGKEL INTAN JAYA</strong><br>
                    Jl. SP2 <br>
                    Website: https://intan-jaya.mixdev.id/
                </td>
                <td style="width: 20%"></td>
            </tr>
        </table>
        <hr style="border: 1px solid black;">
        <table class="table-borderless mb-3">
            <tr>
                <td>Laporan</td>
                <td style="width: 15px" class="text-center">:</td>
                <td><b>Data Service</b></td>
            </tr>
            <tr>
                <td>Tanggal </td>
                <td style="width: 15px" class="text-center">:</td>
                <td>{{ $from_date . ' Sampai ' . $to_date }}</td>
            </tr>

        </table>
        <div class="table-responsive">
            <table class="table_custom" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 15px;">#</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Alamat</th>
                        <th>Nomor Hp</th>
                        <th>Status Service</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td width="10">{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->user->role != 'customer')
                                    {{ App\Models\ServiceOut::getIdentity($item->code)->name }} <br>
                                    <small class="text-danger">(Non Member)</small>
                                @else
                                    {{ $item->user->name }}<br>
                                    <small class="text-primary">(Member)</small>
                                @endif
                            </td>
                            <td>
                                {!! $item->description !!}
                            </td>
                            <td>
                                {{ $item->user->address }}
                            </td>
                            <td>
                                {{ $item->user->phone }}
                            </td>
                            <td>
                                {{ App\Models\ServiceStatus::getLastStatus($item->id)->status->status ?? 'Belum ada status' }}
                            </td>
                            <td>
                                @if (App\Models\ServicePayment::where('id_service', $item->id)->first() == null)
                                    <span class="text-danger">Belum membayar
                                    </span>
                                @else
                                    @php
                                        $bayar = App\Models\ServicePayment::where('id_service', $item->id)->first();
                                    @endphp
                                    @if ($bayar->is_verified == 0)
                                        <span class="text-warning">Menunggu
                                            Konfirmasi</span>
                                    @elseif($bayar->is_verified == 1)
                                        <span class="text-success">Berhasil
                                            dikonfirmasi</span>
                                    @elseif($bayar->is_verified == 2)
                                        <span class="text-danger">Pembayaran
                                            Ditolak</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
