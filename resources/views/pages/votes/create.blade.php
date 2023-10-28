@extends('layouts.master')
@section('main-content')

    <form action="{{  route('records.store')  }}" method="POST" enctype="multipart/form-data">

        <div class="card">
            <div class="card-header bg-primary text-white h5">
                Añadir nueva votación
            </div>
            @include('pages.votes.form')
            <div class="card-footer text-right">
                <button type="submit" class="btn  btn-primary m-1">Guardar</button>
                <a href="{{ route('records.index') }}" class="btn btn-outline-secondary m-1">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
@section('bottom-js')
    @stack('stack-script')
@endsection
