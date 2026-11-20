@extends('ecom.web.layouts.app')

@section('meta')
    <title>Posts - Junior-G: Baby Products & Baby Foods</title>
    <meta name="description"
        content="Explore informative articles and tips about baby products and baby foods on Junior-G. Stay updated with the latest trends and recommendations for your little ones.">
    <meta name="keywords"
        content="baby products, baby foods, baby care, parenting tips, newborn essentials, toddler products, infant nutrition">
@endsection

@section('styles')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        .comments-avatar {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        /* Optional: Add a hover effect */
        .comments-avatar:hover {
            opacity: 0.8;
        }

        .mt-20 {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    {{-- @include('ecom.web.layouts.bradcamp') --}}

    <main id="MainContent" class="content-for-layout">
        <div class="article-page mt-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-12 m-auto">
                        <div class="article-meta mb-5 mt-3">
                            <div class="row align-items-center">
                                @if (auth()->guard('customer')->user())
                                    @php
                                        $customer = auth()
                                            ->guard('customer')
                                            ->user();
                                        // Calculate a color based on the first name (you can modify this logic as needed)
                                        $colorIndex =
                                            strlen($customer->name) % 5; // Use the length of first name to determine index
                                        $colors = [
                                            '#007bff',
                                            '#28a745',
                                            '#dc3545',
                                            '#ffc107',
                                            '#17a2b8',
                                        ];
                                        $backgroundColor =
                                            $colors[$colorIndex];
                                    @endphp
                                @endif
                                <div class="col-auto">
                                    @if (auth()->guard('customer')->user())
                                        <div class="comments-avatar"
                                            style="background-color: {{ $backgroundColor }}">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                    @else
                                        <img src="{{ asset('ecom/web/assets/img/blog/user2.png') }}"
                                            alt="customer" class="img-fluid"
                                            style="max-width: 40px;">
                                    @endif
                                </div>
                                <div class="col">
                                    <a href="{{ route('shop.new-post') }}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Post your question or suggestions"
                                                readonly>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @foreach ($posts as $key => $post)
                            <div class="article-rte postd"
                                id="post{{ $key + 1 }}">

                                <div class="article-meta">
                                    <h2 class="article-title">
                                        {{ $post->title }}
                                    </h2>
                                    <div class="article-content mt-3"
                                        id="article-content{{ $key + 1 }}">
                                        {!! $post->body !!}
                                    </div>

                                    <!-- Button to expand/collapse content -->
                                    <button class="btn btn-primary mt-3"
                                        id="showMoreBtn{{ $key + 1 }}">Show
                                        more</button>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                class="article-card-published text_14 d-flex align-items-center">
                                                <a href="javascript:void(0)"
                                                    class="article-date d-flex align-items-center">
                                                    <span class="icon-publish">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            width="20"
                                                            height="19"
                                                            fill="currentColor"
                                                            class="bi bi-hand-thumbs-up"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <span
                                                    class="article-separator mx-3">
                                                    <svg width="2"
                                                        height="12"
                                                        viewBox="0 0 2 12"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.4"
                                                            d="M1.09761 0.5H0V11.5H1.09761V0.5Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <a href="javascript:void(0)"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $key + 1 }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseTwo"
                                                    class="article-date d-flex align-items-center">
                                                    <span class="icon-publish">
                                                        <svg width="20"
                                                            height="19"
                                                            viewBox="0 0 20 19"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.347656 0.5V15.5H7.53711L10.0977 18.0605L12.6582 15.5H19.8477V0.5H0.347656ZM1.84766 2H18.3477V14H12.0371L10.0977 15.9395L8.1582 14H1.84766V2ZM4.84766 4.25V5.75H15.3477V4.25H4.84766ZM4.84766 7.25V8.75H15.3477V7.25H4.84766ZM4.84766 10.25V11.75H12.3477V10.25H4.84766Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div
                                                class="share-area mt-2 d-flex float-end">
                                                <ul
                                                    class="list-unstyled share-list d-flex align-items-center mb-1 flex-wrap">
                                                    <li class="share-item">
                                                        <a class="facebook"
                                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}">
                                                            <svg width="9"
                                                                height="16"
                                                                viewBox="0 0 9 16"
                                                                fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M8.17383 9.3125L8.58398 6.61719H5.97656V4.85938C5.97656 4.09766 6.32812 3.39453 7.5 3.39453H8.70117V1.08008C8.70117 1.08008 7.61719 0.875 6.5918 0.875C4.45312 0.875 3.04688 2.19336 3.04688 4.53711V6.61719H0.644531V9.3125H3.04688V15.875H5.97656V9.3125H8.17383Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li class="share-item">

                                                        <a class="instagram"
                                                            href="https://www.instagram.com/">
                                                            <svg width="20"
                                                                height="20"
                                                                viewBox="0 0 20 20"
                                                                fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.1452 6.62529C17.1452 6.79391 17.1452 6.94848 17.1452 7.08899C17.1452 8.35363 16.9063 9.60422 16.4286 10.8407C15.9789 12.0492 15.3185 13.1593 14.4473 14.171C13.6042 15.1827 12.4941 16.0117 11.1171 16.6581C9.76815 17.2763 8.27869 17.5855 6.64871 17.5855C4.59719 17.5855 2.71429 17.0375 1 15.9415C1.28103 15.9696 1.57611 15.9836 1.88525 15.9836C3.59953 15.9836 5.13115 15.4637 6.48009 14.4239C5.66511 14.3958 4.93443 14.1429 4.28806 13.6651C3.66979 13.1874 3.24824 12.5831 3.02342 11.8525C3.24824 11.9087 3.47307 11.9368 3.69789 11.9368C4.03513 11.9368 4.35831 11.8806 4.66745 11.7681C3.82436 11.5995 3.12178 11.178 2.55972 10.5035C1.99766 9.82904 1.71663 9.05621 1.71663 8.18501C1.71663 8.15691 1.71663 8.14286 1.71663 8.14286C2.25059 8.42389 2.81265 8.57845 3.40281 8.60656C2.30679 7.84777 1.75878 6.82201 1.75878 5.52927C1.75878 4.8548 1.9274 4.23653 2.26464 3.67447C3.19204 4.79859 4.30211 5.69789 5.59485 6.37237C6.91569 7.04684 8.33489 7.42623 9.85246 7.51054C9.79625 7.22951 9.76815 6.94848 9.76815 6.66745C9.76815 5.65574 10.1194 4.79859 10.822 4.09602C11.5527 3.36534 12.4239 3 13.4356 3C14.5035 3 15.4028 3.37939 16.1335 4.13817C16.9766 3.96956 17.7635 3.67447 18.4941 3.25293C18.2131 4.12412 17.6651 4.79859 16.8501 5.27635C17.6089 5.19204 18.3255 5.00937 19 4.72834C18.4941 5.45902 17.8759 6.09133 17.1452 6.62529Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </a>
                                                    </li>

                                                    <li class="share-item">
                                                        <a class="twitter"
                                                            href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}">
                                                            <svg width="20"
                                                                height="20"
                                                                viewBox="0 0 20 20"
                                                                fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M9.99998 2.62165C12.4031 2.62165 12.6877 2.6308 13.6367 2.6741C14.5142 2.71415 14.9908 2.86077 15.3079 2.98398C15.728 3.14725 16.0278 3.34231 16.3428 3.65723C16.6577 3.97215 16.8528 4.272 17.016 4.69206C17.1392 5.00923 17.2859 5.48577 17.3259 6.36323C17.3692 7.31228 17.3783 7.5969 17.3783 10C17.3783 12.4031 17.3692 12.6878 17.3259 13.6368C17.2859 14.5143 17.1392 14.9908 17.016 15.308C16.8528 15.728 16.6577 16.0279 16.3428 16.3428C16.0278 16.6577 15.728 16.8528 15.3079 17.016C14.9908 17.1393 14.5142 17.2859 13.6367 17.3259C12.6879 17.3692 12.4032 17.3784 9.99998 17.3784C7.59672 17.3784 7.3121 17.3692 6.36323 17.3259C5.48574 17.2859 5.00919 17.1393 4.69206 17.016C4.27196 16.8528 3.97212 16.6577 3.6572 16.3428C3.34227 16.0279 3.14721 15.728 2.98398 15.308C2.86073 14.9908 2.71411 14.5143 2.67406 13.6368C2.63076 12.6878 2.62162 12.4031 2.62162 10C2.62162 7.5969 2.63076 7.31228 2.67406 6.36326C2.71411 5.48577 2.86073 5.00923 2.98398 4.69206C3.14721 4.272 3.34227 3.97215 3.6572 3.65723C3.97212 3.34231 4.27196 3.14725 4.69206 2.98398C5.00919 2.86077 5.48574 2.71415 6.36319 2.6741C7.31224 2.6308 7.59687 2.62165 9.99998 2.62165ZM9.99998 1C7.55571 1 7.24926 1.01036 6.28931 1.05416C5.33133 1.09789 4.67712 1.25001 4.10462 1.47251C3.51279 1.70251 3.01088 2.01025 2.51055 2.51058C2.01021 3.01092 1.70247 3.51283 1.47247 4.10466C1.24997 4.67716 1.09785 5.33137 1.05412 6.28935C1.01032 7.24926 1 7.55575 1 10C1 12.4443 1.01032 12.7508 1.05412 13.7107C1.09785 14.6687 1.24997 15.3229 1.47247 15.8954C1.70247 16.4872 2.01021 16.9891 2.51055 17.4895C3.01088 17.9898 3.51279 18.2975 4.10462 18.5275C4.67712 18.75 5.33133 18.9021 6.28931 18.9459C7.24926 18.9897 7.55571 19 9.99998 19C12.4443 19 12.7507 18.9897 13.7107 18.9459C14.6686 18.9021 15.3228 18.75 15.8953 18.5275C16.4872 18.2975 16.9891 17.9898 17.4894 17.4895C17.9898 16.9891 18.2975 16.4872 18.5275 15.8954C18.75 15.3229 18.9021 14.6687 18.9458 13.7107C18.9896 12.7508 19 12.4443 19 10C19 7.55575 18.9896 7.24926 18.9458 6.28935C18.9021 5.33137 18.75 4.67716 18.5275 4.10466C18.2975 3.51283 17.9898 3.01092 17.4894 2.51058C16.9891 2.01025 16.4872 1.70251 15.8953 1.47251C15.3228 1.25001 14.6686 1.09789 13.7107 1.05416C12.7507 1.01036 12.4443 1 9.99998 1ZM9.99998 5.37838C7.44753 5.37838 5.37835 7.44757 5.37835 10C5.37835 12.5525 7.44753 14.6217 9.99998 14.6217C12.5524 14.6217 14.6216 12.5525 14.6216 10C14.6216 7.44757 12.5524 5.37838 9.99998 5.37838ZM9.99998 13C8.34314 13 6.99996 11.6569 6.99996 10C6.99996 8.34317 8.34314 7 9.99998 7C11.6568 7 13 8.34317 13 10C13 11.6569 11.6568 13 9.99998 13ZM15.8842 5.19579C15.8842 5.79226 15.4007 6.27581 14.8042 6.27581C14.2077 6.27581 13.7242 5.79226 13.7242 5.19579C13.7242 4.59931 14.2077 4.1158 14.8042 4.1158C15.4007 4.1158 15.8842 4.59931 15.8842 5.19579Z"
                                                                    fill="black" />
                                                            </svg>

                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapse{{ $key + 1 }}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $key + 1 }}">
                                    <div
                                        class="accordion-body comment-form-area">
                                        @include('ecom.web.layouts.messages')
                                        <form
                                            id="comment-form{{ $key + 1 }}"
                                            action="{{ route('shop.post-comment') }}"
                                            method="POST"
                                            class="comment-form">
                                            @csrf <!-- Add CSRF token -->
                                            <input type="hidden"
                                                name="post_id"
                                                value="{{ $post->id }}">
                                            <div
                                                class="field-item textarea-field">
                                                <textarea cols="20" rows="3" name="comment"
                                                    placeholder="Write your comment here........"></textarea>
                                            </div>
                                            <!-- Change the type of button to 'button' -->
                                            <button type="button"
                                                class="position-relative review-submit-btn mt-4"
                                                onclick="submitComment('{{ $key + 1 }}')">SUBMIT</button>
                                        </form>
                                    </div>

                                    <div
                                        class="comments-section mt-20 home-section overflow-hidden">
                                        <div class="section-header">
                                            <h3 class="">Comments -
                                                {{ count($post->comments) }}
                                            </h3>
                                        </div>

                                        @foreach ($post->comments as $comment)
                                            @if ($comment->customer)
                                                @php
                                                    $customer =
                                                        $comment->customer;

                                                    $colorIndex =
                                                        strlen(
                                                            $customer->name,
                                                        ) % 5; // Use the length of first name to determine index
                                                    $colors = [
                                                        '#007bff',
                                                        '#28a745',
                                                        '#dc3545',
                                                        '#ffc107',
                                                        '#17a2b8',
                                                    ];
                                                    $backgroundColor =
                                                        $colors[
                                                            $colorIndex
                                                        ];
                                                @endphp
                                            @endif

                                            <div class="comments-area">
                                                <div
                                                    class="d-flex comments-item">
                                                    <div class="comments-img">
                                                        @if ($comment->customer)
                                                            <div class="comments-avatar"
                                                                style="background-color: {{ $backgroundColor }}">
                                                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                            </div>
                                                        @else
                                                            <img src="{{ asset('ecom/web/assets/img/blog/user2.png') }}"
                                                                alt="customer"
                                                                class="img-fluid"
                                                                style="max-width: 40px;">
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="comments-main">
                                                        <div
                                                            class="comments-main-content">
                                                            <div
                                                                class="comments-meta">
                                                                <h4
                                                                    class="commentator-name">
                                                                    {{ $customer->name }}
                                                                    {{ $comment->id }}
                                                                </h4>
                                                                <div
                                                                    class="comments-date article-date d-flex align-items-center">
                                                                    <span
                                                                        class="icon-publish">
                                                                        <svg width="17"
                                                                            height="18"
                                                                            viewBox="0 0 17 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M3.46875 0.875V1.59375H0.59375V17.4063H16.4063V1.59375H13.5313V0.875H12.0938V1.59375H4.90625V0.875H3.46875ZM2.03125 3.03125H3.46875V3.75H4.90625V3.03125H12.0938V3.75H13.5313V3.03125H14.9688V4.46875H2.03125V3.03125ZM2.03125 5.90625H14.9688V15.9688H2.03125V5.90625ZM6.34375 7.34375V8.78125H7.78125V7.34375H6.34375ZM9.21875 7.34375V8.78125H10.6563V7.34375H9.21875ZM12.0938 7.34375V8.78125H13.5313V7.34375H12.0938ZM3.46875 10.2188V11.6563H4.90625V10.2188H3.46875ZM6.34375 10.2188V11.6563H7.78125V10.2188H6.34375ZM9.21875 10.2188V11.6563H10.6563V10.2188H9.21875ZM12.0938 10.2188V11.6563H13.5313V10.2188H12.0938ZM3.46875 13.0938V14.5313H4.90625V13.0938H3.46875ZM6.34375 13.0938V14.5313H7.78125V13.0938H6.34375ZM9.21875 13.0938V14.5313H10.6563V13.0938H9.21875Z"
                                                                                fill="#00234D" />
                                                                        </svg>
                                                                    </span>
                                                                    <span
                                                                        class="ms-2">
                                                                        {{ date('d F, Y', strtotime($comment->created_at)) }}
                                                                    </span>
                                                                </div>
                                                                <p
                                                                    class="comments">
                                                                    {{ $comment->comment }}
                                                                </p>
                                                            </div>
                                                            <button
                                                                type="button"
                                                                class="btn-reply bg-transparent d-flex align-items-center"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $comment->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ $comment->id }}">
                                                                <span
                                                                    class="btn-reply-icon me-2">
                                                                    <svg width="16"
                                                                        height="16"
                                                                        viewBox="0 0 16 16"
                                                                        fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.14062 2.64062L1.14062 6.64062L0.796875 7L1.14062 7.35938L5.14062 11.3594L5.85938 10.6406L2.21875 7L5.85938 3.35938L5.14062 2.64062ZM7.64062 2.64062L3.64062 6.64062L3.29688 7L3.64062 7.35938L7.64062 11.3594L8.35938 10.6406L5.21875 7.5H11.5C12.8867 7.5 14 8.61328 14 10C14 11.3867 12.8867 12.5 11.5 12.5V13.5C13.4277 13.5 15 11.9277 15 10C15 8.07227 13.4277 6.5 11.5 6.5H5.21875L8.35938 3.35938L7.64062 2.64062Z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <span
                                                                    class="btn-reply-text">Reply</span>
                                                            </button>



                                                            <div id="replyacoordian{{ $comment->id }}">
                                                                <div id="collapse{{ $comment->id }}"
                                                                     class="accordion-collapse collapse"
                                                                     aria-labelledby="heading{{ $comment->id }}"
                                                                     data-bs-parent="#replyacoordian{{ $comment->id }}">
                                                                    <div class="accordion-body">
                                                                        <div class="accordion-body comment-form-area">
                                                                            @include('ecom.web.layouts.messages')
                                                                            <form id="comment-reply-form{{ $comment->id }}"
                                                                                  action="{{ route('shop.post-comment') }}"
                                                                                  method="POST"
                                                                                  class="comment-reply-form">
                                                                                @csrf
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                                                    <div class="field-item textarea-field">
                                                                                        <textarea cols="20" rows="3" name="comment" placeholder="Write your comment here........"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="button" class="btn btn-primary" onclick="replyComment('{{ $comment->id }}')">Submit</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="rply"
                                                            id="rply{{ $comment->id }}">
                                                            @foreach ($comment->replies as $reply)
                                                                @if ($reply->customer)
                                                                    @php
                                                                        $customer =
                                                                            $reply->customer;

                                                                        $colorIndex =
                                                                            strlen(
                                                                                $customer->name,
                                                                            ) %
                                                                            5; // Use the length of first name to determine index
                                                                        $colors = [
                                                                            '#007bff',
                                                                            '#28a745',
                                                                            '#dc3545',
                                                                            '#ffc107',
                                                                            '#17a2b8',
                                                                        ];
                                                                        $backgroundColor =
                                                                            $colors[
                                                                                $colorIndex
                                                                            ];
                                                                    @endphp
                                                                @endif
                                                                <div
                                                                    class="comments-replied">
                                                                    <div
                                                                        class="d-flex comments-item">
                                                                        <div
                                                                            class="comments-img">
                                                                            @if ($comment->customer)
                                                                                <div class="comments-avatar"
                                                                                    style="background-color: {{ $backgroundColor }}">
                                                                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                                                </div>
                                                                            @else
                                                                                <img src="{{ asset('ecom/web/assets/img/blog/user2.png') }}"
                                                                                    alt="customer"
                                                                                    class="img-fluid"
                                                                                    style="max-width: 40px;">
                                                                            @endif
                                                                        </div>
                                                                        <div
                                                                            class="comments-main">
                                                                            <div
                                                                                class="comments-meta">
                                                                                <h4
                                                                                    class="commentator-name">
                                                                                    {{ucfirst($customer->name)}}
                                                                                </h4>
                                                                                <div
                                                                                    class="comments-date article-date d-flex align-items-center">
                                                                                    <span
                                                                                        class="icon-publish">
                                                                                        <svg width="17"
                                                                                            height="18"
                                                                                            viewBox="0 0 17 18"
                                                                                            fill="none"
                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                            <path
                                                                                                d="M3.46875 0.875V1.59375H0.59375V17.4063H16.4063V1.59375H13.5313V0.875H12.0938V1.59375H4.90625V0.875H3.46875ZM2.03125 3.03125H3.46875V3.75H4.90625V3.03125H12.0938V3.75H13.5313V3.03125H14.9688V4.46875H2.03125V3.03125ZM2.03125 5.90625H14.9688V15.9688H2.03125V5.90625ZM6.34375 7.34375V8.78125H7.78125V7.34375H6.34375ZM9.21875 7.34375V8.78125H10.6563V7.34375H9.21875ZM12.0938 7.34375V8.78125H13.5313V7.34375H12.0938ZM3.46875 10.2188V11.6563H4.90625V10.2188H3.46875ZM6.34375 10.2188V11.6563H7.78125V10.2188H6.34375ZM9.21875 10.2188V11.6563H10.6563V10.2188H9.21875ZM12.0938 10.2188V11.6563H13.5313V10.2188H12.0938ZM3.46875 13.0938V14.5313H4.90625V13.0938H3.46875ZM6.34375 13.0938V14.5313H7.78125V13.0938H6.34375ZM9.21875 13.0938V14.5313H10.6563V13.0938H9.21875Z"
                                                                                                fill="#00234D" />
                                                                                        </svg>
                                                                                    </span>
                                                                                    <span
                                                                                        class="ms-2">{{ date('d F, Y', strtotime($reply->created_at)) }}</span>
                                                                                </div>
                                                                                <p
                                                                                    class="comments">
                                                                                    {{$reply->comment}}
                                                                                </p>
                                                                            </div>
                                                                            {{-- <button
                                                                                type="button"
                                                                                class="btn-reply bg-transparent d-flex align-items-center">
                                                                                <span
                                                                                    class="btn-reply-icon me-2">
                                                                                    <svg width="16"
                                                                                        height="16"
                                                                                        viewBox="0 0 16 16"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M5.14062 2.64062L1.14062 6.64062L0.796875 7L1.14062 7.35938L5.14062 11.3594L5.85938 10.6406L2.21875 7L5.85938 3.35938L5.14062 2.64062ZM7.64062 2.64062L3.64062 6.64062L3.29688 7L3.64062 7.35938L7.64062 11.3594L8.35938 10.6406L5.21875 7.5H11.5C12.8867 7.5 14 8.61328 14 10C14 11.3867 12.8867 12.5 11.5 12.5V13.5C13.4277 13.5 15 11.9277 15 10C15 8.07227 13.4277 6.5 11.5 6.5H5.21875L8.35938 3.35938L7.64062 2.64062Z"
                                                                                            fill="black" />
                                                                                    </svg>
                                                                                </span>
                                                                                <span
                                                                                    class="btn-reply-text">Reply</span>
                                                                            </button> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.article-content').each(function(index) {
                var fullContent = $(this)
                    .html(); // Get the full content of this post
                var truncatedContent = fullContent.substring(0,
                    900); // Get first 300 characters

                // Display truncated content initially
                $(this).html(truncatedContent);

                // Show full content when "Show more" button is clicked for this post
                $('#showMoreBtn' + (index + 1)).click(
                    function() {
                        $(this).closest('.article-rte')
                            .find('.article-content').html(
                                fullContent
                            ); // Show full content for this post
                        $(this)
                            .hide(); // Hide the "Show more" button after expanding for this post
                    });
            });
        });
    </script>


    <script>
        function submitComment(formId) {
            // Get the form data using the formId
            var formData = $('#comment-form' + formId).serialize();

            // Send the AJAX request using the formId
            $.ajax({
                type: 'POST',
                url: $('#comment-form' + formId).attr(
                    'action'), // Get the form action URL
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Get CSRF token from meta tag
                },
                success: function(response) {
                    // Handle the successful response
                    var comment = response.comment;
                    if (response.code == 200) {

                        // reset input fields
                        $('#comment-form' + formId).trigger(
                            'reset'
                        );

                        // Reload or refresh the parent div after form submission
                        var parentDivId = $('#comment-form' +
                            formId).closest('.postd').attr(
                            'id');

                        $('#' + parentDivId).load(location.href +
                            ' #' + parentDivId
                        ); // Reload the parent div

                        // append comment in the div class comments-section
                    } else {
                        // Display error message
                        alert(response.message);
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error
                    console.error(error);
                    // You can display an error message here
                }
            });
        }

        function replyComment(formId) {
            console.log(formId);
            // Get the form data using the formId
            var formData = $('#comment-reply-form' + formId).serialize();

            console.log(formData);

            // Send the AJAX request using the formId
            $.ajax({
                type: 'POST',
                url: $('#comment-reply-form' + formId).attr(
                    'action'), // Get the form action URL
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Get CSRF token from meta tag
                },
                success: function(response) {
                    console.log(response);
                    // Handle the successful response
                    var comment = response.comment;
                    if (response.code == 200) {

                        // reset input fields
                        $('#comment-reply-form' + formId).trigger(
                            'reset'
                        );

                        // Reload or refresh the parent div after form submission
                        var parentDivId = "rply" + formId;

                        $('#' + parentDivId).load(location.href +
                            ' #' + parentDivId
                        ); // Reload the parent div

                        // append comment in the div class comments-section
                    } else {
                        // Display error message
                        alert(response.message);
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error
                    console.error(error);
                    // You can display an error message here
                }
            });
        }
    </script>
@endsection
