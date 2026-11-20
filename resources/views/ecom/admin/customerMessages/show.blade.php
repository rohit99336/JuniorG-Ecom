@extends('ecom.admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="card-title">{{ $title }}</h5>
                </div>

                <div class="row text-center">
                    <div class="col-lg-6 mb-2">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $message->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $message->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $message->phone }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Subject</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $message->subject }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-lg-6">
                        <label for="message">
                            <h5>Message</h5>
                        </label>
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control" readonly>{{ $message->message }}</textarea>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h4>Reply</h4>

                        <div id="msg">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach
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

                        <form action="{{ route('ecomadmin.contact-request.update', $message->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label for="reply_name">Name</label>
                                    <input type="text" name="reply_name" id="reply_name" class="form-control"
                                        value="{{ $message->name }}">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label for="reply_email">Email</label>
                                    <input type="email" name="reply_email" id="reply_email" class="form-control"
                                        value="{{ $message->email }}">
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="reply_message" class="my-2">Message</label>
                                    <textarea name="reply_message" id="reply_message" cols="30" rows="10" class="form-control">{{ old('reply_message') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Reply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
