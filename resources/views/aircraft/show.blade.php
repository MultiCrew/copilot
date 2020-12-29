@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="card-title mb-0 d-flex justify-content-between align-items-baseline">
            <h5 class="card-title">
                Approved Aircraft
            </h5>
            <p class="card-title">
                <a href="{{ route('aircraft.index') }}" class="btn btn-secondary">
                    <i class="fas mr-2 fa-angle-double-left"></i>Back
                </a>
            </p>
        </div>

        <form method="POST" action="{{ route('aircraft.update', $aircraft) }}">
            @method('PATCH')
            @csrf

            <div class="form-group card-text">
                <h5 class="mb-2"><label>ICAO Code</label></h5>
                <select
                name="icao"
                id="icao"
                class="selectpicker mt-1 mb-3 form-control {{ $errors->has('icao') ? 'border-danger' : '' }}"
                data-live-search="true">
                    <option value="{{ $icao_acft->icao }}" selected>{{ $icao_acft->name }}</option>
                </select>

                @if($errors->has('icao'))
                    <p class="help text-danger">
                        {{ $errors->first('icao') }}
                    </p>
                @endif
            </div>

            <div class="form-group card-text">
                <h5 class="mb-2"><label>Name</label></h5>
                <input
                type="text"
                name="name"
                id="name"
                class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}"
                value="{{ is_null(old('name')) ? $aircraft->name : old('name') }}"
                required>
                @if($errors->has('name'))
                    <p class="help text-danger">
                        {{ $errors->first('name') }}
                    </p>
                @endif
                <small class="form-text">Please describe the aircraft addon</small>
            </div>

            <div class="form-group card-text">
                <h5 class="mb-2"><label>Simulator</label></h5>
                <select name="sim" id="sim" class="custom-select" required>
                    @foreach ($simulators as $simulator)
                        <option value="{{ $simulator->id }}" @if($aircraft->sim === $simulator->id) selected @endif>
                            {{ $simulator->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" name="action" value="edit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Save
            </button>

            @if(Auth::user()->hasRole('admin') && !$aircraft->approved)
                <button type="submit" name="action" value="approve" class="btn btn-success">
                    <i class="fas fa-check mr-2"></i>Approve
                </button>
            @endif
        </form>

        @if(Auth::user()->hasRole('admin') || $aircraft->added_by === Auth::user()->username)
            <form method="POST" action="{{ route('aircraft.destroy', $aircraft) }}" class="mt-3">
                @method('DELETE')
                @csrf

                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt mr-2"></i>Delete
                </button>
            </form>
        @endif
    </div>
</div>

@endsection

@push('append-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.5/js/ajax-bootstrap-select.min.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: '{{ route('search.aircraft') }}',
            method: 'GET',
            data: {
                q: '@{{{q}}}'
            }
        },
        locale: {
            emptyTitle: 'Start typing to search...',
            statusInitialized: '',
        },
        preprocessData: function(data){
            var aircraft = [];
            let count;
            if(data.length > 0){
                if(data.length >= 10) {
                    count = 10;
                } else {
                    count = data.length;
                }
                for(var i = 0; i < count; i++){
                    var curr = data[i];
                    aircraft.push(
                        {
                            'value': curr.icao,
                            'text': curr.icao + ' - ' + curr.name,
                            'disabled': false
                        }
                    );
                }
            }
            return aircraft;
        },
        preserveSelected: true
    });

    $(document).ready(function() {
        $('.pagination').addClass(['mb-0', 'card-text']);
    });
</script>

@endpush
