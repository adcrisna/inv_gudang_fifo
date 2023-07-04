<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Data Laporan Keluar/Masuk Barang</title>
    <style account="text/css">
        @font-face {
            font-family: SourceSansPro;
            src: url(SourceSansPro-Regular.ttf);
        }

        .watermark {
            position: fixed;
            bottom: 0px;
            margin-left: -45px;
            margin-bottom: -45px;
            right: 0px;
            width: 1130px;
            height: 1500px;
            z-index: -1;
        }

        .container {
            padding: 0.01em;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            /* font-size: 15px; */
            position: relative;
            /*width: 21cm; */
            /*height: 29.7cm; */
            margin: 0 auto;
            color: black;
            background: #FFFFFF;
            /* font-family: Arial, sans-serif; */
            font-style: normal;
            font-weight: normal;
            font-size: 9.3pt;
            font-family: Cambria Math;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
        }

        #logo {
            /* float: left; */
            margin-top: 8px;
        }

        /* #logo img {
      height: 70px;
    } */

        #company {
            /*float: right;*/
            text-align: right;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;

            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            /*float: right;*/
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.0em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 5px;
        }

        table th {
            padding: 5px;
            /* background: #EEEEEE; */
            text-align: center;
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }

        table td {
            padding: 10px;
            /* background: #EEEEEE; */
            text-align: center;
            border-bottom: 1px solid black;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }

        table td {
            text-align: center;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {}

        table .total {
            background: #21224E;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child th {
            border: 1px solid black;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }

        table tfoot th {
            padding: 5px 5px;
            background: #FFFFFF;
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            font-size: 1.2em;
            white-space: nowrap;
        }

        table tfoot tr:first-child th {
            border-top: 1px solid black;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;

        }

        table tfoot tr:last-child th {
            color: #ffffff;
            background-color: #ffffff;
            /*font-size: 1.5em;*/
            /* border-top: 1px solid #57B223; */

        }

        table tfoot tr th:first-child {
            border: 1px solid black;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {

            width: 100%;
            height: 30px;
            position: relative;
            top: 80px;
            padding: 8px 0;
            text-align: center;
        }

        .info {
            padding: 10px !important;
        }

        .indent {
            text-indent: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <center>
            <h3>Laporan Data Barang : {{ $product->name }}</h3>
        </center>
        <table>

            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Status</th>
                <th colspan="3">Masuk</th>
                <th colspan="3">Keluar</th>
                <th colspan="3">Sisa</th>
            </tr>
            <tr>
                <th>Qty</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
            <tbody style="font-family: Calibri, sans-serif; font-size:14px;">
                @php
                    $dataMasuk = 0;
                    $dataKeluar = 0;
                    $firstStok = $first->jumlah;
                @endphp
                <tr>
                    <th>{{ date('d-m-Y', strtotime($first->created_at)) }}</th>
                    <th>{{ $first->status }}</th>
                    @if ($first->status == 'Masuk')
                        <th>{{ $first->jumlah }}</th>
                        <th>Rp.{{ number_format($first->harga, 0, ',', '.') }}</th>
                        <th>Rp.{{ number_format($first->jumlah * $first->harga, 0, ',', '.') }}</th>
                    @else
                        <th></th>
                        <th></th>
                        <th></th>
                    @endif
                    @if ($first->status == 'Keluar')
                        <th>{{ $first->jumlah }}</th>
                        <th>Rp.{{ number_format($first->harga, 0, ',', '.') }}</th>
                        <th>Rp.{{ number_format($first->jumlah * $first->harga, 0, ',', '.') }}</th>
                    @else
                        <th></th>
                        <th></th>
                        <th></th>
                    @endif
                    @if ($first->status == 'Masuk')
                        <th>{{ $first->jumlah }}</th>
                        <th>Rp.{{ number_format($first->harga, 0, ',', '.') }}</th>
                        <th>Rp.{{ number_format($first->jumlah * $first->harga, 0, ',', '.') }}</th>
                    @elseif ($first->status == 'Keluar')
                        <th>{{ $first->jumlah }}</th>
                        <th>Rp.{{ number_format($first->harga, 0, ',', '.') }}</th>
                        <th>Rp.{{ number_format($first->jumlah * $first->harga, 0, ',', '.') }}</th>
                    @endif
                </tr>
                @php
                    $jumlah = $first->jumlah;
                @endphp
                @foreach ($laporan as $key => $value)
                    @if (!$loop->first)
                        <tr>
                            <th>{{ date('d-m-Y', strtotime($value->created_at)) }}</th>
                            <th>{{ $value->status }}</th>
                            @if ($value->status == 'Masuk')
                                <th>{{ $value->jumlah }}</th>
                                <th>Rp.{{ number_format($value->harga, 0, ',', '.') }}</th>
                                <th>Rp.{{ number_format($value->jumlah * $value->harga, 0, ',', '.') }}</th>
                                @php
                                    $dataMasuk = $jumlah + $value->jumlah;
                                    $jumlah = $jumlah + $value->jumlah;
                                @endphp
                            @else
                                <th></th>
                                <th></th>
                                <th></th>
                            @endif
                            @if ($value->status == 'Keluar')
                                <th>{{ $value->jumlah }}</th>
                                <th>Rp.{{ number_format($value->harga, 0, ',', '.') }}</th>
                                <th>Rp.{{ number_format($value->jumlah * $value->harga, 0, ',', '.') }}</th>
                                @php
                                    $dataKeluar = $jumlah - $value->jumlah;
                                    $jumlah = $jumlah - $value->jumlah;
                                    
                                @endphp
                            @else
                                <th></th>
                                <th></th>
                                <th></th>
                            @endif
                            @if ($value->status == 'Masuk')
                                <th>{{ $dataMasuk }}</th>
                                <th>Rp.{{ number_format($value->harga, 0, ',', '.') }}</th>
                                <th>Rp.{{ number_format($dataMasuk * $value->harga, 0, ',', '.') }}</th>
                            @elseif ($value->status == 'Keluar')
                                <th>{{ $dataKeluar }}</th>
                                <th>Rp.{{ number_format($value->harga, 0, ',', '.') }}</th>
                                <th>Rp.{{ number_format($dataKeluar * $value->harga, 0, ',', '.') }}</th>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @php
            $pembelian = 0;
            $pemakaian = 0;
        @endphp
        @foreach ($laporan as $key => $value)
            @if ($value->status == 'Masuk')
                @php
                    $pembelian = $pembelian + $value->jumlah;
                @endphp
            @elseif ($value->status == 'Keluar')
                @php
                    $pemakaian = $pemakaian + $value->jumlah;
                @endphp
            @endif
        @endforeach
        <h3><b>Jumlah Pembelian</b> : {{ $pembelian }}</h3>
        <h3><b>Jumlah Pemakaian</b> : {{ $pemakaian }}</h3>
        <h3><b>Sisa Akhir</b> : {{ $pembelian - $pemakaian }}</h3>
    </div>
</body>

</html>
