@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <a
        @if($flight->requestee_id == Auth::user()->id)
            href="{{ route('flights.user-flights') }}"
        @else
            href="{{ route('flights.index') }}"
        @endif
        class="btn btn-secondary float-right">
            <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
        </a>

        <h5 class="card-title">Flight Information</h5>

        <div class="row">
            <div class="col-md-6">
                <dl class="row card-text">
                    <dt class="col-sm-3 card-text">Departure</dt>
                    <dd class="col-sm-9 card-text">{{ $flight->departure }}</dd>

                    <dt class="col-sm-3 card-text">Arrival</dt>
                    <dd class="col-sm-9 card-text">{{ $flight->arrival }}</dd>

                    <dt class="col-sm-3 card-text">Aircraft</dt>
                    <dd class="col-sm-9 card-text">{{ $flight->aircraft }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="row card-text">
                    <dt class="col-sm-3 card-text">
                        @if($flight->requestee_id != Auth::user()->id)
                            Acceptee
                        @else
                            Requestee
                        @endif
                    </dt>

                    <dd class="col-sm-9 card-text">
                        @if($flight->requestee_id != Auth::user()->id)
                            <a href="#" class="text-decoration-none">
                                <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                {{ User::findOrFail($flight->acceptee_id)->username }}
                            </a>
                        @else
                            <a href="#" class="text-decoration-none">
                                <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                {{ User::findOrFail($flight->requestee_id)->username }}
                            </a>
                        @endif
                    </dd>
                </dl>

                <dl class="row card-text">
                    <dt class="col-sm-3 card-text">Flight Plan</dt>
                    <dd class="col-sm-9 card-text">
                        @if(empty($flight->plan_id))
                            Not planned
                        @else
                            <!-- logic to link to FlightPlan model -->
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        <p class="card-text mt-4 d-flex justify-content-between">
            <a
            href="@if($flight->requestee_id == Auth::user()->id) {{ route('flights.edit', $flight->id) }} @else # @endif"
            class="btn btn-info @if($flight->requestee_id != Auth::user()->id) disabled @endif">
                <i class="fas fa-fw mr-2 fa-edit"></i>Edit
            </a>

            @if(empty($flight->plan_id))
                <a href="{{ route('dispatch.plan', $flight->id) }}" class="btn btn-success">
                    Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                </a>
            @endif
        </p>
    </div>
</div>

@endsection
