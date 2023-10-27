<div class="card-body">
    @csrf
    <div class="form-row">
        <div class="form-group col-12 col-md-6">
            <label for="voting_booth_id">Puesto de votación <span class="text-danger">(*)</span></label>
            <select name="voting_booth_id" id="voting_booth_id" class="form-control @error('voting_booth_id') is-invalid @enderror" required>
                <option value="" selected disabled>Seleccionar una opción </option>
                @foreach($votingBooths as $votingBooth)
                    <option value="{{ $votingBooth->id }}"
                            @if( old('voting_booth_id') && old('voting_booth_id') == $votingBooth->id) selected
                            @elseif($votingBooth->id == $record->voting_booth_id) selected @endif
                        data-info="{{ $votingBooth->number_tables }}"
                    >{{ $votingBooth->name }}</option>
                @endforeach
            </select>
            @error('voting_booth_id')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="number_table">Mesa <span class="text-danger">(*)</span></label>
            <select name="number_table" id="number_table" class="form-control @error('number_table') is-invalid @enderror" required>
                <option value="" selected disabled>Seleccionar una opción </option>
                @if(isset($record->id))
                    @for($i = 1; $i < $record->votingBooth->number_tables + 1; $i++)
                        <option value="{{ $i }}"
                                @if( old('number_table') && old('number_table') == $i) selected
                                @elseif($i == $record->number_table) selected @endif
                        >{{ 'Mesa '. $i  }}</option>
                    @endfor
                @endif
            </select>
            @error('number_table')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
    </div>

    @foreach($parties as $party)
            <div class="form-row">
                <div class="col-12 py-3">
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th rowspan="2" scope="col"> {{ $party->name  }}</th>
                                <th scope="row">Candidato</th>
                                @for($i = 1;  $i < ($party->number_candidates + 1); $i++)
                                    <th scope="col"> {{ $i }}</th>
                                @endfor
                            </tr>
                            <tr>
                                <th scope="row">Votos</th>
                                @for($i = 1;  $i < ($party->number_candidates + 1); $i++)
                                    <td>
                                        @php
                                            $name = "votes[$party->id][$i]";
                                            $validate = "votes.$party->id.$i";
                                            $data = $record->votes_cast->isEmpty() || !isset($record->votes_cast[$party->id]) ? [] : $record->votes_cast[$party->id]->pluck('votes', 'number_candidate')->toArray();
                                            // dd($data);
                                        @endphp
                                        <input type="number" name="{{ $name }}" class="form-control" required placeholder="Ingresar cantidad de votos" min="0" step="1"
                                        @if(old($validate)) value="{{ old($validate) }}" @else value="{{ $data[$i] ?? '' }}" @endif>
                                        @error($validate)
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
    @endforeach

</div>
@once
    @push('stack-script')
        <script type="text/javascript">
            'use strict';

            $(document).ready(() => {
                const votingBoothId = $('#voting_booth_id');
                const numberTable = $('#number_table');

                votingBoothId.on('change', function () {
                    let numberTables = $(this).find(':selected').data('info');
                    numberTable.empty();
                    numberTable.append(`<option value="" selected disabled>Seleccionar una opción </option>`);
                    for (let i = 1; i < numberTables + 1; i++) {
                        numberTable.append(`<option value="${i}">${'Mesa ' + i}</option>`);
                    }
                });
            });

        </script>

    @endpush
@endonce
