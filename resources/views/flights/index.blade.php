@extends('layouts.base')

@section('content')

<div class="form-group">
	<input type="text" name="search" id="search" class="form-control" placeholder="Search Flights">
</div>

<table class="table table-striped table-hover" id="flights-table">
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
        /**
         * Turns an array of flight request objects into table rows and adds them to the table
         *
         * @param      data     Array of flight objects
         */
        function handleData(data)
        { 
            $("#flights-table tbody").empty();
            $('#loading-icon').hide();
            if (data.length > 0)
            {
                for (i = 0; i < data.length; i++)
                {
                    var htmlRow = '<tr>';

                    htmlRow +=  '<td>'+data[i].id+'</td>';
                    htmlRow +=  '<td>'+data[i].departure+'</td>';
                    htmlRow +=  '<td>'+data[i].arrival+'</td>';
                    htmlRow +=  '<td>'+data[i].aircraft+'</td>';
                    htmlRow +=  '<td><a href="'+data[i].id+'" class="btn btn-sm btn-success">Join &raquo;</a></td>';

                    $('tbody').append(htmlRow + '</tr>');
                }
            }
            else
            {
                $('tbody').append('<tr><td colspan="5" class="text-center">No flights found</td><tr>');
            }
        }

        /**
         * Gets flight requests from database, optionally filtering by a search term
         * Additionally, calls handleData() with the returned array of flights
         *
         * @param      string   query   Optional search term
         */
        function getFlights(query = '')
        {
            $.ajax({
                url: "{{ route('flights.search') }}",
                method: 'GET',
                data: {query:query},
                dataType: 'json',
                success: function(data)
                {
                    handleData(data);
                }
            })
        }

        getFlights();

        /**
         * When the search input's value is changed, get flights, passing in the search term
         */
        $(document).on('keyup', '#search', function()
        {
            $('#loading-icon').show();
            var query = $(this).val();
            getFlights(query);
        });
	});
</script>

@endsection
