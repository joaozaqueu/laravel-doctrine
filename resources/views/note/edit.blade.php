<div class="row">
    <form id="edit-note" action="{{ route('note.update') }}">
        {!! csrf_field() !!}
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                    <input type="text" class="form-control" name="title" placeholder="Titulo" value="{{ $note['title'] }}">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-reorder"></i></span>
                    <textarea class="form-control" name="description" placeholder="Descrição">{{ $note['description'] }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>
