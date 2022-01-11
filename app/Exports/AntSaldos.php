<?php

namespace App\Exports;

use App\Cliente;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;

class AntSaldos implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $fecha_inicial;
    protected $fecha_final;
    protected $clientes;
    protected $vendedores;

    public function __construct($fecha_inicial = null, $fecha_final = null, $clientes = null, $vendedores = null)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->clientes = $clientes;
        $this->vendedores = $vendedores;

    }


    public function view(): View
    {

        $fecha_inicial = $this->fecha_inicial;
        $fecha_final = $this->fecha_final;
        $clientes = $this->clientes;
        $vendedores = $this->vendedores;


        if ($clientes !== "default")
        {
            $query = "SELECT ser.serie, fm.correlativo_documento AS num, DATE(ecc.created_at) AS fecha, if(DATEDIFF(DATE(NOW()), DATE(ecc.created_at)) <= 30,ecc.saldo,'') AS N1, 
            if(DATEDIFF(DATE(NOW()), DATE(ecc.created_at)) > 30 AND DATEDIFF(DATE(NOW()), DATE(ecc.created_at)) <= 60,ecc.saldo,'') AS N2, 
            if(DATEDIFF(DATE(NOW()), DATE(ecc.created_at)) > 60 AND DATEDIFF(DATE(NOW()), DATE(ecc.created_at)) <= 90,ecc.saldo,'') AS N3,
            if(DATEDIFF(DATE(NOW()), DATE(ecc.created_at)) > 90,ecc.saldo,'') AS N4
            FROM estado_cuenta_cliente ecc
            INNER JOIN factura_maestro fm ON ecc.factura_maestro_id=fm.id
            INNER JOIN series ser ON fm.serie_id=ser.id
            WHERE ecc.cliente_id = " . $clientes . " AND ecc.saldo > 0
            ORDER BY ecc.created_at ASC";
            $datos = DB::Select($query);

            $query2 = "SELECT if(SUM(saldo) IS NULL,0,SUM(saldo)) AS N1
            FROM estado_cuenta_cliente
            WHERE cliente_id = " . $clientes . " AND (DATEDIFF(DATE(NOW()), DATE(created_at)) <= 30)";
            $total1 = DB::Select($query2);


            $query3 = "SELECT if(SUM(saldo) IS NULL,0,SUM(saldo)) AS N2
            FROM estado_cuenta_cliente
            WHERE cliente_id = " . $clientes . " AND (DATEDIFF(DATE(NOW()), DATE(created_at)) > 30 AND DATEDIFF(DATE(NOW()), DATE(created_at)) <= 60)";
            $total2 = DB::Select($query3);
            

            $query4 = "SELECT if(SUM(saldo) IS NULL,0,SUM(saldo)) AS N3
            FROM estado_cuenta_cliente
            WHERE cliente_id = " . $clientes . " AND (DATEDIFF(DATE(NOW()), DATE(created_at)) > 60 AND DATEDIFF(DATE(NOW()), DATE(created_at)) <= 90)";
            $total3 = DB::Select($query4);
        

            $query5 = "SELECT if(SUM(saldo) IS NULL,0,SUM(saldo)) AS N4
            FROM estado_cuenta_cliente
            WHERE cliente_id = " . $clientes . " AND DATEDIFF(DATE(NOW()), DATE(created_at)) > 90";
            $total4 = DB::Select($query5);


            $cliente = Cliente::Where("id",$clientes)->get()->first();

        }


        return view('admin.reportes.rpt_ant_saldos', compact('fecha_inicial','fecha_final','datos','cliente','total1','total2','total3','total4'));
    }
}
