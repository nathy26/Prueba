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

<script>
jQuery(function ($) {
$.validator.addMethod("sololetras", function (value, element) {
return this.optional(element) || /^[a-z\-.,()'"\s]+$/i.test(value);
}, "Solo se aceptan letras");

$('.input-number').on('input', function(){ this.value = this.value.replace(/[^0-9]/g,'');});

$("#formulario2").validate({
rules: {
nombre: {
required: true,
        minlength: 3,
        sololetras: true
},

apellido: {
required: true,
        minlength: 3,
        sololetras: true
},
direccion: {
required: true,
        minlength: 3,
        sololetras: true
}

},
        highlight: function (e) {
        $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        success: function (e) {
        $(e).closest('.form-group').removeClass('has-error'); //.addClass('has-info');
        $(e).remove();
        },
        errorPlacement: function (error, element) {
        if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
        var controls = element.closest('div[class*="col-"]');
        if (controls.find(':checkbox,:radio').length > 1)
                controls.append(error);
        else
                error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
        } else if (element.is('.select2')) {
        error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
        } else if (element.is('.chosen-select')) {
        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
        } else {
        error.insertAfter(element.parent());
        }
        }
});
});</script>

<!-- Breadcrumbs-->

<!-- Page Content -->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Cuentas
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nro</th><th>Nombre</th><th>Apellidos</th><th>Cédula</th><th>Dirección</th><th>Nro_Cuenta</th><th>Saldo</th><th>Transacción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listac as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->apellido}}</td>
                        <td>{{$item->cedula}}</td>
                        <td>{{$item->direccion}}</td>
                        <td>{{$item->nro_cuenta }}</td>
                        <td>{{$item->saldo }}</td>
                        <td>
                            <a href="{{url('/administrar/cuentas/depositar/')}}/{{$item->external_id}}" data-toggle="modal" data-target="#deposito" class="btn btn-primary">Depósito</a>
                            <a href="#" data-toggle="modal" data-target="#retiro" class="btn btn-primary">Retiro</a>
                            <a href="{{url('/administrar/transacciones/listar')}}/{{$item->external_id}}" class="btn btn-primary">Listar Transacciones</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary" data-toggle="modal" data-target="#saveModalC">Guardar Cuenta</a>
        </div>
    </div>
</div>

<!-- Bibliotecario Modal Save-->
<div class="modal fade" id="saveModalC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Registro de Cuentas</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario2" method="POST" action="{{url('/administrar/cuentas/guardar')}}">
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
                            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" class="input-number" id="cedula" name="cedula" class="form-control" placeholder="Cédula"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección"/>
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

<!--Deposito Modal-->
<div class="modal fade" id="deposito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Deposito</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario3" method="POST" action="{{url('/administrar/cuentas/depositar/{external}')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="external" id="external" value="0"/>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="nro_cuenta" name="nro_cuenta" class="form-control" placeholder="Nro de Cuenta"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="pin" name="pin" class="form-control" placeholder="Pin"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="number" step="any" id="deposito" name="deposito" class="form-control" placeholder="Depósito"/>
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

<!--Retiro Modal-->
<div class="modal fade" id="retiro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Retiro</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario4" method="POST" action="{{url('/administrar/cuentas/retirar/{external}')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="external" id="external" value="0"/>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="nro_cuenta" name="nro_cuenta" class="form-control" placeholder="Nro de Cuenta"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="pin" name="pin" class="form-control" placeholder="Pin"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="number" step="any" id="retiro" name="retiro" class="form-control" placeholder="Retiro"/>
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
