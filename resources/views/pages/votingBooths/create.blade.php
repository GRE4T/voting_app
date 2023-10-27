@extends('layouts.master')
@section('main-content')

    <form action="{{  route('voting-booths.store')  }}" method="POST">

        <div class="card">
            <div class="card-header bg-primary text-white h5">
                Añadir nuevo puesto de votación
            </div>
            @include('pages.votingBooths.form')
            <div class="card-footer text-right">
                <button type="submit" class="btn  btn-primary m-1">Guardar</button>
                <a href="{{ route('voting-booths.index') }}" class="btn btn-outline-secondary m-1">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
