<!-- Modal -->
<div class="modal fade" id="uint-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="uint-addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uint-addLabel">New Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ecomadmin.prod.units.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="inputText">Unit Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" autofocus required>

                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputText">Short Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="short_name" name="short_name" value="{{old('short_name')}}" required>
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

                        <div class="row mb-3">
                            <label for="inputText">Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="description" rows="5" id="description">{{old('description')}}</textarea>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" id="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


