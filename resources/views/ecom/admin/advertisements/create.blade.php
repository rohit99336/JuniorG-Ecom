<!-- Modal -->
<div class="modal modal-lg fade" id="uint-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="uint-addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uint-addLabel">New Advertisement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div>
                @if ($errors->any())
                    <ul class="alert">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <form action="{{ route('ecomadmin.advertisement.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputText">Title</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title') }}" autofocus required>

                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="for" id="for" value="shop">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="lfm">
                                    Image<span id="size"></span> <small style="font-size: 10px;" class="text-danger">Webp
                                        format</small>
                                </label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="image" data-preview="holder"
                                                class="btn btn-success lfm">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="image" class="form-control" type="text" name="image"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="img_holder" style="margin-top:15px;max-height:100px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputText">Button text</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="button_text" name="button_text"
                                        value="{{ old('button_text') }}" required>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="inputText">Button url</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="button_url" name="button_url"
                                        value="{{ old('button_url') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="inputText">Description</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="description" rows="3" id="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2   ">
                                <label for="inputText">Screen Type</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="media" id="media">
                                        <option value="desktop">Desktop</option>
                                        <option value="mobile">Mobile</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputText">Start Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ old('start_date') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputText">End Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ old('end_date') }}" required>
                                </div>
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
