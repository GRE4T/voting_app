<div class="card-body">
    @csrf
    <div class="form-row">
        <div class="form-group col-12 col-md-6">
            <label for="nameserver1">Nombre <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   name="name" id="name"
                   value="{{ old('name') ? old('name') : $votingBooth->name }}"
                    required minlength="3" placeholder="Ingresar nombre de puesto de votación ">
            @error('name')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="number_tables">Numero de mesas <span class="text-danger">(*)</span></label>
            <input type="number" class="form-control @error('number_tables') is-invalid @enderror"
                   name="number_tables" id="number_tables"
                   value="{{ old('number_tables') ? old('number_tables') : $votingBooth->number_tables }}" required min="1" step="1" max="50" placeholder="Ingresar numero de mesas">
            @error('number_tables')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
    </div>
</div>
