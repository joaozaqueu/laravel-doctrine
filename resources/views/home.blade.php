@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Notas
                    <a href="#" class="btn btn-primary btn-xs pull-right">Nova nota</a>
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
        console.log(data);
        var	rows = '';
        $.each( data, function( key, value ) {
            rows = rows + '<tr>';
            rows = rows + '<td>'+value.title+'</td>';
            rows = rows + '<td>'+value.description+'</td>';
            rows = rows + '<td>'+formatDate(value.createdAt.date) +'</td>';
            rows = rows + '<td>'+formatDate(value.updatedAt.date)+'</td>';
            rows = rows + '<td data-id="'+value.id+'">';
            rows = rows + '<div class="btn-group">';
            rows = rows + '<button data-toggle="modal" data-target="#edit-client" data-id="'+value.id+'" class="btn btn-primary edit-client"><i class="fa fa-pencil"> </i> Editar</button> ';
            rows = rows + '<button class="btn btn-danger remove-client" data-id="'+value.id+'" ><i class="fa fa-trash"> </i> Deletar</button>';
            rows = rows + '</div>';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });

        console.log(rows);
        $("tbody").html(rows);
    }

    getNotes();
</script>
@endsection
