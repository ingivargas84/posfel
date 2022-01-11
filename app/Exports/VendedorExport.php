<?php

namespace App\Exports;

use App\Vendedor;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class VendedorExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;


    public function view(): View
    {
        $vendedores = Vendedor::WHERE("id",">",1)->get();

        return view('admin.reportes.rpt_fac_emitidas', compact('vendedores'));
    }
}
