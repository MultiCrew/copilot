@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title">Flight Plan @if($review) Review @endif</h3>
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
                        <div class="col-md-4 form-group">
                            <label>Planned with</label>
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="AIRAC {{ $fpl['params']['airac'] }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Flight Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ $fpl['general']['icao_airline'] }}</span>
                                </div>
                                <input
                                type="text"
                                class="form-control"
                                readonly
                                value="{{ $fpl['general']['flight_number'] }}"
                                size="9">
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Callsign</label>
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="{{ $fpl['atc']['callsign'] }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 form-group">
                            <label>ADEP</label>
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="{{ $fpl['origin']['icao_code'].' / '.$fpl['origin']['iata_code'] }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>ADES</label>
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="{{ $fpl['destination']['icao_code'].' / '.$fpl['destination']['iata_code'] }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>ALTN</label>
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="{{ $fpl['alternate']['icao_code'].' / '.$fpl['alternate']['iata_code'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Routing</h5>
                <div class="card-text">
                    <div class="form-group">
                        <label>ATC Route</label>
                        <textarea class="form-control" readonly rows="3">{{ $fpl['atc']['route'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>ATC Remarks</label>
                        <textarea class="form-control" readonly rows="3">{{ $fpl['atc']['section18'] }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-lg-4">
                            <label>Cost Index</label>
                            <input type="text" class="form-control" readonly value="{{ $fpl['general']['costindex'] }}">
                        </div>

                        <div class="form-group col-lg-4">
                            <label>Fuel Burn</label>
                            <input type="text" class="form-control" readonly value="{{ $fpl['general']['total_burn'] }}">
                        </div>

                        <div class="form-group col-lg-4">
                            <label>Init CRZ Alt</label>
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="{{ $fpl['general']['initial_altitude'] }}">
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
                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">Block</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['fuel']['plan_ramp'] }}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">Max</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['fuel']['max_tanks'] }}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">Burn</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['fuel']['enroute_burn'] }}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">Landing</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['fuel']['plan_landing'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Aircraft</h5>

                <div class="card-text">
                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">ICAO</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['aircraft']['icaocode'] }}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">Type</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['aircraft']['name'] }}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">Registration</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" readonly value="{{ $fpl['aircraft']['reg'] }}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-6 col-form-label">PAX</label>
                        <div class="col-md-6">
                            <input
                            type="text"
                            class="form-control"
                            readonly
                            value="{{ $fpl['general']['passengers'] }} / {{ $fpl['aircraft']['max_passengers'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Crew</h5>

                <div class="card-text">
                    <div class="form-group row mb-2">
                        <label class="col-md-4 col-form-label">OFP by</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly value="{{ $fpl['crew']['cpt'] }}">
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
                <div class="form-group col-md-3">
                    <label>PAX</label>
                    <input
                    type="text"
                    class="form-control"
                    readonly
                    value="{{ $fpl['weights']['pax_count'] }} / {{ $fpl['aircraft']['max_passengers'] }}">
                </div>

                <div class="form-group col-md-3">
                    <label>Est. ZFW</label>
                    <input type="text" class="form-control" readonly value="{{ $fpl['weights']['est_zfw'] }}">
                </div>

                <div class="form-group col-md-3">
                    <label>Est. TOW</label>
                    <input type="text" class="form-control" readonly value="{{ $fpl['weights']['est_tow'] }}">
                </div>

                <div class="form-group col-md-3">
                    <label>Est. LAW</label>
                    <input type="text" class="form-control" readonly value="{{ $fpl['weights']['est_ldw'] }}">
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3"></div>

                <div class="form-group col-md-3">
                    <label>Max. ZFW</label>
                    <input type="text" class="form-control" readonly value="{{ $fpl['weights']['max_zfw'] }}">
                </div>

                <div class="form-group col-md-3">
                    <label>Max. TOW</label>
                    <input type="text" class="form-control" readonly value="{{ $fpl['weights']['max_tow'] }}">
                </div>

                <div class="form-group col-md-3">
                    <label>Max. LAW</label>
                    <input type="text" class="form-control" readonly value="{{ $fpl['weights']['max_ldw'] }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Paperwork Preview</h5>

        <p class="card-text text-danger mb-2 text-center">DRAFT PLAN! Not operational paperwork.</p>
        <div class="card-text border rounded mx-auto" style="width: 600px; height:600px; overflow:auto;">
            <pre>{{ strip_tags($fpl['text']['plan_html'].'<br>') }}</pre>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        @if($review)
            <h5 class="card-title">Review</h5>

            <div class="card-text">
                <p>Please select one of the following options to indicate whether you have reviewed, and are happy to continue with, the flight plan detailed above.</p>
                <p>Upon accepting the flight plan, a PDF document and other export options will become available.</p>
                <p>Upon rejecting the flight plan, another will have to be generated.</p>

                <div class="text-center mb-3">
                    <form action="" method="post">
                       <button type="submit" name="proceed" value="true" class="btn button-accept"><i class="fas fa-5x fa-check"></i><br>Proceed</button>
                    </form>
                </div>

                <div class="text-center mb-3">
                    <button type="submit" name="accept" value="true" class="btn button-accept"><i class="fas fa-5x fa-check"></i><br>Accept</button>
                    <button type="submit" name="reject" value="true" class="btn button-reject"><i class="fas fa-5x fa-times"></i><br>Reject</button>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
