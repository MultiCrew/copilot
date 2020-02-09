@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-secondary float-right">
            <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Flight Details
        </a>
        <h3 class="card-title">Flight Plan @if($review) Review @endif</h3>
        <p class="lead text-muted">
            Flight {{ $fpl['general']['icao_airline'].$fpl['general']['flight_number'] }}
            from {{ $fpl['origin']['iata_code'] }} ({{ $fpl['origin']['name'] }})
            to {{ $fpl['destination']['iata_code'] }} ({{ $fpl['destination']['name'] }})
        </p>
        <p class="card-text">
            @if($review)
                Your draft OFP has been generated. Both pilots are required to review and
                accept the flight plan before cockpit preparation can begin.
            @else
                Your OFP is ready to use! Enjoy your flight.
            @endif
        </p>
    </div>
</div>

@if($review)
    <div class="alert alert-danger mb-4">
        <strong>Do not operate with this flight plan!</strong>
        Please review and choose "Accept" or "Reject" at the bottom of this page.
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">General</h5>

                <div class="card-text">
                    <div class="form-row">
                        <div class="col-md-4 form-group card-text">
                            <label>Planned with</label>
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="AIRAC {{ $fpl['params']['airac'] }}"></pre>
                        </div>

                        <div class="col-md-4 form-group card-text">
                            <label>Flight Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ $fpl['general']['icao_airline'] }}</span>
                                </div>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['general']['flight_number'] }}"
                                size="9">
                            </div>
                        </div>

                        <div class="col-md-4 form-group card-text">
                            <label>Callsign</label>
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['atc']['callsign'] }}"></pre>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 form-group card-text">
                            <label>ADEP</label>
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['origin']['icao_code'].' / '.$fpl['origin']['iata_code'] }}"></pre>
                        </div>

                        <div class="col-md-4 form-group card-text">
                            <label>ADES</label>
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['destination']['icao_code'].' / '.$fpl['destination']['iata_code'] }}"></pre>
                        </div>

                        <div class="col-md-4 form-group card-text">
                            <label>ALTN</label>
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['alternate']['icao_code'].' / '.$fpl['alternate']['iata_code'] }}"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Routing</h5>
                <div class="card-text">
                    <div class="form-group card-text">
                        <label>ATC Route</label>
                        <pre class="card-text"><textarea class="form-control card-text" readonly rows="3">{{ $fpl['atc']['route'] }}</textarea></pre>
                    </div>

                    <div class="form-group card-text">
                        <label>ATC Remarks</label>
                        <pre class="card-text"><textarea class="form-control card-text" readonly rows="3">{{ $fpl['atc']['section18'] }}</textarea></pre>
                    </div>

                    <div class="form-row">
                        <div class="form-group card-text col-lg-4">
                            <label>Cruise System</label>
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['general']['cruise_profile'] }}"></pre>
                        </div>

                        <div class="form-group card-text col-lg-4">
                            <label>Fuel Burn</label>
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['general']['total_burn'] }}"></pre>
                        </div>

                        <div class="form-group card-text col-lg-4">
                            <label>Init CRZ Alt</label>
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['general']['initial_altitude'] }}"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Fuel Figures</h5>

                <div class="card-text">
                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Units</label>
                        <div class="col-md-6">
                            <input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ strtoupper($fpl['params']['units']) }}">
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Block / Max</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['fuel']['plan_ramp'] }} / {{ $fpl['fuel']['max_tanks'] }}"></pre>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Burn</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['fuel']['enroute_burn'] }}"></pre>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Landing</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['fuel']['plan_landing'] }}"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Aircraft</h5>

                <div class="card-text">
                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">ICAO</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['aircraft']['icaocode'] }}"></pre>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Type</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['aircraft']['name'] }}"></pre>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Registration</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['aircraft']['reg'] }}"></pre>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">PAX</label>
                        <div class="col-md-6">
                            <pre class="card-text"><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['general']['passengers'] }} / {{ $fpl['aircraft']['max_passengers'] }}"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Crew</h5>

                <div class="card-text">
                    <div class="form-group card-text row mb-2">
                        <label class="col-md-4 col-form-label">OFP by</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control card-text" readonly value="{{ $fpl['crew']['cpt'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Weights</h5>

        <div class="card-text">
            <div class="form-row">
                <div class="form-group card-text col-md-3">
                    <label>PAX</label>
                    <pre class="card-text"><input
                    type="text"
                    class="form-control card-text"
                    readonly
                    value="{{ $fpl['weights']['pax_count'] }} / {{ $fpl['aircraft']['max_passengers'] }}"></pre>
                </div>

                <div class="form-group card-text col-md-3">
                    <label>Est. ZFW / Max</label>
                    <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['weights']['est_zfw'] }} / {{ $fpl['weights']['max_zfw'] }}"></pre>
                </div>

                <div class="form-group card-text col-md-3">
                    <label>Est. TOW / Max</label>
                    <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['weights']['est_tow'] }} / {{ $fpl['weights']['max_tow'] }}"></pre>
                </div>

                <div class="form-group card-text col-md-3">
                    <label>Est. LAW / Max</label>
                    <pre class="card-text"><input type="text" class="form-control card-text" readonly value="{{ $fpl['weights']['est_ldw'] }} / {{ $fpl['weights']['max_ldw'] }}"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Paperwork Preview</h5>

        <p class="card-text text-danger mb-2 text-center"><strong>DRAFT PLAN! Not operational paperwork.</strong></p>
        <div class="card-text border rounded mx-auto" style="width: 1200px; height:600px; overflow:auto;">
            <pre class="card-text">{{ strip_tags($fpl['text']['plan_html'].'<br>') }}</pre>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        @if($review)
            <h5 class="card-title">Review</h5>

            <div class="card-text">
                <p>
                    Please select one of the following options to indicate whether you have reviewed,
                    and are happy to continue with, the <strong>draft</strong> flight plan detailed above.
                </p>
                <p>
                    Upon accepting the flight plan, and providing your copilot also accepts the flight plan,
                    a PDF document of the plan, and other export options, will become available on this page.
                </p>
                <p>
                    If either you or your copilot reject this <strong>draft</strong> flight plan, this draft will
                    be permanently deleted and you will be able to create a new draft.
                </p>

                <div class="text-center card-text">
                    <button type="submit" name="accept" value="true" class="btn btn-success btn-block card-text">
                        <i class="fas fa-5x fa-check"></i><br>Accept
                    </button>
                    <button type="submit" name="reject" value="true" class="btn btn-danger btn-block card-text">
                        <i class="fas fa-5x fa-times"></i><br>Reject
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
