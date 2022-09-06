@extends('layouts.guest')

@section('content')
    <section class="min-vh-50 mb-4">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('{{ asset('/assets/img/curved-images/curved14.jpg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">Use these awesome forms to login or create new account.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Register here</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <input id="name" placeholder="Name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" aria-label="Name"
                                        aria-describedby="email-addon" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Email" aria-label="Email"
                                        aria-describedby="email-addon" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password" class="form-control" placeholder="Password"
                                        aria-label="Password" aria-describedby="password-addon"
                                        required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" aria-label="Password" aria-describedby="password-addon">
                                </div>
                                <div class="form-check form-check-info text-left">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree that <span class="text-dark font-weight-bolder">Maral makes good
                                            job!</span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign
                                        up</button>
                                </div>
                                <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                        class="text-dark font-weight-bolder">Sign in</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection