<!DOCTYPE html>
<html lang="en">
<head>
   @include('front.partials._head')
</head>

<body class="login">
<div>

    <div class="login_wrapper">
        <div>
            <section class="login_content">
                @component('back.components.message')@endcomponent
                <form action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <h1>Admin Login</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required="" />
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" name="password" required="" />
                    </div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Log in</button>
                        <a class="reset_pass" href="{{url('admin/password/reset/form')}}">Lost your password?</a>
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
