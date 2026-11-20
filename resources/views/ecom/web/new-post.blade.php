@extends('ecom.web.layouts.app')

@section('meta')
    <title>Shopping Cart - ShriVenu Naturals</title>
    <meta name="keywords"
        content="shopping cart, ShriVenu Naturals cart, view cart, check out, shopping bag">
    <meta name="description"
        content="Review your selected items in the shopping cart at ShriVenu Naturals. Easily manage your purchases, add or remove items, and proceed to checkout to complete your order. Shop now for natural wellness products and enjoy a seamless shopping experience!">
@endsection

@section('styles')
    <style>
        .mt-40 {
            margin-top: 40px;
        }
    </style>

    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .checkout-page {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        #editor {
            height: 300px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
    </style>

@endsection

@section('content')
    <main id="MainContent" class="content-for-layout">
        <div class="checkout-page mt-40">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="text-center mb-4">Create New Post</h2>

                        @include('ecom.web.layouts.messages')

                        <form action="{{route('shop.post-store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Post
                                    Title</label>
                                <input type="text" class="form-control"
                                    id="postTitle" name="postTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="postContent"
                                    class="form-label">Post Content</label>
                                <div id="editor"></div>
                                <input type="hidden" name="content"
                                    id="hiddenInput">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit"
                                    class="btn btn-primary">Submit
                                    Post</button>

                                <a href="{{route('shop.index')}}"
                                    class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('ecom/admin/ckeditor.js') }}"></script>
    <!--  include CKEDITOR js -->
    <script src="{{ asset('ecom/admin/useckeditor.js') }}"></script>
    <script>
        // window.history.forward();
        $(document).ready(function() {
            // Disable the back button
            window.history.pushState(null, "", window
                .location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "",
                    window.location.href);
            };
        });
    </script>
@endsection
