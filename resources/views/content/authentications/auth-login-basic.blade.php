@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo"><img  src="{{ asset('assets/img/logofinance.png') }}" class="sticky-logo" alt="Weza Solutions"></span>


                            </a>
                        </div>
                        <!-- /Logo -->
                        <form class="mb-3" id="login" action="{{ route('api.login') }}" method="post">
                            @csrf
                            <div class="errors"></div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="demo@weza.co.id"
                                    placeholder="Enter your email" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ url('auth/forgot-password-basic') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" value="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
@endsection

@push('page-script')
    <script>
        $('#login').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    console.log(response);
                    $.ajax({
                        url: "{{ route('api.user') }}",
                        headers: {
                            'Authorization': 'Bearer ' + response.token,
                            'Accept': 'application/json'
                        },
                        type: 'GET',
                        success: function(response) {
                            window.location.href = "{{ url('/') }}";
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });

                },
                error: function(response) {
                    if (response.status == 422) {
                        var errors = response.responseJSON.errors;
                        var errorsHtml = '';
                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        $('.errors').append('<div class="alert alert-danger"><ul>' + errorsHtml +
                            '</ul></div>');
                    } else if (response.status == 401) {
                        var errors = response.responseJSON;
                        var errorsHtml = '';
                        $('.errors').html('<div class="alert alert-danger"><ul>' + errors.message +
                            '</ul></div>');
                    }

                }
            });
        });
    </script>
@endpush
