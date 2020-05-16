@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <a
        @if($flight->isInvolved(Auth::user()))
            @if(strpos(url()->previous(), 'dispatch') !== false)
                href="{{ route('dispatch.index') }}"
            @else
                href="{{ route('flights.user-flights') }}"
            @endif
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
                @if($type === 'FlightRequest')
                    <dl class="row card-text">
                        <dt class="col-sm-3 card-text">Copilot</dt>
                        <dd class="col-sm-9 card-text">
                            @if($otherUser = $flight->otherUser())
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                    {{ $otherUser->username }}
                                </a>
                            @else
                                No one, yet!
                            @endif
                        </dd>

                        <dt class="col-sm-3 card-text">Flight Plan</dt>
                        <dd class="col-sm-9 card-text">
                            @if($flight->isPlanned())
                                <a href="{{ route('dispatch.show', $flight->plan_id) }}" class="btn btn-sm btn-info m-0">
                                    View<i class="fas fa-fw ml-1 fa-angle-double-right"></i>
                                </a>

                            @else

                                <button
                                type="button"
                                class="btn btn-sm btn-success"
                                data-toggle="modal"
                                data-target="#dispatchModal">
                                    Create Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                </button>
                            @endif
                        </dd>

                        <dt class="col-sm-3 card-text">Status</dt>
                        <dd class="col-sm-9 card-text">
                            @if($flight->planAccepted())
                                <form method="post" action="{{ route('flights.archive', ['flight' => $flight]) }}">
                                    @csrf

                                    <input type="hidden" name="flight" value="{{ $flight->id }}">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check fa-fw mr-2"></i>Mark Complete
                                    </button>
                                </form>
                            @elseif($flight->isPlanned())
                                Plan under review
                            @else
                                Not planned
                            @endif
                        </dd>
                    </dl>
                @elseif($type == 'ArchivedFlight')
                    <dl class="row card-text">
                        <dt class="col-sm-3 card-text">Copilot</dt>
                        <dd class="col-sm-9 card-text">
                            <a href="#" class="text-decoration-none">
                                <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                {{ $flight->otherUser()->username }}
                            </a>
                        </dd>

                        <dt class="col-sm-3 card-text">Date Complete</dt>
                        <dd class="col-sm-9 card-text">
                            {{ \Carbon\Carbon::parse($flight->created_at)
                                ->format('H:i, D j M Y') }}
                        </dd>
                    </dl>
                @endif
            </div>
        </div>

        @if($flight->isRequestee(Auth::user()))
            <p class="card-text mt-4">
                <a
                href="{{ route('flights.edit', $flight->id) }}"
                class="btn btn-info">
                    <i class="fas fa-fw mr-2 fa-edit"></i>Edit
                </a>
            </p>
        @endif

        @if(!$flight->public && !$flight->acceptee)
            <hr>
            <p class="card-text">
                As your flight is private, you'll need to share it with someone
                directly for them to join it. Just send them the link below!
            </p>
            <div class="form-group card-text">
                <label>Join link</label>
                <div class="input-group">
                    <input
                    type="text"
                    readonly
                    value="{{ route('flights.accept.private', ['code' => $flight->code]) }}"
                    class="form-control"
                    id="privateCode">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" onclick="copyLink()">
                            <i class="fas fa-paste"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div
class="modal fade"
id="dispatchModal"
tabindex="-1"
role="dialog"
aria-labelledby="dispatchModalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dispatchModalLabel">Dispatch Flight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="lead text-center">Select how you want to dispatch this flight</p>
                <a
                href="{{ route('dispatch.upload', $flight->id) }}"
                class="btn btn-lg btn-block btn-primary"
                id="dispatchUploadButton">
                    <i class="fas fa-file-upload mr-2"></i>Upload PDF Plan
                </a>
                <a
                href="{{ route('dispatch.create', $flight->id) }}"
                class="btn btn-lg btn-block btn-primary"
                id="dispatchSimbriefButton">
                    <i class="fas fa-file-contract mr-2"></i>Create SimBrief Plan
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    function copyLink() {
        const link = document.getElementById('privateCode');
        link.select();
        document.execCommand('copy');
    }
</script>

@endsection
