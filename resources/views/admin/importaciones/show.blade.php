@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        IMPORTACIONES
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('importaciones.index')}}"><i class="fa fa-list"></i> Importaciones</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="MovimientoForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de la Importacion</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>No Hoja:</strong> {{$imp_maestro[0]->no_hoja}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>No Pedido:</strong> {{$imp_maestro[0]->no_pedido}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Orden de Compra:</strong>{{$imp_maestro[0]->orden_compra_id}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Fecha:</strong> {{Carbon\Carbon::parse($imp_maestro[0]->fecha)->format('d-m-Y')}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Proveedor:</strong> {{$imp_maestro[0]->nit}}-{{$imp_maestro[0]->proveedor}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Poliza:</strong> {{$imp_maestro[0]->poliza}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>No Factura:</strong> {{$imp_maestro[0]->no_factura}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 col-sm-7">
                        <h4><strong>Tipo Mercadería:</strong> {{$imp_maestro[0]->tipo_mercaderia}} </h4>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <h4><strong>Tipo Transporte:</strong> {{$imp_maestro[0]->tipo_transporte}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3><strong>Descripción de los Gastos CIF</strong></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Valor FOB:</strong> $. {{{number_format((float) $imp_maestro[0]->valor_fob, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Inland/Ocean:</strong> $. {{{number_format((float) $imp_maestro[0]->costo_transporte, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Consular FEES:</strong> $. {{{number_format((float) $imp_maestro[0]->consular_fees, 2) }}} </h4>                        
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>BL/PC:</strong> $. {{{number_format((float) $imp_maestro[0]->bl_pc, 2) }}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Insurance:</strong> $. {{{number_format((float) $imp_maestro[0]->insurance, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Others:</strong> $. {{{number_format((float) $imp_maestro[0]->others, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Handling And PO:</strong> $. {{{number_format((float) $imp_maestro[0]->handling_and_po, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong><u>Total CIF: $. {{{number_format((float) $imp_maestro[0]->total_cif, 2) }}}</u></strong></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 text-left">
                        <h4><strong>Tipo de Cambio:</strong> Q. {{{number_format((float) $imp_maestro[0]->tasa_cambio, 2) }}}</h4>
                    </div>
                    <div class="col-md-6 col-sm-6 text-center">
                        <h4><strong><u>Quetzalización: $. {{{number_format((float) $imp_maestro[0]->quetzalizacion, 2) }}}</u></strong></h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>D Arancelarios:</strong> Q. {{{number_format((float) $imp_maestro[0]->d_arancelarios_imp, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Multas:</strong> Q. {{{number_format((float) $imp_maestro[0]->multas, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Almacenaje:</strong> Q. {{{number_format((float) $imp_maestro[0]->almacenaje_algesa, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Marchamo:</strong> Q. {{{number_format((float) $imp_maestro[0]->marchamo, 2) }}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Muellaje:</strong> Q. {{{number_format((float) $imp_maestro[0]->muellaje, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Fumigación:</strong> Q. {{{number_format((float) $imp_maestro[0]->fumigacion, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>M Documentación:</strong> Q. {{{number_format((float) $imp_maestro[0]->m_documentacion, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Tram Al:</strong> Q. {{{number_format((float) $imp_maestro[0]->tram_al, 2) }}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Hono AA:</strong> Q. {{{number_format((float) $imp_maestro[0]->hono_aa, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Formulario:</strong> Q. {{{number_format((float) $imp_maestro[0]->formulario, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>FL I A/V:</strong> Q. {{{number_format((float) $imp_maestro[0]->fl_i_a_v, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>FL I C/V:</strong> Q. {{{number_format((float) $imp_maestro[0]->fl_i_c_v, 2) }}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>FL CH/BV:</strong> Q. {{{number_format((float) $imp_maestro[0]->fl_ch_bv, 2) }}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>D Monta:</strong> Q. {{{number_format((float) $imp_maestro[0]->d_monta, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Viaticos:</strong> Q. {{{number_format((float) $imp_maestro[0]->viaticos, 2) }}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Otros:</strong> Q. {{{number_format((float) $imp_maestro[0]->otros, 2) }}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong><u>Costo Total Puesto en Bodegas: Q. {{{number_format((float) $imp_maestro[0]->costo_pbod, 2) }}} </u></strong></h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong><u>Factor de Costeo: Q. {{{number_format((float) $imp_maestro[0]->fac_costeo, 2) }}} </u></strong></h4>
                    </div>
                </div>
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=40% style="font-size:15px; text-align:left;">Artículo</th>
                                <th width=20% style="font-size:15px; text-align:center;">Cantidad</th>
                                <th width=20% style="font-size:15px; text-align:right;">FOB</th>
                                <th width=20% style="font-size:15px; text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($imp_detalle as $id)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{$id->codigo_articulo}}-{{$id->codigo_alterno}}-{{$id->articulo}}</td>
                                <td style="font-size:13px; text-align:center;">{{ $id->cantidad }}</td>
                                <td style="font-size:13px; text-align:right;">$. {{{number_format((float) $id->fob, 2) }}}</td>
                                <td style="font-size:13px; text-align:right;">$. {{{number_format((float) $id->subtotal, 2) }}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 text-left">
                                <h4><strong>Usuario que Creó:</strong> {{$imp_maestro[0]->name}} </h4>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <h3><strong>Total:</strong> $. {{{number_format((float) $imp_maestro[0]->total, 2) }}}</h3>
                            </div>
                    </div>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('importaciones.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
