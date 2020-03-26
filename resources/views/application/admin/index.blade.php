@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            <i class="fas fa-exclamation-circle mr-3"></i>
            Pending Applications
        </h3>

        <table class="table table-hover table-striped border card-text">
            <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date of Registration</th>
                    <th>Date of Application</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @forelse($pendingApplications as $application)
                    @php($user = User::findOrFail($application->user_id))

                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $applicaton->created_at }}</td>
                        <td>
                            <a href="#" class="btn btn-primary">
                                Review
                                <i class="fas fa-angle-double-right ml-3"></i>
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5">No pending applications</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
