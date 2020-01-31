@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Active Plans</h5>

        <table class="table table-hover card-text border">
            <thead class="thead-light">
                <tr class="d-flex">
                    <th class="col-2">Requestee</th>
                    <th class="col-2">Acceptee</th>
                    <th class="col-2">Departure</th>
                    <th class="col-2">Arrival</th>
                    <th class="col-2">Aircraft</th>
                    <th class="col-2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($flights as $flight)
                    @if(!empty($flight->plan_id))
                        <tr class="d-flex">
                            <td class="col-2">
                                @if($flight->requestee_id == Auth::user()->id)
                                    You!
                                @else
                                    {{ User::find($flight->requestee_id)->username }}
                                @endif
                            </td>
                            <td class="col-2">
                                @if($flight->acceptee_id == Auth::user()->id)
                                    You!
                                @else
                                    {{ User::find($flight->acceptee_id)->username }}
                                @endif
                            </td>
                            <td class="col-2">{{ $flight->departure }}</td>
                            <td class="col-2">{{ $flight->arrival }}</td>
                            <td class="col-2">{{ $flight->aircraft }}</td>
                            <td class="py-0 col-2 text-right">
                                <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-sm my-2 btn-info">
                                    View<i class="fas fa-fw ml-2 fa-search"></i>
                                </a>
                                <a href="{{ route('dispatch.plan', [$flight->id]) }}" class="btn btn-sm my-2 btn-success">
                                    Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach

                @if(!count($flights))
                    <tr>
                        <td colspan="5">No flights!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Unplanned Flights</h5>

        <table class="table table-hover card-text border">
            <thead class="thead-light">
                <tr class="d-flex">
                    <th class="col-2">Requestee</th>
                    <th class="col-2">Acceptee</th>
                    <th class="col-2">Departure</th>
                    <th class="col-2">Arrival</th>
                    <th class="col-2">Aircraft</th>
                    <th class="col-2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($flights as $flight)
                    @if(empty($flight->plan_id))
                        <tr class="d-flex">
                            <td class="col-2">
                                @if($flight->requestee_id == Auth::user()->id)
                                    You!
                                @else
                                    {{ User::find($flight->requestee_id)->username }}
                                @endif
                            </td>
                            <td class="col-2">
                                @if($flight->acceptee_id == Auth::user()->id)
                                    You!
                                @else
                                    {{ User::find($flight->acceptee_id)->username }}
                                @endif
                            </td>
                            <td class="col-2">{{ $flight->departure }}</td>
                            <td class="col-2">{{ $flight->arrival }}</td>
                            <td class="col-2">{{ $flight->aircraft }}</td>
                            <td class="py-0 col-2 text-right">
                                <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-sm my-2 btn-info">
                                    View<i class="fas fa-fw ml-2 fa-search"></i>
                                </a>
                                <a href="{{ route('dispatch.plan', [$flight->id]) }}" class="btn btn-sm my-2 btn-success">
                                    Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach

                @if(!count($flights))
                    <tr>
                        <td colspan="5">No flights!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
