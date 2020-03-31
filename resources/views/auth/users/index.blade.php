@extends('layouts.base')

@section('content')

<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link active" href="#">
            <i class="fas fa-users mr-2"></i>
            Users
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.applications.index') }}">
            <i class="fas fa-file-signature mr-2"></i>
            Applications
        </a>
    </li>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">User Management</h1>

        <table class="table table-hover table-striped border card-text">
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
    </div>
</div>

@if(!empty($users))
    {{ $users->links() }}
@endif

@endsection
