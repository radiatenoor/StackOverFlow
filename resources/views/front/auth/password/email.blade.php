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
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

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
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
