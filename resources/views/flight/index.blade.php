@extends('layouts.base')

@section('content')
<div class="form-group">
	<input type="text" name="search" id="search" class="form-control" placeholder="Search Flights" />
</div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Departure</th>
				<th>Arrival</th>
				<th>Aircraft</th>
				<th>Join</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
	
	 fetch_customer_data();
	
	 function fetch_customer_data(query = '')
	 {
	  $.ajax({
	   url:"{{ route('flights.search') }}",
	   method:'GET',
	   data:{query:query},
	   dataType:'json',
	   success:function(data)
	   {
		$('tbody').html(data.table_data);
	   }
	  })
	 }
	
	 $(document).on('keyup', '#search', function(){
	  var query = $(this).val();
	  fetch_customer_data(query);
	 });
	});
	</script>
@endsection