@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Cliente
          <small>Editar Cliente</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ClienteEditForm"  action="{{route('clientes.update', $cliente)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                    <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código" name="codigo" value="{{old('codigo', $cliente->codigo)}}">
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <label for="tipo_persona_id">Tipo Persona</label>
                                <select name="tipo_persona_id" class="form-control">
                                    @foreach ($tipo_persona as $tp)
                                        @if ($tp->id == $cliente->tipo_persona_id)
                                            <option value="{{$tp->id}}" selected >{{$tp->descripcion}}</option>
                                        @else
                                            <option value="{{$tp->id}}">{{$tp->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombre_comercial">Nombre Comercial</label>
                                <input type="text" class="form-control" name="nombre_comercial" placeholder="Nombre Comercial" value="{{old('nombre_comercial', $cliente->nombre_comercial)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="razon_social">Razón Social:</label>
                                <input type="text" class="form-control" name="razon_social" placeholder="Razón Social:" value="{{old('razon_social', $cliente->razon_social)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="abreviatura">Abreviatura:</label>
                                <input type="text" class="form-control" placeholder="Abreviatura:" name="abreviatura" value="{{old('abreviatura', $cliente->abreviatura)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="nit">NIT:</label>
                                <input type="text" class="form-control" placeholder="NIT:" name="nit" value="{{old('nit', $cliente->nit)}}">
                            </div>
                            <div class="col-sm-4">
                            <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono:" name="telefono" value="{{old('telefono', $cliente->telefono)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="direccion_comercial">Dirección Comercial:</label>
                                <input type="text" class="form-control" placeholder="Dirección Comercial:" name="direccion_comercial" value="{{old('direccion_comercial', $cliente->direccion_comercial)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="prop_replegal">Propietario o Representante Legal:</label>
                                <input type="text" class="form-control" placeholder="Propietario o Representante Legal:" name="prop_replegal" value="{{old('prop_replegal', $cliente->prop_replegal)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombre_contacto">Nombre Contacto:</label>
                                <input type="text" class="form-control" placeholder="Nombre Contacto:" name="nombre_contacto" value="{{old('nombre_contacto', $cliente->nombre_contacto)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="telefono_contacto">Teléfono Contacto:</label>
                                <input type="text" class="form-control" placeholder="Teléfono Contacto:" name="telefono_contacto" value="{{old('telefono_contacto', $cliente->telefono_contacto)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="correo_electronico">Correo Electrónico:</label>
                                <input type="text" class="form-control" placeholder="Correo Electrónico:" name="correo_electronico" value="{{old('correo_electronico', $cliente->correo_electronico)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="lugar_entrega">Lugar de Entrega:</label>
                                <input type="text" class="form-control" placeholder="Lugar Entrega:" name="lugar_entrega" value="{{old('lugar_entrega', $cliente->lugar_entrega)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="vendedor_id">Vendedor Asignado</label>
                                <select name="vendedor_id" class="form-control">
                                    @foreach ($vendedores as $ven)
                                        <option value="{{$ven->id}}">{{$ven->nombres}} {{$ven->apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="limite_credito">Límite de Crédito:</label>
                                <input type="text" class="form-control" placeholder="Límite Crédito:" name="limite_credito" value="{{old('limite_credito', $cliente->limite_credito)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="saldo_actual">Saldo Actual:</label>
                                <input type="text" class="form-control" placeholder="Saldo Actual:" name="saldo_actual" value="{{old('saldo_actual', $cliente->saldo_actual)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="dias_credito">Días de Crédito:</label>
                                <input type="text" class="form-control" placeholder="Dias Crédito:" name="dias_credito" value="{{old('dias_credito', $cliente->dias_credito)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="descuento_autorizado">Descuento Autorizado:</label>
                                <input type="text" class="form-control" placeholder="Descuento Autorizado:" name="descuento_autorizado" value="{{old('descuento_autorizado', $cliente->descuento_autorizado)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cuenta_contable">Cuenta Contable:</label>
                                <input type="text" class="form-control" placeholder="Cuenta Contable:" name="cuenta_contable" value="{{old('cuenta_contable', $cliente->cuenta_contable)}}">
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <label for="fecha_uv">Fecha Ultima Venta:</label>
                                <div class="input-group date" id="fecha_uv">
                                    <input class="form-control" name="fecha_uv" id="fecha_uv" placeholder="Fecha Ultima Venta" value="{{old('fecha_ultima_venta', $cliente->fecha_ultima_venta)}}">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="retenedor_iva">Agente Retenedor IVA</label>
                                <select name="retenedor_iva" class="form-control" value="{{old('retenedor_iva', $cliente->retenedor_iva)}}">
                                        <option value="0">Seleccione una opción</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones" name="observaciones" value="{{old('observaciones', $cliente->observaciones)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonClienteUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')

<script>
    //datepicker settings
    $('#fecha_uv').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

</script>

<script src="{{asset('js/clientes/edit.js')}}"></script>
@endpush
