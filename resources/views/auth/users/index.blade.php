@extends('layouts.base')

@section('content')

@include('includes.admin-nav')

<div class="card">
    <div class="card-body">
        <h3 class="card-title">All Users</h3>

        <table class="table table-hover table-striped border card-text">
            <thead class="thead-light">
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->hasRole('admin'))
                                <span class="badge badge-danger">Admin</span>
                            @elseif($user->hasRole('user'))
                                <span class="badge badge-info">Beta Tester</span>
                            @endif
                        </td>
                        <td class="p-1 text-right">
                            <a class="btn btn-primary btn-sm m-1" href="#">
                                View Profile
                                <i class="fas fa-angle-double-right ml-2"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No users!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(!empty($users))
    {{ $users->links() }}
@endif

@endsection
