<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
<style>
    #back-warp {
        margin: 30px auto 0 auto;
        width: 500px;
        display: flex;
        justify-content: flex-end;
    }
    .btn-back {
        width: fit-content;
        padding: 8px 15px;
        color: #fff;
        background-color: #6b6e72;
        border-radius: 5px;
        text-decoration: none;
    }
    #receipt {
        box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.5);
        padding: 20px;
        margin: 30px auto 0 auto;
        width: 500px;
        background: #fff;
    }

    h2 {
        font-size: .9rem;
    }

    p{
        font-size: .8rem;
        color: #666;
        line-height: 1.2rem;
    }

    #top{
        margin: top25px;
    }

    #top .info {
        text-align: left;
        margin: 20px 0;
    }

    table {
        width: 100px;
        border-collapse: collapse;
    }

    td {
        padding: 5px 0 px 15px;
        border: 1px solid #EEE;
    }

    .tabletittle {
        font-size: .5rem;
        background: #EEE;
    }

    .service {
        border-bottom: 1px solid #EEE;
    }

    .itemtext {
        font-size: .7rem;
    }

    #legacopy {
        margin-top: 15px;
    }

    .btn-print {
        float: right;
        color: #333;
    }

</style>
</head>
<body>
    <div id="back-wrap">
        <a href="{{ route('kasir.order.print') }}" class="btn-back">Kembali</a>
    </div>
    <div id="receipt">
        <a href="" class="btn-print"> Cetak (.pdf)</a>
            <center id="top">
                <div class="info">
                    <h2> Apotek SA </h2
                </div>
            </center>
            <div id="mid">
                <div class="info">
                    <p>
                        Alamat : Jalan Sinar Kasih</br>
                        Email : apotekSA@gmail.com</br>
                        Phone : 08123456789</br>
                    </p>
                </div>
            </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletittle">
                        <td class="item">
                            <h2>Obat</h2>
                        </td>
                        <td class="item">
                            <h2>Total</h2>
                        </td>
                        <td class="item">
                            <h2>Harga</h2>
                        </td>
                    </tr>
                    @foreach (@order['medicines'] as $medicine )
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['name_medicine'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['qry'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext"> Rp. {{ number_format($medicine['price'], 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletittle">
                        <td></td>
                        <td class="Rate">
                            <h2>PPN (10%)</h2>
                        </td>
                        @php
                            $ppn =$order['total_price'] * 0.01;
                        @endphp
                        <td class="payment">
                            <h2>Rp. {{ number_format($ppn, 0, ',', '.') }}</h2>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="legacopy">
                <p class="legal"><strong> Terimakasih  atas pembelian Anda!
            </div>
        </div>
    </div>
    </body>
</html>
