@extends('layouts.master')
@section('main-content')

    <form action="{{  route('parties.update', $party->id)  }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        <div class="card">
            <div class="card-header bg-primary text-white h5">
                Editar partido
            </div>
            @include('pages.parties.form')
            <div class="card-footer text-right">
                <button type="submit" class="btn  btn-primary m-1">Actualizar</button>
                <a href="{{ route('parties.index') }}" class="btn btn-outline-secondary m-1">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
@section('bottom-js')
    @stack('stack-script')
@endsection
