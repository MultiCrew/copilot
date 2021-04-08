@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="float-right">
            @if(url()->previous() == config('app.url').'/dispatch')
                <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-info">
                    Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                </a>
            @endif

            <a class="btn btn-secondary" href="{{ url()->previous() }}">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </div>

        <h3 class="card-title">Flight Plan @unless($plan->isApproved()) Review @endunless</h3>
        <p class="lead text-muted">
            Flight
            from {{ $plan->flight->departure[0] }}
            to {{ $plan->flight->arrival[0] }}
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
        Both pilots must review the plan before proceeding.
    </div>
@endif

<div class="row">
    <div class="col-xl-4">
        <div class="row">
            <div class="col-xl-12 col-lg-6">
                <!-- begin summary box -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Summary</h5>
                        <dl class="row card-text">
                            <dt class="col-5 card-text">Departure</dt>
                            <dd class="col-7 text-right card-text">
                                <samp>{{ $flight->departure[0] }}</samp>
                            </dd>

                            <dt class="col-5 card-text">Arrival</dt>
                            <dd class="col-7 text-right card-text">
                                <samp>{{ $flight->arrival[0] }}</samp>
                            </dd>

                            <dt class="col-5 card-text">Aircraft</dt>
                            <dd class="col-7 text-right card-text">
                                <samp>{{ $flight->aircraft->name }}</samp>
                            </dd>

                            <dt class="col-5 card-text">Copilot</dt>
                            <dd class="col-7 text-right card-text">
                                <a href="{{ route('profile.show', $flight->otherUser()->profile) }}" class="text-decoration-none">
                                    <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                    {{ $flight->otherUser()->username }}
                                </a>
                            </dd>
                        </dl>
                    </div>
                </div>
                <!-- /end summary box -->
            </div>

            <div class="col-xl-12 col-lg-6">

                @if($plan->isApproved())
                    <a
                    class="btn btn-info btn-block btn-lg card-text mb-4"
                    href="{{ Storage::url($plan->file) }}"
                    target="_blank">
                        <i class="fas fa-file-export fa-fw mr-2"></i>Export Plan
                    </a>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Complete Flight</h5>

                            <p class="lead">Done with your flight? Mark it as completed and it will appear in your logbook!</p>
                            <button
                            type="button"
                            class="btn btn-warning btn-block btn-lg card-text"
                            data-toggle="modal"
                            data-target="#completeModal">
                                <i class="fas fa-check fa-fw mr-2"></i>Complete
                            </button>
                        </div>
                    </div>
                @else
                    <!-- begin review box -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Review</h5>

                            @if($plan->hasAccepted())
                                <p class="card-text">
                                    You have already accepted this flight plan. Your copilot has yet to review the plan, so
                                    sit tight for now.
                                </p>
                            @else
                                <div class="card-text">
                                    <p>
                                        Please select one of the following options to indicate whether you have reviewed,
                                        and are happy to continue with, the <strong>draft</strong> flight plan detailed above.
                                    </p>

                                    <div class="text-center card-text">
                                        <a class="btn btn-success btn-block card-text" href="{{ route('dispatch.accept', [$plan]) }}">
                                            <i class="fas mr-2 fa-check"></i>Accept
                                        </a>
                                        <a class="btn btn-danger btn-block card-text" href="{{ route('dispatch.reject', [$plan]) }}">
                                            <i class="fas mr-2 fa-times"></i>Reject
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /end review box -->
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-8">

        <div id="pdf" style="height: 690px;"></div>

    </div>

@if($plan->isApproved())
    <div
    class="modal fade"
    id="completeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="completeModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completeModalLabel">Complete Flight</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Are you sure you want to complete this flight? The flight plan PDF will be permanently deleted!
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('flights.archive', ['flight' => $flight]) }}">
                        @csrf

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-check mr-2"></i>Complete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"
integrity="sha256-rYPX3dXq8Nh532EvCS2foeyTgmzbcC8u+nCk/rEtKXA="
crossorigin="anonymous"></script>
<script type="text/javascript">
    var myPDF = PDFObject.embed("{{ Storage::url($plan->file) }}", "#pdf", {
        pdfOpenParams: {
            navpanes: 0,
            toolbar: 0,
            statusbar: 0
        }
    });
</script>

@endsection

@section('help-content')

<p>This page shows the uploaded PDF flight plan for your flight.</p>

<p>If you haven't already, take some time to review this flight plan and choose to either Accept or Reject it. You can choose to:</p>
<ul>
    <li>Accept - your copilot is notified and, if they accept it too, the flight plan can be exported and used.</li>
    <li>Reject - if either you or your copilot do this, the flight plan must be regenerated or reuploaded again.</li>
</ul>

<p>
    If you have, you can both view and dowload your flight plan PDF. When your flight is completed and you no longer require the flight plan,
    you can mark the flight as completed, when it will then appear in your logbook.
</p>

@endsection
