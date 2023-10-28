@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <ul class="d-flex align-items-center">
            <li class="text-center">
                <img src="{{asset('assets/images/icons/votes.png')}}" alt="" class="w-75">
            </li>
            <li class="h3 bold">Modulo de votación</li>
        </ul>
    </div>
    <div class="row mb-2">
        <div class="col text-right">
            <button id="download_report" class="btn btn-success">Descargar <i class="nav-icon i-Download1 font-weight-bold"></i></button>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white h5">
            Consolidado - <strong>Puesto:</strong> {{ $record->votingBooth->name }} -
            <strong>Mesa:</strong> {{ $record->number_table }}
        </div>
        <div class="card-body" >
            <div class="row justify-content-end">
                <div class="col-12">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body p-1 text-center justify-content-center align-items-center">
                            <i class="i-Financial mr-2 text-primary"></i>
                            <p class="lead text-primary text-24 mb-2"><strong class="font-weight-bold">Total de votos: </strong> {{ $record->votes->sum('votes') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($parties as $party)
                <div class="col-12 py-3">
                    <div class="table-responsive ">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th rowspan="2" scope="col">
                                    <span class="mb-1 d-block">{{ $party->name  }}</span>
                                    <img src="{{ asset($party->image) }}" alt="" class="img-fluid party-image">
                                </th>
                                <th scope="row">Candidato</th>
                                @for($i = 1;  $i < ($party->number_candidates + 1); $i++)
                                    <th scope="col" class="vote-column"> {{ $i }}</th>
                                @endfor
                            </tr>
                            <tr>
                                <th scope="row">Votos</th>
                                @for($i = 1;  $i < ($party->number_candidates + 1); $i++)
                                    <td>
                                        @php
                                            $data = $record->votes_cast->isEmpty() || !isset($record->votes_cast[$party->id]) ? [] : $record->votes_cast[$party->id]->pluck('votes', 'number_candidate')->toArray();
                                        @endphp
                                        {{ $data[$i] ?? 0 }}
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('page-css')
    <style>
        @media print {
            .main-header, .side-content-wrap, #download_report {
                display: none !important;
            }
        }
    </style>
@endsection
@section('bottom-js')
    <script type="text/javascript">
        'use strict';

        $(document).ready(() => {
            $('#download_report').on('click', () => {
                window.print();
            });
        });
    </script>
@endsection
