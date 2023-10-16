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
                <td><b>Data Stok Spare Part</b></td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td style="width: 15px" class="text-center">:</td>
                <td>{{ date('d F Y') }}</td>
            </tr>

        </table>
        <div class="table-responsive">
            <table class="table_custom" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 15px;">#</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @php
                            $stok = App\Models\PartStok::getStok($item->id);
                        @endphp
                        <tr>
                            <td width="10">{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td>
                                Rp. {{ number_format($item->price) }}
                            </td>
                            <td>
                                {!! $stok > 0 ? 'Tersedia : ' . $stok : '<span class="text-danger">Kosong</span>' !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </main>

</body>

</html>
