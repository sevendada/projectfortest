<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>ProjectTest</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            @if (Route::has('login'))
                <div class="row" style="position: absolute;top: 8px;right: 16px;font-size: 18px;">
                    @auth
                        <a href="{{ route('manage')}}">จัดการสินค้า</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="row" >
            <table border="2" width="800px" style="position: absolute;
            top: 20%;
            width: 100%;
            text-align: center;
            font-size: 18px;">
                <tr>
                    <td>1</td><td>2</td><td>3</td><td>4</td>
                </tr>
            </table>
        </div>
        </div>
    </div>
</body>
</html>
