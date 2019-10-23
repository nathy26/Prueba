@extends('plantilla_principal')
@section('cuerpo')
<script src="{{ asset('js/validate.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script> 

<script>
// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable').DataTable();
});</script>
<!-- Breadcrumbs-->

<!-- Page Content -->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Bibliotecarios
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nro</th><th>Nombre</th><th>Usuario</th><th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listab as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->usuario}}</td>
                        <td>
                            @if($item->estado == true)
                            Activo
                            @else
                            Desactivo
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary">Modificar</a>
                            <a href="{{url('/administrar/bibliotecarios/eliminar/')}}/{{$item->external_id}}" class="btn btn-danger">Dar de Baja</a>
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary" data-toggle="modal" data-target="#saveModalB">Guardar Bibliotecario</a>
        </div>
    </div>
</div>

<!-- Bibliotecario Modal Save-->
<div class="modal fade" id="saveModalB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Registro de Bibliotecarios</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario2" method="POST" action="{{url('/administrar/bibliotecarios/guardar')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="external" id="external" value="0"/>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombres"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Alias"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" id="clave" name="clave" class="form-control" placeholder="Clave"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="botong" class="btn btn-primary btn-block" value="Guardar"/>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
