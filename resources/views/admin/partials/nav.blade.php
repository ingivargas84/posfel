    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Inicio</span></a></li>
               
        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Catalogos Generales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('articulos')? 'active': ''}}"><a href="{{route('articulos.index')}}"> 
              <i class="fa fa-eye"></i>Artículos</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('bodegas')? 'active': ''}}"><a href="{{route('bodegas.index')}}"> 
              <i class="fa fa-eye"></i>Bodegas</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('clientes')? 'active': ''}}"><a href="{{route('clientes.index')}}"> 
              <i class="fa fa-eye"></i>Clientes</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('documentos')? 'active': ''}}"><a href="{{route('documentos.index')}}"> 
              <i class="fa fa-eye"></i>Documentos</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('empresas')? 'active': ''}}"><a href="{{route('empresas.index')}}"> 
              <i class="fa fa-eye"></i>Empresas</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('proveedores.index')}}"> 
              <i class="fa fa-eye"></i>Proveedores</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('series')? 'active': ''}}"><a href="{{route('series.index')}}"> 
              <i class="fa fa-eye"></i>Series</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('vendedores')? 'active': ''}}"><a href="{{route('vendedores.index')}}"> 
              <i class="fa fa-eye"></i>Vendedores</a>
            </li>  
          </ul>

        </li>

        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Abonos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('abonos')? 'active': ''}}"><a href="{{route('abonos.index')}}"> 
              <i class="fa fa-eye"></i>Crear Abono</a>
            </li>  
          </ul>       

        </li>


        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Gestión de Movimientos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('movimientos')? 'active': ''}}"><a href="{{route('movimientos.index')}}"> 
              <i class="fa fa-eye"></i>Crear Movimiento</a>
            </li>  
          </ul>       

        </li>

        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Cotizaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('cotizaciones')? 'active': ''}}"><a href="{{route('cotizaciones.index')}}"> 
              <i class="fa fa-eye"></i>Crear Cotización</a>
            </li>  
          </ul>       
        </li>


        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Facturas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('facturas')? 'active': ''}}"><a href="{{route('facturas.index')}}"> 
              <i class="fa fa-eye"></i>Crear Facturas</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('facturas')? 'active': ''}}"><a href="{{route('facturas.indexexport')}}"> 
              <i class="fa fa-eye"></i>Generar Archivos TXT</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('facturas')? 'active': ''}}"><a href="{{route('facturas.indexv')}}"> 
              <i class="fa fa-eye"></i>Autorizar Facturas Vencidas</a>
            </li>  
          </ul>       

        </li>


        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Ordenes de Compra</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('ordenes_compras')? 'active': ''}}"><a href="{{route('ordenes_compras.index')}}"> 
              <i class="fa fa-eye"></i>Crear Orden de Compra</a>
            </li>  
          </ul>       

        </li>

        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Importaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('importaciones')? 'active': ''}}"><a href="{{route('importaciones.index')}}"> 
              <i class="fa fa-eye"></i>Crear Importación</a>
            </li>  
          </ul>       

        </li>


        <li class="treeview {{request()->is()? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.fac_emitidas')}}"> 
              <i class="fa fa-eye"></i>Facturas Emitidas </a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.lib_ventas')}}"> 
              <i class="fa fa-eye"></i>Libro de Ventas</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.val_inventario')}}"> 
              <i class="fa fa-eye"></i>Valorización de Inventario</a>
            </li>  
          </ul>
          
          <ul class="treeview-menu">
            <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.ant_saldos')}}"> 
              <i class="fa fa-eye"></i>Antigüedad de Saldos</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.ventas_prods')}}"> 
              <i class="fa fa-eye"></i>Ventas de Productos</a>
            </li>  
          </ul>

        </li>



        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-users"></i> <span>Gestion Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('users')? 'active': ''}}"><a href="{{route('users.index')}}"> 
              <i class="fa fa-eye"></i>Usuarios</a>
            </li>

            <li class="{{request()->is('perfiles')? 'active': ''}}"><a href="{{route('perfiles.index')}}"> 
              <i class="fas fa-user-plus"></i> Perfiles de Usuario</a>
            </li> 
            
            <li class="{{request()->is('roles')? 'active': ''}}"><a href="{{route('roles.index')}}"> 
              <i class="fas fa-users-cog"></i> Roles</a>
            </li> 

            <li>
                <a href="#" data-toggle="modal" data-target="#modalResetPassword"><i class="fa fa-lock-open"></i>Cambiar contraseña</a>             
            </li>

          </ul>  

          
            
          

        </li>

<!--
        @role('Super-Administrador|Administrador')

        <li class="treeview {{request()->is('negocio*')? 'active': ''}}">
            <a href="#"><i class="fa fa-building"></i> <span>Mi Negocio</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
  
            <ul class="treeview-menu">
              <li class="{{request()->routeIs('negocio.edit')? 'active': ''}}"><a href="{{route('negocio.edit', 1)}}"> 
                <i class="fa fa-edit"></i>Editar Mi Negocio</a>
              </li>  
            </ul>
        </li>
        @endrole
        
        
    </ul>
    -->

    <!-- /.sidebar-menu -->