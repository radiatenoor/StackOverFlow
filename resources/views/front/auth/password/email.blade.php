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
                @include('front.partials._message')
                <form action="{{ route('send.reset.link') }}" method="post">
                    @csrf
                    <h1>StackOverFlow</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Entered Registered Email" name="email" required="" />
                    </div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Send Reset Link</button>
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
