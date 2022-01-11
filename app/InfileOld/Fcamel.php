<?php

namespace App\Infile;

use App\Cliente;
use App\Factura_Maestro;
use App\Factura_Detalle;
use App\FacturaCliente;

class Fcamel{

    public function generarFEL($idFacturaMaestro, $idCliente){
        $facturaMaestro = Factura_Maestro::where('id',$idFacturaMaestro)->first();
        $cliente = Cliente::where('id',$idCliente)->first();
        
        $faccliente = FacturaCliente::where('factura_id',$idFacturaMaestro)->get()->first();

        $facturaDetalle = Factura_Detalle::select(
            'factura_detalle.id',
            'factura_detalle.cantidad',
            'factura_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'factura_detalle.desc_articulo',
            'factura_detalle.subtotal'
        )->join(
            'articulos',
            'factura_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'factura_detalle.factura_maestro_id',
            '=',
            $facturaMaestro->id
        )->get();

        // dd($facturaDetalle);

        //SETUP INFILE
        $INFILE_USUARIO= env('INFILE_USUARIO', '');
        $INFILE_URL_FIRMA=env('INFILE_URL_FIRMA', '');
        $INFILE_URL_CERTIFICA=env('INFILE_URL_CERTIFICA', '');
        $INFILE_LLAVE_FIRMA=env('INFILE_LLAVE_FIRMA', '');
        $INFILE_LLAVE_CERTIFICA=env('INFILE_LLAVE_CERTIFICA', '');

        //Establecer timezone para Guatemala
        date_default_timezone_set('America/Guatemala');

        //DocumentoFel
        $documento_fel = new DocumentoFel();

        //Datos del Emisor
        $datos_emisor = new DatosEmisor();
	    $datos_emisor->setAfiliacionIVA("GEN");
	    $datos_emisor->setCodigoEstablecimiento(1);
	    $datos_emisor->setCodigoPostal("01002");
	    $datos_emisor->setCorreoEmisor(env('EMISOR_CORREO_ELECTRONICO', ''));
	    $datos_emisor->setDepartamento(env('EMISOR_DEPARTAMENTO', ''));
	    $datos_emisor->setMunicipio(env('EMISOR_MUNICIPIO', ''));
	    $datos_emisor->setDireccion(env('EMISOR_DIRECCION', ''));
	    $datos_emisor->setNITEmisor(env('EMISOR_NIT', ''));
	    $datos_emisor->setNombreComercial(env('EMISOR_NOMBRE_COMERCIAL', ''));
	    $datos_emisor->setNombreEmisor(env('EMISOR_NOMBRE', ''));
	    $datos_emisor->setPais("GT");
        //Agregar datos del emisor a Documento FEL
	    $documento_fel->setDatosEmisor($datos_emisor);

        //Datos generales Documento Fel
        $datos_generales = new DatosGenerales();
	    $datos_generales->setCodigoMoneda("GTQ");
        $datos_generales->setFechaHoraEmision(date("c"));
        //$datos_generales->setNumeroAcceso(11111);
        $datos_generales->setTipo("FCAM");
        //Agregar Datos Generales a Documento FEL
        $documento_fel->setDatosGenerales($datos_generales);

        //Datos del Recepctor
        
        if ($facturaMaestro->cliente_id == 0){
        
            $idReceptor =  str_replace ( "-", '', $faccliente->nit);
            $datos_receptor = new DatosReceptor();
            $datos_receptor->setCodigoPostal("01001");
            $datos_receptor->setCorreoReceptor("marvinolalez@gmail.com");
            $datos_receptor->setDepartamento("Guatemala");
            $datos_receptor->setDireccion($faccliente->direccion);
            // $datos_receptor->setIDReceptor($faccliente->nit);
            $datos_receptor->setIDReceptor($idReceptor);
            $datos_receptor->setMunicipio("Guatemala");
            $datos_receptor->setNombreReceptor($faccliente->nombre);
            $datos_receptor->setPais("GT");
            // $datos_receptor->setTipoEspecial("CUI");
            //Agregar Datos del Receptor a Documento FEL
            $documento_fel->setDatosReceptor( $datos_receptor);

            //Agregar Receptor a Documento FEL
            $documento_fel->setDatosReceptor( $datos_receptor);
        
        }else{
            
            $idReceptor =  str_replace ( "-", '', $cliente->nit);
            $datos_receptor = new DatosReceptor();
            $datos_receptor->setCodigoPostal("01001");
            $datos_receptor->setCorreoReceptor("marvinolalez@gmail.com");
            $datos_receptor->setDepartamento("Guatemala");
            $datos_receptor->setDireccion($cliente->direccion_comercial);
            // $datos_receptor->setIDReceptor($cliente->nit);
            $datos_receptor->setIDReceptor($idReceptor);
            $datos_receptor->setMunicipio("Guatemala");
            $datos_receptor->setNombreReceptor($cliente->nombre_comercial);
            $datos_receptor->setPais("GT");
            // $datos_receptor->setTipoEspecial("CUI");
            //Agregar Datos del Receptor a Documento FEL
            $documento_fel->setDatosReceptor( $datos_receptor);

            //Agregar Receptor a Documento FEL
            $documento_fel->setDatosReceptor( $datos_receptor);
            
        }

        //Datos Frases
        $frases = new Frases();
        $frases->setTipoFrase(1);
        $frases->setCodigoEscenario(1);

        //Agregar Frases a Documento FEL
        $documento_fel->setFrases($frases);

        //Detalle Factura
        $granTotal=0;
        $numeroLinea=0;
        $montoGravable=0;
        $montoImpuestos=0;
        $totalImpuestos=0;
        foreach ($facturaDetalle as $item) {
            $numeroLinea++;
            $descripcion =$item->codigo_articulo."-".$item->codigo_alterno."-".$item->desc_articulo;
            $items = new Items();
            $items->setNumeroLinea($numeroLinea);
            $items->setBienOServicio("B");
            $items->setCantidad($item->cantidad);
            $items->setDescripcion($descripcion);
            $items->setDescuento(0);
            $items->setPrecio($item->precio_unitario*$item->cantidad);
            $items->setPrecioUnitario($item->precio_unitario);
            $items->setUnidadMedida("UND");
            $items->setTotal($item->subtotal);
            $montoGravable=Round(($item->subtotal/1.12),2);
            $montoImpuestos=($item->subtotal-$montoGravable);
            $totalImpuestos+=$montoImpuestos;
            $granTotal+=$item->subtotal;

            //Detalle de impuestos
            $impuestos_detalle = new ImpuestosDetalle();
            $impuestos_detalle->setNombreCorto("IVA");
            
          
                $impuestos_detalle->setCodigoUnidadGravable(1);
           

            $impuestos_detalle->setMontoGravable($montoGravable);
            $impuestos_detalle->setMontoImpuesto($montoImpuestos);

            $items->setImpuestosDetalle($impuestos_detalle);
            $documento_fel->setItems($items);
     }
     $total_impuestos = new TotalImpuestos();
     $total_impuestos->setNombreCorto("IVA");
     $total_impuestos->setTotalMontoImpuesto($totalImpuestos);
     $documento_fel->setImpuestosResumen($total_impuestos);

     $totales = new Totales();
     $totales->setGranTotal($granTotal);
     $documento_fel->setTotales($totales);
         

     $abonos = new AbonosFacturaCambiaria();
     $abonos->setNumeroAbono("1");
     $abonos->setFechaVencimiento(date("c"));
     $abonos->setMontoAbono($granTotal);
         
     $complemento_cambiaria = new ComplementoCambiaria();
	 $complemento_cambiaria->setIDComplemento("FacturaCambiaria");
	 $complemento_cambiaria->setNombreComplemento("FacturaCambiaria");
	 $complemento_cambiaria->setURIComplemento("reemplazar_por_uri");
	 $complemento_cambiaria->setAbono($abonos);
	 $documento_fel->setComplementos($complemento_cambiaria);


     $adendas = new Adendas();
     $adendas->setAdenda("Cajero", "Luis Morales");
     $adendas->setAdenda("Lote", "45121");
     $adendas->setAdenda("OrdenCompra", "1041-90");
     $documento_fel->setAdenda($adendas);

    //dd($documento_fel);

      // Generacion del XML
      $generar_xml = new GenerarXml();
      $respuesta = $generar_xml->ToXml($documento_fel);

      //DATOS de conexion
      $conexion = new ConexionServiceFel();
      //$conexion->setUrl("https://certificador.feel.com.gt/fel/certificacion/v2/dte/");
      $conexion->setMetodo("POST");
      $conexion->setContentType("application/xml");
      $conexion->setUsuario("SUPLISA");
      $conexion->setLlave("0E62538ECB6AADA585C52E36B2E90B0D");
      $conexion->setIdentificador("".$idFacturaMaestro."");

      $firma = new FirmaEmisor();
      $xml_firmado = $firma->firmar($respuesta->getXml(), $INFILE_USUARIO, $INFILE_LLAVE_FIRMA);
      

      //Certificacion
      $servicio = new ServicioFel();
      $respuesta_servicio = $servicio->Certificar($conexion, $xml_firmado);

      $errores="";
      foreach ($respuesta_servicio->getDescripcionErrores() as $error) {
        $errores.="[".$error->mensaje_error."] ";
     }

     if(strlen($errores)>0){
        return false;
     }

     $facturaMaestro->fel_fecha_certificacion=$respuesta_servicio->getFecha();
     $facturaMaestro->fel_uuid=$respuesta_servicio->getUuid();
     $facturaMaestro->fel_serie=$respuesta_servicio->getSerie();
     $facturaMaestro->fel_numero=$respuesta_servicio->getNumero();
     $facturaMaestro->fel_xml=$respuesta_servicio->getXmlCertificado();
     $facturaMaestro->save();
     return true;
    }

    public function anularFEL($idFacturaMaestro, $idCliente){
        $facturaMaestro = Factura_Maestro::where('id',$idFacturaMaestro)->first();
        
        $cliente = Cliente::where('id',$idCliente)->first();
        
        $faccliente = FacturaCliente::where('factura_id',$idFacturaMaestro)->get()->first();
        

        $nitEmisor=env('EMISOR_NIT', '');
        $INFILE_USUARIO= env('INFILE_USUARIO', '');
        $INFILE_URL_FIRMA=env('INFILE_URL_FIRMA', '');
        $INFILE_URL_CERTIFICA=env('INFILE_URL_CERTIFICA', '');
        $INFILE_LLAVE_FIRMA=env('INFILE_LLAVE_FIRMA', '');
        $INFILE_LLAVE_CERTIFICA=env('INFILE_LLAVE_CERTIFICA', '');

        // $cliente = Cliente::where('id',$facturaMaestro->id)->select('nit')->first();
        
        if ($idCliente == 0){
            $idReceptor = str_replace ( "-", '', $faccliente->nit);
        
        }else{
            $idReceptor = str_replace ( "-", '', $cliente->nit);
        }
            
            
        date_default_timezone_set('America/Guatemala');

        $conexion = new ConexionServiceFel();
        $conexion->setMetodo("POST");
        $conexion->setContentType("application/xml");
        $conexion->setUsuario("SUPLISA");
        $conexion->setLlave("0E62538ECB6AADA585C52E36B2E90B0D");

        $anulacion_fel = new AnulacionFel();
        $anulacion_fel->setFechaEmisionDocumentoAnular($facturaMaestro->fel_fecha_certificacion);
        $anulacion_fel->setFechaHoraAnulacion(date("c"));
        $anulacion_fel->setIDReceptor($idReceptor);
        $anulacion_fel->setNITEmisor($nitEmisor);
        $anulacion_fel->setMotivoAnulacion("ANULACION DE PRUEBA EN PRODUCCION");
        $anulacion_fel->setNumeroDocumentoAnular($facturaMaestro->fel_uuid);

        $generar_xml = new GenerarXml();
        $respuesta = $generar_xml->ToXml($anulacion_fel);

        $firma = new FirmaEmisor();
        $xml_firmado = $firma->firmar($respuesta->getXml(), $INFILE_USUARIO, $INFILE_LLAVE_FIRMA);

        $servicio = new ServicioFel();
        $respuesta_servicio = $servicio->Certificar($conexion, $xml_firmado);

        $errores="";
        foreach ($respuesta_servicio->getDescripcionErrores() as $error) {
          $errores.="[".$error->mensaje_error."] ";
        }

        if(strlen($errores)>0){
            return false;
         }

        $facturaMaestro->fel_fecha_certificacion_anula=$respuesta_servicio->getFecha();
        $facturaMaestro->fel_uuid_anula=$respuesta_servicio->getUuid();
        $facturaMaestro->fel_serie_anula=$respuesta_servicio->getSerie();
        $facturaMaestro->fel_numero_anula=$respuesta_servicio->getNumero();
        $facturaMaestro->fel_xml_anula=$respuesta_servicio->getXmlCertificado();
        $facturaMaestro->save();
        //dd($respuesta_servicio);
        return true;
    }
}
