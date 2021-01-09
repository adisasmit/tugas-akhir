@extends('adminlte::page')

@section('title', 'Anggaran')

@section('content_header')
<h1>ANGGARAN</h1>
@endsection

@section('content')
<div class="col">
<div class="row text-center pt-3">
    <div class="col">
        <h5>PT. XYZ</h5>
    </div>
</div>
<div class="row text-center pt-1">
    <div class="col">
        <table class="table table-stripped table-condensed table-lg">
        <thead class="thead-light">
            <th style="width: 20%">Kode Proyek</th>
            <th style="width: 20%"></th>
            <th style="width: 15%">1 (Kapal 1)</th>
            <th style="width: 15%">2 (Kapal 2)</th>
            <th style="width: 15%">3 (Kapal 3)</th>
            <th style="width: 15%">Jumlah</th>
        </thead>
        <tbody>
            <tr>
                <td>Pendapatan</td>
                <td></td>
                <td>999.999</td>
                <td></td>
                <td>999.999</td>
                <td>999.999</td>
            </tr>
        </tbody>
        </table>
    </div>
</div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@endsection

@section('js')
<script>
    console.log('Hi!'); 
</script>
@endsection