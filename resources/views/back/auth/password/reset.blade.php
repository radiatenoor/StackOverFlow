<!DOCTYPE html>
<html lang="en">
<head>
    @include('back.partials._head')
</head>

<body class="login">
<div>

    <div class="login_wrapper">
        <div>
            <section class="login_content">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('admin.password.request') }}" method="post">
                    @csrf
                    <h1>Admin Pass Reset</h1>

                    <div>
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="text" class="form-control" placeholder="Email" name="email"
                               value="{{ $email or old('email') }}" required="" autofocus />
                    </div>
                    <div>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Reset Password</button>
                    </div>
                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
