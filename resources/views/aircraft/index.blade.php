@extends('layouts.base')

@section('content')


<div class="card">
    <div class="card-body">
        <div class="card-title mb-0 d-flex justify-content-between align-items-baseline">
            <h5 class="card-title">
                Approved Aircraft
            </h5>
            <p class="card-title">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAircraftModal">
                    <i class="fas fa-fw mr-2 fa-plus"></i> New Aircraft
                </button>
            </p>
        </div>

        <table class="table table-hover card-text border mb-3">
            <caption>
                Rows in yellow are <strong>pending approval</strong> and cannot be used in flight requests.
            </caption>

            <thead class="thead-light">
                <tr>
                    <th>ICAO Code</th>
                    <th>Name</th>
                    <th>Simulator</th>
                    <th>Added by</th>
                    @role('admin') <th></th> @endrole
                </tr>
            </thead>

            <tbody>
                @forelse($aircrafts as $aircraft)
                    <tr @unless($aircraft->approved) class="table-warning" @endif>
                        <td class="align-middle"><samp>{{ $aircraft->icao }}</samp></td>
                        <td class="align-middle">{{ $aircraft->name }}</td>
                        <td class="align-middle">
                            @switch($aircraft->sim)
                                @case('fsx')
                                    Microsoft Flight Simulator X
                                    @break
                                @case('p3d')
                                    Lockheed Martin Prepar3D v3
                                    @break
                                @case('p4d')
                                    Lockheed Martin Prepar3D v4
                                    @break
                                @case('p5d')
                                    Lockheed Martin Prepar3D v5
                                    @break
                                @case('xp0')
                                    Laminar Research X-Plane 10
                                    @break
                                @case('xp1')
                                    Laminar Research X-Plane 11
                                    @break
                                @case('mfs')
                                    Microsoft Flight Simulator 2020
                                    @break
                            @endswitch
                        </td>
                        <td class="align-middle">
                            {{ $aircraft->added_by ? $aircraft->added_by : 'MultiCrew' }}
                        </td>
                        @role('admin')
                            <td class="text-right">
                                <a href="{{ route('aircraft.show', $aircraft) }}" class="btn btn-primary btn-sm my-0">
                                    View<i class="fas fa-angle-double-right ml-2"></i>
                                </a>
                            </td>
                        @endrole
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No aircraft!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="card-text mb-0">{{ $aircrafts->links() }}</div>
    </div>
</div>

<div
class="modal fade"
id="createAircraftModal"
tabindex="-1"
role="dialog"
aria-labelledby="createAircraftModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('aircraft.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createAircraftModalLabel">Request New Aircraft</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>
                        Add the details of the aircraft you'd like to add below. An administrator will review your
                        request and, if valid, the aircraft will appear in the system soon!
                    </p>

                    <div class="form-group">
                        <h5 class="mb-2"><label>ICAO Code</label></h5>
                        <select
                        name="icao"
                        id="icao"
                        class="selectpicker mt-1 mb-3 form-control {{ $errors->has('icao') ? 'border-danger' : '' }}"
                        data-live-search="true"
                        value="{{ is_null(old('icao')) ? '' : old('icao') }}"></select>

                        @if($errors->has('icao'))
                            <p class="help text-danger">
                                {{ $errors->first('icao') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Name</label></h5>
                        <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}"
                        value="{{ is_null(old('name')) ? '' : old('name') }}"
                        required>
                        @if($errors->has('name'))
                            <p class="help text-danger">
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                        <small class="form-text">Please describe the aircraft addon</small>
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Simulator</label></h5>
                        <select
                        name="sim"
                        id="sim"
                        class="custom-select"
                        required>
                            <option selected disabled value>Choose one...</option>
                            <option value="fsx">Microsoft Flight Simulator X</option>
                            <option value="p3d">Lockheed Martin Prepar3D v3</option>
                            <option value="p4d">Lockheed Martin Prepar3D v4</option>
                            <option value="p5d">Lockheed Martin Prepar3D v5</option>
                            <option value="xp0">Laminar Research X-Plane 10</option>
                            <option value="xp1">Laminar Research X-Plane 11</option>
                            <option value="mfs">Microsoft Flight Simulator 2020</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        Submit <i class="fas fa-angle-double-right fa-fw ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
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
