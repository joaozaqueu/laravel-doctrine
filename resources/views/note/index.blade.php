@extends('layouts.app')

@section('content')
    @include('note.create')

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edit-note">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Nova Nota</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="note-submit">Salvar</button>
                </div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Minhas Notas
                    <a href="#" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#gridSystemModal">
                        <i class="glyphicon glyphicon-plus"></i> Nova Nota </a>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-responsive">
                        <thead>
                            <th>Titulo</th>
                            <th>Descrição</th>
                            <th>Criado</th>
                            <th>Atualizado</th>
                            <th>Ações</th>
                        </thead>
                        <tbody id="note-list">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function getNotes() {
        $.ajax({
            method: 'GET',
            url: '{{ route('note.index') }}',
            success: function (data) {
                manageRow(data);
            }
        })
    }

    function formatDate(date) {
        return new Date(date).toLocaleDateString();
    }

    function manageRow(data) {
        var	rows = '';
        $.each( data, function( key, value ) {

            var edit_url = ('{{ route('note.edit', ['id' => '_id_']) }}').replace('_id_', value.id);

            rows = rows + '<tr>';
            rows = rows + '<td>'+value.title+'</td>';
            rows = rows + '<td>'+value.description+'</td>';
            rows = rows + '<td>'+formatDate(value.createdAt.date) +'</td>';
            rows = rows + '<td>'+formatDate(value.updatedAt.date)+'</td>';
            rows = rows + '<td data-id="'+value.id+'">';
            rows = rows + '<div class="btn-group">';
            rows = rows + '<a href="#" data-target="#modal-edit-note" data-url="'+edit_url+'" class="btn btn-primary edit-note"><i class="fa fa-pencil"> </i> Editar</a> ';
            rows = rows + '<button class="btn btn-danger remove-client" data-id="'+value.id+'" ><i class="fa fa-trash"> </i> Deletar</button>';
            rows = rows + '</div>';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });
        $("tbody").html(rows);
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#note-submit").click(function(e) {
        e.preventDefault();
        var form_action = $("#create-note").attr("action");
        var title = $("input[name='title']").val();
        var description = $("textarea[name='description']").val();

        var data = {
            title:title,
            description:description
        }

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data: data,
            complete: function (xhr) {
                if (xhr.status === 200) {
                    toastr.success('Nota cadastrada com sucesso.', 'Sucesso', {timeOut: 5000});
                } else {
                    toastr.error('Erro no cadastro da nota.', 'Erro', {timeOut: 5000});
                }
                $(".modal").modal('hide');
                getNotes();
                $("#create-note").trigger('reset');
            }
        })
    });

    $(".edit-note").click(function(e) {

        alert('teste');
        var url = $(this).data('url');

        $('#modal-edit-note').modal('show');
        /*if (url) {
            $.ajax({
                url: url,
                method: 'get',
                complete: function (xhr) {
                    content_accounts.html(xhr.responseText);
                }
            });
        } else {
            content_accounts.html('<h2> Erro ao selecionar Integrador</h2>');
        }*/
    });


    getNotes();
</script>
@endsection
