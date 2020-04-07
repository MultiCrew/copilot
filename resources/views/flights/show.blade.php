@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <a
        @if(strpos(url()->previous(), 'my-flights'))
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
                    <dt class="col-sm-3 card-text">Copilot</dt>
                    <dd class="col-sm-9 card-text">
                        <a href="#" class="text-decoration-none">
                            <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                            {{ $flight->otherUser()->username }}
                        </a>
                    </dd>

                    <dt class="col-sm-3 card-text">Flight Plan</dt>
                    <dd class="col-sm-9 card-text">
                        @if($flight->isPlanned())
                            <a href="{{ route('dispatch.show', $flight->plan_id) }}" class="btn btn-sm btn-info m-0">
                                View<i class="fas fa-fw ml-1 fa-angle-double-right"></i>
                            </a>
                        @else
                            <a href="{{ route('dispatch.create', $flight->id) }}" class="btn btn-sm btn-success">
                                Create Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                            </a>
                        @endif
                    </dd>

                    <dt class="col-sm-3 card-text">Status</dt>
                    <dd class="col-sm-9 card-text">
                        @if($flight->isPlanned())
                            <form method="post" action="{{ route('flights.archive', ['flight' => $flight]) }}">
                                <input type="hidden" name="flight" value="{{ $flight->id }}">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-check fa-fw mr-2"></i>Mark Complete
                                </button>
                            </form>
                        @else
                            Not planned
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        <p class="card-text mt-4">
            <a
            href="@if($flight->isRequestee(Auth::user())) {{ route('flights.edit', $flight->id) }} @else # @endif"
            class="btn btn-info @if($flight->isAcceptee(Auth::user())) disabled @endif">
                <i class="fas fa-fw mr-2 fa-edit"></i>Edit
            </a>
        </p>
    </div>
</div>

@endsection

@section('help-content')

<p>
    Here you can see all the details about a flight you're involved with. You
    can see who your Copilot is, as well as whether the flight has been planned
    or not.
</p>

<p>
    If the flight hasn't been planned, you can press "Create Plan" to be taken
    to the dispatch form. If a flight plan is already available to review or
    export, press "(Re)view Plan" to be taken to it.
</p>

@endsection
