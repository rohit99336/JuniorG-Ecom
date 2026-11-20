<!-- Modal -->
<div class="modal fade" id="uint-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="uint-addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uint-addLabel">New color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ecomadmin.prod.colors.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="inputText">Color Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" autofocus required>

                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputText">Color Code</label>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="color_code" value="#4154f1"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="color" class="form-control form-control-color" id="code"
                                            name="code" value="#4154f1" title="Choose your color code">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputText">Status</label>
                            <div class="col-sm-12">
                                <select class="form-select" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" id="reset" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>
