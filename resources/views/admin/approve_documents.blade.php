<a name="document_table"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title">{{$user_name}}'s Documents</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="document_table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Document Type</th>
                        <th>Document Number</th>
                        <th>Front Image</th>
                        <th>Back Image</th>
                        <th>St. Date</th>
                        <th>En. Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{$document->document_type}}</td>
                            <td>{{$document->document_number}}</td>
                            <td><img src="{{asset($document->document_front_image)}}" class="document-image" data-document-type="{{$document->document_type}} - Front" data-toggle="modal" data-target="#imageModal" alt="Document Front Image" width="150px" /></td>
                            <td>@if(empty($document->document_back_image)) N/A @else <img src="{{asset($document->document_back_image)}}" class="document-image" data-document-type="{{$document->document_type}} - Back" data-toggle="modal" data-target="#imageModal" alt="Document Back Image" width="150px" /> @endif</td>
                            <td>{{$document->st_dt}}</td>
                            <td>{{$document->en_dt}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.info-box -->
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Preview</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <!-- Image will be loaded here -->
                <img id="modalImage" src="" class="img-fluid" alt="Document Image" />
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // Initialize DataTable
        $('#document_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]
        });

        // Handle image click to show in modal
        $('.document-image').on('click', function () {
            var imageUrl = $(this).attr('src');
            var imageName = $(this).attr('data-document-type');
            $('#modalImage').attr('src', imageUrl);
            $(".modal-title").html(imageName);
        });
    });
</script>
