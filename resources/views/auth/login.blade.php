<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Tinta plana ediciones, es una editorial con sede en la ciudad de Cochabamba, nos enfocamos en coadyuvar a distintos autores en su auto-publicación de sus obras literarias." />
    <meta name="keywords" content="Error page 404, page not found design, wrong url" />
    <meta name="author" content="Ashishmaraviya" />
    <title>Tintaplana</title>
    <!--Google font-->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="login1/assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="login1/assets/css/fontawesome.css" />
    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="login1/assets/css/login.css" />
</head>

<body>
    <!-- 01 Preloader -->
    <div class="loader-wrapper" id="loader-wrapper">
        <div class="loader"></div>
    </div>
    <!-- Preloader end -->
    <!-- 02 Main page -->
    <section class="page-section login-page">
        <div class="full-width-screen">
            <div class="container-fluid p-0">
                <div class="content-detail p-0">
                    <!-- Login form -->
                    <form class="login-form" method="POST" action="{{ route('login') }}">

                        <div class="blobs_1"></div>
                        <div class="blobs_2"></div>
                        <div class="blobs_5"></div>
                        <div class="blobs_6"></div>
                        <div class="blobs_7"></div>
                        <div class="imgcontainer">
                            <img src="login1/assets/images/logo.png" alt="Avatar" class="avatar" />
                        </div>
                        <div class="input-control">
                            @csrf
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus placeholder="Correo Electronico">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="password-field-show">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="Contraseña">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </span>

                            <div class="login-btns">
                                <button type="submit"> {{ __('Login') }}</button>
                            </div>
                            <div class="division-lines">
                                <p>Bienvenido</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- latest jquery-->
    <script src="login1/assets/js/jquery-3.5.1.min.js"></script>
    <!-- Theme js-->
    <script src="login1/assets/js/script.js"></script>
</body>

</html>
