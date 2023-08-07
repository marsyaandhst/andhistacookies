@extends('dashboard.v_template')
@section('title', 'Detail Moisturizer')

@section('content')

<table class="table">
    <tr>
        <th width="100px">Id Pesanan</th>
        <th width="30px">:</th>
        <th>{{ $order->id }}</th>
    </tr>
    <tr>
        <th width="100px">Id User</th>
        <th width="30px">:</th>
        <th>{{ $order->id_user }}</th>
    </tr>
    <tr>
        <th width="100px">Nama Penerima</th>
        <th width="30px">:</th>
        <th>{{ $order->namapenerima }}</th>
    </tr>
    <tr>
        <th width="100px">Nama Kue</th>
        <th width="30px">:</th>
        <th>{{ $order->namakue }}</th>
    </tr>
    <tr>
        <th width="100px">Total Item</th>
        <th width="30px">:</th>
        <th>{{ $order->totalitem }}</th>
    </tr>
    <tr>
        <th width="100px">Total Harga</th>
        <th width="30px">:</th>
        <th>{{ $order->totalharga }}</th>
    </tr>
    <tr>
        <th width="100px">alamat</th>
        <th width="30px">:</th>
        <th>{{ $order->alamat }}</th>
    </tr>
    <tr>
        <th width="100px">Bukti Pembayaran</th>
        <th width="30px">:</th>
        <th><img src="{{url('buktipembayaran/',$order->buktipembayaran)}}" width="700px"></th>
    </tr>
    <tr>
        <th><a href="/daftarpesanan" class="btn btn-success btn-sm">Back</a></th>
    </tr>
</table>




@endsection
