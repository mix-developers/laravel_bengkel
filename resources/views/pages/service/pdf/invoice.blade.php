<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    <style>
        @page {
            margin: 5px;
            /* size: 165pt 100vh; */
        }

        body {
            margin: 5px 5px 0px 5px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        h5,
        p {
            margin: 2px 0;
        }

        p {
            font-size: 8px;
        }

        .container {
            width: 170px;
        }

        table {
            font-size: 8px;
        }

        thead,
        tbody {
            border-bottom: .5px solid #000;
            margin-bottom: 10px;
        }

        td {
            padding-bottom: 5px;
            padding-right: 5px;
        }

        thead,
        tfoot {
            font-weight: bold;
            font-size: 8px;
        }

        header {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            font-size: 10px;
        }

        table {
            font-family: sans-serif;
            color: #232323;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #999;
            padding: 4px 10px;
        }
    </style>
</head>

<body>

    <center><img src="{{ public_path() }}/img/favicon.png" alt="" width="50" style="text-align:center;" /><BR>
        <small>{{ env('APP_NAME') }}</small>
    </center>

    <table class="table table-bordered table-hover" id="table-order">
        <thead>
            <tr>
                <th colspan='2' style="text-align:center;"><strong>Invoice</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Kode Service</td>
                <td align="center">
                    <strong>{{ $data->code }}</strong>
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>
                    @if ($data->user->role != 'customer')
                        <strong>{{ App\Models\ServiceOut::getIdentity($data->code)->name }}</strong><br>
                        <small>Non-member</small>
                    @else
                        <strong>{{ $data->user->name }}</strong><br>
                        <small>Member</small>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Total Bayar</td>
                <td><strong>Rp {{ number_format($total_biaya) }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal Service</td>
                <td>{{ $data->created_at->format('d F Y') }}</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <center>Pembayaran : </center>
    <table class="table">
        <tr>
            <td>1</td>
            <td>Cash</td>
        </tr>
        @foreach (App\Models\Bank::all() as $item)
            <tr>
                <td>{{ $loop->iteration + 1 }}</td>
                <td><strong>{{ $item->no_rekening }}</strong><br>{{ $item->bank . ' - ' . $item->nama_pemilik }}</td>
            </tr>
        @endforeach
    </table>
    <center>
        <p style="font-size: 8px; color:red;">*Silahkan cek <b>kode service</b> anda pada :
            {{ url('/') }}</p>
    </center>

</body>

</html>
