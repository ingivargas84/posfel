@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Ordenes de Compra
      <small>Todas las ordenes de compra</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Ordenes de Compra</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('ordenes_compras.new')}}">
        <i class="fa fa-plus"></i>Agregar Orden de Compra</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="ordenes_compras-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      ordenes_compras_table.ajax.url("{{route('ordenes_compras.getJson')}}").load();
    });

  </script>
  <script src="{{asset('js/ordenes_compras/index.js')}}"></script>
@endpush