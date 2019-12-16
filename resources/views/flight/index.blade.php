@extends('layouts.base')

@section('content')

<div class="form-group">
	<input type="text" name="search" id="search" class="form-control" placeholder="Search Flights">
</div>

<table class="table table-striped table-hover">
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
        <tr id="loading-icon">
            <td colspan="5">
                <div class="d-flex align-items-center justify-content-center">
                    <span class="spinner-border mr-3 text-warning" role="status"></span>
                    <span>Loading...</span>
                </div>
            </td>
        </tr>
	</tbody>
</table>

@endsection

@section('scripts')

<script>
	$(document).ready(function()
    {
        function fetch_customer_data(query = '')
        {
            $.ajax({
                url: "{{ route('flights.search') }}",
                method: 'GET',
                data: {query:query},
                dataType: 'json',
                success: function(data)
                {
                    $('#loading-icon').hide();
                    $('tbody').attr('class', '');
                    $('tbody').html(data.table_data);
                }
            })
        }

        fetch_customer_data();

        $(document).on('keyup', '#search', function()
        {
            $('#loading-icon').show();
            var query = $(this).val();
            fetch_customer_data(query);
        });
	});
</script>

@endsection
