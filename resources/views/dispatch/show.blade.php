@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="float-right">
            @if(url()->previous() == env('APP_URL').'/dispatch')
                <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-info">
                    Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                </a>
            @endif

            <a class="btn btn-secondary" href="{{ url()->previous() }}">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </div>

        <h3 class="card-title">Flight Plan @if(!$plan->isApproved()) Review @endif</h3>
        <p class="lead text-muted">
            Flight {{ $fpl['general']['icao_airline'].$fpl['general']['flight_number'] }}
            from {{ $fpl['origin']['iata_code'] }} ({{ $fpl['origin']['name'] }})
            to {{ $fpl['destination']['iata_code'] }} ({{ $fpl['destination']['name'] }})
        </p>
        <p class="card-text">
            @if($plan->isApproved())
                Your OFP is ready to use! Enjoy your flight.
            @else
                Your draft OFP has been generated. Both pilots are required to review and
                accept the flight plan before cockpit preparation can begin.
            @endif
        </p>
    </div>
</div>

@if(!$plan->isApproved())
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
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="AIRAC {{ $fpl['params']['airac'] }}"></code>
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
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['atc']['callsign'] }}"></code>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 form-group card-text">
                            <label>ADEP</label>
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['origin']['icao_code'].' / '.$fpl['origin']['iata_code'] }}"></code>
                        </div>

                        <div class="col-md-4 form-group card-text">
                            <label>ADES</label>
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['destination']['icao_code'].' / '.$fpl['destination']['iata_code'] }}"></code>
                        </div>

                        <div class="col-md-4 form-group card-text">
                            <label>ALTN</label>
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['alternate']['icao_code'].' / '.$fpl['alternate']['iata_code'] }}"></code>
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
                        <code>
                            <textarea class="form-control card-text" readonly rows="3">{{ $fpl['atc']['route'] }}</textarea>
                        </code>
                    </div>

                    <div class="form-group card-text">
                        <label>ATC Remarks</label>
                        <code>
                            <textarea class="form-control card-text" readonly rows="3">{{ $fpl['atc']['section18'] }}</textarea>
                        </code>
                    </div>

                    <div class="form-row">
                        <div class="form-group card-text col-lg-4">
                            <label>Cruise System</label>
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['general']['cruise_profile'] }}">
                            </code>
                        </div>

                        <div class="form-group card-text col-lg-4">
                            <label>Fuel Burn</label>
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['general']['total_burn'] }}">
                            </code>
                        </div>

                        <div class="form-group card-text col-lg-4">
                            <label>Init CRZ Alt</label>
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['general']['initial_altitude'] }}"></code>
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
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['fuel']['plan_ramp'] }} / {{ $fpl['fuel']['max_tanks'] }}"></code>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Burn</label>
                        <div class="col-md-6">
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['fuel']['enroute_burn'] }}">
                            </code>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Landing</label>
                        <div class="col-md-6">
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['fuel']['plan_landing'] }}">
                            </code>
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
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['aircraft']['icaocode'] }}">
                            </code>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Type</label>
                        <div class="col-md-6">
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['aircraft']['name'] }}">
                            </code>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">Registration</label>
                        <div class="col-md-6">
                            <code>
                                <input
                                type="text"
                                class="form-control card-text"
                                readonly
                                value="{{ $fpl['aircraft']['reg'] }}">
                            </code>
                        </div>
                    </div>

                    <div class="form-group card-text row mb-2">
                        <label class="col-md-6 col-form-label">PAX</label>
                        <div class="col-md-6">
                            <code><input
                            type="text"
                            class="form-control card-text"
                            readonly
                            value="{{ $fpl['general']['passengers'] }} / {{ $fpl['aircraft']['max_passengers'] }}"></code>
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
                    <code><input
                    type="text"
                    class="form-control card-text"
                    readonly
                    value="{{ $fpl['weights']['pax_count'] }} / {{ $fpl['aircraft']['max_passengers'] }}"></code>
                </div>

                <div class="form-group card-text col-md-3">
                    <label>Est. ZFW / Max</label>
                    <code>
                        <input
                        type="text"
                        class="form-control card-text"
                        readonly
                        value="{{ $fpl['weights']['est_zfw'] }} / {{ $fpl['weights']['max_zfw'] }}">
                    </code>
                </div>

                <div class="form-group card-text col-md-3">
                    <label>Est. TOW / Max</label>
                    <code>
                        <input
                        type="text"
                        class="form-control card-text"
                        readonly
                        value="{{ $fpl['weights']['est_tow'] }} / {{ $fpl['weights']['max_tow'] }}">
                    </code>
                </div>

                <div class="form-group card-text col-md-3">
                    <label>Est. LAW / Max</label>
                    <code>
                        <input
                        type="text"
                        class="form-control card-text"
                        readonly
                        value="{{ $fpl['weights']['est_ldw'] }} / {{ $fpl['weights']['max_ldw'] }}">
                    </code>
                </div>
            </div>
        </div>
    </div>
</div>

@if($plan->isApproved())
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Export Options</h5>

            <table class="card-text table table-striped border" style="max-width: 50%; margin: auto;">
                <tbody>
                    @foreach($fpl['fms_downloads'] as $download)
                        @if(!$loop->first)
                            <tr>
                                <td class="align-middle">{{ $download['name'] }}</td>
                                <td class="align-middle text-right">
                                    <a
                                    class="btn btn-success btn-sm m-0"
                                    href="{{ $fpl['fms_downloads']['directory'].$download['link']}}">
                                        <i class="fas fa-fw mr-2 fa-download"></i>Download
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Paperwork Preview</h5>

            <p class="card-text text-danger mb-2 text-center">
                <strong>DRAFT PLAN! Not operational paperwork.</strong>
            </p>
            <pre>
                <div class="card-text border rounded mx-auto" style="width: 1200px; height:600px; overflow:auto;">{{ strip_tags($fpl['text']['plan_html'].'<br>') }}</div>
            </pre>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Review</h5>

            @if($plan->hasAccepted())
                <p>
                    You have already accepted this flight plan. Your copilot has yet to review the plan, so
                    sit tight for now.
                </p>
            @else
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
                        <a class="btn btn-success btn-block card-text" href="{{ route('dispatch.accept', [$plan]) }}">
                            <i class="fas fa-5x fa-check"></i><br>Accept
                        </a>
                        <a class="btn btn-danger btn-block card-text" href="{{ route('dispatch.reject', [$plan]) }}">
                            <i class="fas fa-5x fa-times"></i><br>Reject
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif

@endsection
