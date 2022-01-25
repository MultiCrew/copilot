<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form onsubmit="return createClient(event)">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createClientModalLabel">Create Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <h5><label>Client Name</label></h5>
                        <small>We recommend setting this to your application name as this will be publicly shown to all users using your app.</small>
                        <input class="form-control mt-2" type="text" id="client_name" name="client_name" required>
                    </div>

                    <div class="form-group">
                        <h5><label>Redirects</label></h5>
                        <small>You must specify at least one URL for authentication. If you pass a URL in an OAuth
                            request, it must be one of the URLs below. Enter a new URL on a new line.</small>
                        <textarea class="form-control mt-2" name="redirect" id="redirect" rows="5" required placeholder="http://example.com&#10;http://another-example.com"></textarea>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        Create <i class="fas fa-angle-double-right fa-fw ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('append-scripts')
<script type="text/javascript">
    function createClient(e) {
        e.preventDefault();
        try {
            var lines = [];
            $.each($('#redirect').val().split(/\n/), function(i, line){
                if(line && line.includes('http')){
                    lines.push(line);
                }
            });
            var redirectList = lines.join(',');
            var data = {
                name: $('#client_name').val(),
                redirect: redirectList
            }
            axios.post('/oauth/clients', data).then(response => {
                if(response.status == 201) {
                    window.location.href = '/account#api';
                    window.location.reload(true);
                }
            }).catch(err => {
                console.log(err);
            });
        } catch (err) {
            console.log(err);
        }
    }
</script>

@endpush
