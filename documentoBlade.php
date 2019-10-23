@extends('plantilla_principal')
@section('cuerpo')
<script src="{{ asset('js/validate.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script> 

<script>
// Call the dataTables jQuery plugin
$(document).ready(function () {
$('#dataTable1').DataTable();
});</script>
<!-- Breadcrumbs-->

<!-- Page Content -->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Documentos
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nro</th><th>Título</th><th>Autor</th><th>Año</th><th>Tipo</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listad as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->titulo}}</td>
                        <td>{{$item->autor}}</td>
                        <td>{{$item->anio}}</td>
                        <td>{{$item->tipo}}</td>
                        <td>
                            @if($item->estado == true)
                            Activo
                            @else
                            Desactivo
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary">Modificar</a>
                            <a href="{{url('/administrar/documentos/eliminar/')}}/{{$item->external_id}}" class="btn btn-danger">Dar de Baja</a>
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary" data-toggle="modal" data-target="#saveModalD">Guardar Documento</a>
        </div>
    </div>
</div>

<!-- Documento Modal Save-->
<div class="modal fade" id="saveModalD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Registro de Documentos</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario2" method="POST" action="{{url('/administrar/documentos/guardar')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="external" id="external" value="0"/>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Titulo"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="autor" name="autor" class="form-control" placeholder="Autor"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="anio" name="anio" class="form-control" placeholder="Año"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="message-text" class="col-form-label">Seleccione Tipo De Documento: </label>
                            <select id="tipo" name="tipo">
                                <option value="Libro" selected="true" >Libro</option>
                                <option value="Tesis">Tesis</option>
                                <option value="Revista">Revista</option>
                            </select>
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
