<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/login.css') }}">
    <title>Login</title>
</head>

<body>
    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <div class="imgcontainer">
            <h2>Login Page</h2>
        </div>
        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email">
            <div class="row">
                @error('email')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                @enderror
            </div>
            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password">
            <div class="row">
                @error('password')
                    <h5 class="alert alert-danger">{{ $message }}</h5>
                @enderror
            </div>
            <center><input type="submit" class="brn brn-success button" value="signUp"></center>

        </div>


    </form>

</body>

</html>
