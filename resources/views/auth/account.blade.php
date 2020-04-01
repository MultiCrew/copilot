@extends('layouts.base')

@section('header')
        
@endsection

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <h1 class="card-title">Your Account</h1>
        <div class="card-text">
            <form method="post" action="">
                @method('patch')
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" readonly
                            value="{{ Auth::user()->username }}" autocomplete="username">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}"
                            autocomplete="name">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}"
                        autocomplete="email">
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            autocomplete="new-password">
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-fw fa-save mr-3"></i>Save
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">
                <i class="fas mr-3 fa-bell"></i>Notification Settings
            </h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body">
                        <p class="card-text">
                            Select the notifications which you wish to subscribe to
                        </p>
        
                        <form method="post" action="" id='notificationForm'>
                            @method('patch')
                            @csrf
        
                            <table class="table border">
                                <thead class="thead-light">
                                    <tr>
                                        <td></td>
                                        <td><i class="fas mx-auto fa-bell"></i></td>
                                        <td><i class="fas mx-auto fa-envelope"></i></td>
                                        <td><i class="fas mx-auto fa-mobile-alt"></i></td>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    <tr>
                                        <td>My flight request is accepted</td>
                                        <td>
                                            <input type="checkbox" id="request_accepted" name="request_accepted"
                                                class="form-check-input mx-auto"
                                                onchange="postNotification()" value="1"
                                                {{$userNotifications->request_accepted ? 'checked' : ''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="request_accepted_email" name="request_accepted_email"
                                                class="form-check-input mx-auto"
                                                onchange="postNotification()" value="1"
                                                {{$userNotifications->request_accepted_email ? 'checked' : ''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="request_accepted_push" name="request_accepted_push"
                                                class="form-check-input mx-auto"
                                                onchange="postNotification()" value="1"
                                                {{$userNotifications->request_accepted_push ? 'checked' : ''}}>
                                        </td>
                                    </tr>
        
                                    <tr>
                                        <td>My flight plan has been reviewed</td>
                                        <td>
                                            <input type="checkbox" id="plan_reviewed" name="plan_reviewed"
                                                class="form-check-input mx-auto"
                                                onchange="postNotification()" value="1"
                                                {{$userNotifications->plan_reviewed ? 'checked' : ''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="plan_reviewed_email" name="plan_reviewed_email"
                                                class="form-check-input mx-auto"
                                                onchange="postNotification()" value="1"
                                                {{$userNotifications->plan_reviewed_email ? 'checked' : ''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="plan_reviewed_push" name="plan_reviewed_push"
                                                class="form-check-input mx-auto"
                                                onchange="postNotification()" value="1"
                                                {{$userNotifications->plan_reviewed_push ? 'checked' : ''}}>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <div class="card-text">
                            <select name="airportSelect" id="airportSelect" class="selectpicker" data-live-search="true" multiple>
                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.5/js/ajax-bootstrap-select.min.js"></script>
<script>
$(document).ready(function(){
    if($('#request_accepted').prop('checked') !== true){
        $("#request_accepted_email").attr("disabled", true);
        $("#request_accepted_push").attr("disabled", true);
    }
    if($('#plan_reviewed').prop('checked') !== true){
        $("#plan_reviewed_email").attr("disabled", true);
        $("#plan_reviewed_push").attr("disabled", true);
    }
    $('#request_accepted').click(function(){
        if($(this).is(":checked")){
            $("#request_accepted_email").removeAttr('disabled');
            $("#request_accepted_push").removeAttr('disabled');
        }
        else if($(this).is(":not(:checked)")){
            $("#request_accepted_email").attr("disabled", true);
            $("#request_accepted_push").attr("disabled", true);
        }
    });
    $('#plan_reviewed').click(function(){
        if($(this).is(":checked")){
            $("#plan_reviewed_email").removeAttr('disabled');
            $("#plan_reviewed_push").removeAttr('disabled');
        }
        else if($(this).is(":not(:checked)")){
            $("#plan_reviewed_email").attr("disabled", true);
            $("#plan_reviewed_push").attr("disabled", true);
        }
    });
    $('#airportSelect').selectpicker({
            liveSearch: true
        })
        .ajaxSelectPicker({
            ajax: {
                url: '{{route("search.airport")}}',
                method: 'GET',
                data: {
                    q: '@{{{q}}}'
                }
            },
            locale: {
                emptyTitle: 'Start typing to search...',
                statusInitialized: '',
            },
            preprocessData: function(data){
                var airports = [];
                let count;
                if(data.length > 0){
                    if(data.length >= 10) {
                        count = 10;
                    } else {
                        count = data.length;
                    }
                    for(var i = 0; i < count; i++){
                        var curr = data[i];
                        airports.push(
                            {
                                'value': curr.icao,
                                'text': curr.icao + ' - ' + curr.name,
                                'disabled': false
                            }
                        );
                    }
                }
                return airports;
            },
            preserveSelected: true
        });
    $('#airportSelect').on('changed.bs.select', function(event, clickedIndex, isSelected, previousValue) {
        console.log($('#airportSelect').selectpicker('val'));
        $.ajax({
            url: '{{route("notifications.airport")}}',
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'data': $('#airportSelect').selectpicker('val')
            },
            success: function(data) {
                console.log(data);
            }
        });
    })
});
function postNotification() {
    $.ajax({
        url: '{{route("notifications.update")}}',
        type: 'POST',
        data: new FormData(document.getElementById('notificationForm')),
        processData: false,
        contentType: false
    })
}
function diffArray(arr1, arr2) { 
    var newArr = []; // Same, same; but different. 

    for(let i = 0; i< arr1.length;i++) { 
        if(arr2.indexOf(arr1[i])==-1) { 
            newArr.push(arr1[i]); 
        } 
    } 

    for(let i = 0; i< arr2.length;i++) { 
        if(arr1.indexOf(arr2[i])==-1) { 
            newArr.push(arr2[i]); 
        } 
    } 
    return newArr; 
} 
</script>
@endsection