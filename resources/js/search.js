$(document).ready(function()
{
    /**
     * Turns an array of flight request objects into table rows and adds them to the table
     *
     * @param      data     Array of flight objects
     */
    function handleData(data)
    {
        if (data.length > 0)
        {
            for (i = 0; i < data.length; i++)
            {
                var route = '{{ route('flights.accept', ":id") }}'
                route = route.replace(':id', data[i].id)

                var htmlRow = '<tr>';

                htmlRow +=  '<td>'+data[i].id+'</td>';
                htmlRow +=  '<td>'+data[i].departure+'</td>';
                htmlRow +=  '<td>'+data[i].arrival+'</td>';
                htmlRow +=  '<td>'+data[i].aircraft+'</td>';
                htmlRow +=  '<td><a href="'+route+'" class="btn btn-sm btn-success">Accept &raquo;</a></td>';

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
                $('#loading-icon').hide();
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
        $("#flights-table tbody").find("tr:gt(0)").remove();
        var query = $(this).val();
        getFlights(query);
    });
});
