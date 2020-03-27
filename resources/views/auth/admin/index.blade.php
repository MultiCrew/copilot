@extends('layouts.base')

@section('content')

<h1>User Management</h1>

<table class="table table-hover table-striped border">
    <thead class="thead-light">
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
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

@if(!empty($users))
    {{ $users->links() }}
@endif

@endsection
