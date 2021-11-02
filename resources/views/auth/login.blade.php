<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Chico">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    <form class="form-signin" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-signin-heading text-center">
            <img style="max-width: 200px" src="{{asset('img/icon-with-text.svg')}}" alt=""/>
        </div>
        <div class="login-wrap">
            @if($errors->first('password'))
                <div class="alert alert-block alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    {{$errors->first('password')}}
                </div>
            @endif
            
            <x-jet-input id="username" class="form-control" type="text" name="username" :value="old('username')" placeholder="Username/Email" required autofocus />
            <x-jet-input id="password" class="form-control" type="password" name="password" placeholder="Password" required autocomplete="current-password" />

            <button class="btn btn-lg btn-login btn-block" type="submit">
                <i class="fa fa-check"></i>
            </button>

            
            

        </div>

    </form>

</div>



<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>

</body>
</html>

