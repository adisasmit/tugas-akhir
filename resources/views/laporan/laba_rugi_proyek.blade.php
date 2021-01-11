@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Laba Rugi Proyek')

@section('content_header')
<h1>LAPORAN LABA RUGI PROYEK</h1>
@endsection

@section('content')
<div class="col">
    <div class="col container">
        <div class="row text-center">
            <div class="col">
                <h5>PT. XYZ</h5>
                <h6>Laporan Anggaran & Realisasi Laba Rugi</h6>
                <h6>Pembangunan Rumah Pak David</h6>
                <div class="row" style="padding-top: 4px; padding-bottom: 12px; padding-left: 10%; padding-right:10%">
                    <div class="center-block" ><input class="date form-control text-center" type="text"></div>
                    <div class="center-block sd" ><h6> s/d </h6></div>
                    <div class="center-block"><input class="date form-control  text-center" type="text"></div>
                </div>
                
            </div>
        </div>
        <div class="row text-center pt-1">
            <div class="col">
                <table id="table1"class="display table table-bordered table-hover dataTable">
                <thead class="thead-light">
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 18%">Anggaran</th>
                    <th style="width: 18%">Realisasi</th>
                    <th style="width: 18%">Selisih</th>
                    <th style="width: 16%">% dari Anggaran</th>
                    <th style="width: 5%">Hasil</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Pendapatan</td>
                        <td>1.350.000.000</td>
                        <td>1.350.000.000</td>
                        <td>0</td>
                        <td>100,00%</td>
                        <td>Up</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .table td,
    .table th
    {
        text-align:left;
    }
    .table td + td,
    .table th + th
    {
        text-align:right
    }
    .col h6
    {
        text-transform: uppercase;
    }
    .center-block {
        display: block;
        margin: auto;
    }
    .form-control {
        width: 160px;
    }
</style>
@endsection

@section('js')
<script type="text/javascript">
    $('.date').datepicker({  
       format: 'dd-mm-yyyy',
       orientation: 'bottom'
     });  
     $(document).ready(function() {
        $('#table1').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false
        });
    } );
</script> 
@endsection