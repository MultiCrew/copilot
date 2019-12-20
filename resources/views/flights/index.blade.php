@extends('layouts.base')

@section('content')

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="body">
                        <h5 class="card-title">Flight Requests</h5>
                        <table class="card-table table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th>Aircraft</th>
                                    <th>Public</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flightRequests as $request)
                                    <tr>
                                        <td>
                                            {{$request->id}}
                                        </td>
                                        <td>
                                            {{$request->departure}}
                                        </td>
                                        <td>
                                            {{$request->arrival}}
                                        </td>
                                        <td>
                                            {{$request->aircraft}}
                                        </td>
                                        <td>
                                            {{$request->isPublic($request)}}
                                        </td>
                                        <td>
                                            <a href="{{route('flights.update', ['id' => $request->id])}}" class="btn btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="body">
                        <h5 class="card-title">Accepted Flights</h5>
                        <table class="card-table table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th>Aircraft</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($acceptedFlights as $accepted)
                                    <tr>
                                        <td>
                                            {{$accepted->id}}
                                        </td>
                                        <td>
                                            {{$accepted->departure}}
                                        </td>
                                        <td>
                                            {{$accepted->arrival}}
                                        </td>
                                        <td>
                                            {{$accepted->aircraft}}
                                        </td>
                                        <td>
                                            <a href="{{route('flights.show', ['id' => $accepted->id])}}" class="btn btn-primary">Show</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
