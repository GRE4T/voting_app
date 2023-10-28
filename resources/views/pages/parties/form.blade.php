<div class="card-body">
    @csrf
    <div class="form-row">
        <div class="form-group col-12 col-md-6">
            <label for="nameserver1">Nombre <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   name="name" id="name"
                   value="{{ old('name') ? old('name') : $party->name }}"
                    required minlength="3" placeholder="Ingresar nombre de puesto de votación ">
            @error('name')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="number_candidates">Numero de candidatos <span class="text-danger">(*)</span></label>
            <input type="number" class="form-control @error('number_candidates') is-invalid @enderror"
                   name="number_candidates" id="number_candidates"
                   value="{{ old('number_candidates') ? old('number_candidates') : $party->number_candidates }}" required min="1" step="1" max="50" placeholder="Ingresar numero de mesas">
            @error('number_candidates')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
        <div class="form-group col-12">
            <label class="" for="image"><i class="i-File-Text--Image text-16 mr-1"></i>Imagen</label>
            <div class="p-0 border">
                <div style="height: 230px;" class="d-flex justify-content-center my-2">
                    <img id="image" class="border img-fluid w-20"  src="{{ asset($party->image) }}" alt="image" />
                </div>
                <label class="btn border btn-block mb-0 text-30 text-primary">
                    <input id="image" name="image" data-info="image" type="file"  onchange="readImage(event)" >
                </label>
            </div>
            @error('image')
            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
    </div>
</div>
@once
    @push('stack-script')
        <script type="text/javascript">
            'use strict';

            function readImage(event) {
                let input = event.target;
                let id = $(input).data("info");
                let element = $(`#${id}`);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        element.attr("src", e.target.result);
                        element.removeClass("w-20");
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endonce
