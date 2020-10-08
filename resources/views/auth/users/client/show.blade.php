<div class="modal fade" id="showClientModal" tabindex="-1" role="dialog" aria-labelledby="showClientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form onsubmit="return updateClient(event)">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="showClientModalLabel">View Client Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <h5 class="mb-2"><label>Client Name</label></h5>
                        <input class="form-control" type="text" id="client_show_name" name="client_name" required>
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Redirects</label></h5>
                        <small>You must specify at least one URL for authentication. If you pass a URL in an OAuth
                            request, it must be one of the URLs below. Enter a new URL on a new line.</small>
                        <textarea class="form-control" name="client_redirect" id="client_show_redirect" rows="5"
                            required placeholder="http://example.com&#10;http://another-example.com"></textarea>
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Client ID</label></h5>
                        <input class="form-control" type="text" id="client_show_id" name="client_id" required disabled>
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2 d-flex justify-content-between"><label>Client Secret</label> <button
                                type="button" id="show_secret" class="btn btn-primary">Click to show client
                                secret</button></h5>
                        <input class="form-control" type="text" id="client_show_secret" name="client_secret" required
                            disabled hidden>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal" onclick="deleteClient()">Delete <i
                            class="fa fa-times ml-2"></i></button>
                    <button type="submit" class="btn btn-success">
                        Update <i class="fas fa-pencil-alt fa-fw ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('append-scripts')
<script type="text/javascript">
    $('#show_secret').click(function() {
        $('#client_show_secret').removeAttr('hidden');
        $('#show_secret').attr('hidden', true)
    })

    function updateClient(e)
    {
        e.preventDefault()
        var lines = [];
        $.each($('#client_show_redirect').val().split(/\n/), function(i, line){
            if(line && line.includes('http')){
                lines.push(line);
            } 
        });
        var redirectList = lines.join(',');
        var data = {
            name: $('#client_show_name').val(),
            redirect: redirectList
        }
        var id = $('#client_show_id').val()
        axios.put(`/oauth/clients/${id}`, data).then(response => {
            if(response.status == 200) {
                window.location.href = '/account#api';
                window.location.reload(true);
            }
        }).catch(err => {
            console.log(err);
        });
    }

    function deleteClient()
    {
        var id = $('#client_show_id').val()
        axios.delete(`/oauth/clients/${id}`, {withCredentials: true}).then(response => {
            if (response.status == 204) {
                window.location.href = '/account#api';
                window.location.reload(true);
            }
        })
    }
</script>

@endpush