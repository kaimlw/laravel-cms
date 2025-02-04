<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/app.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <style>
        #auth{
            padding-top: 60px;
        }
    </style>
</head>
<body>
    <div id="auth">
        <div class="container">
            @if (session('showAlert'))
            <div class="alert alert-{{ session('showAlert')['type'] }} alert-dismissible show fade">
                {{ session('showAlert')['msg'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="{{ asset('assets/img/ULM.png') }}" width="60" class='mb-4'>
                                <h3>Laravel CMS</h3>
                                <p>Silakan masukan username dan password anda untuk masuk ke dalam dashboard.</p>
                            </div>
                            <form action="{{ route('login.auth') }}" method="POST">
                                @csrf
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <input type="hidden" class="form-control @error('username') is-invalid @enderror" name="">
                                    <div class="position-relative">
                                        <input type="text" autofocus class="form-control @error('username') is-invalid @enderror" id="username" name="username">
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <label for="password">Password</label>
                                    <input type="hidden" class="form-control @error('password') is-invalid @enderror" name="">
                                    <div class="position-relative">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
        
                                <div class='form-check clearfix my-4'>
                                    <div class="checkbox float-left">
                                        <input type="checkbox" id="checkbox1" class='form-check-input' name="rememberCheck">
                                        <label for="checkbox1">Ingat Saya</label>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button class="btn btn-primary float-right">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/admin/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/main.js') }}"></script>
</body>
</html>