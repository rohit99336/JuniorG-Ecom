<!-- Modal -->
<div class="modal fade" id="gallery-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="gallery-addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gallery-addLabel">Add New Slider Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sliders.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="inputText">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="title" autofocus required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputNumber" class="col-form-label">Image</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder"
                                        class="btn btn-success">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="image" readonly required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputText">Link</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="image_link" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


