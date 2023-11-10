<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログイン</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" >
    <link href="{{asset('css/signin.css')}}" rel="stylesheet" >
</head>

<body>
    @if(session('login_success'))
    <div>
      {{session('login_success')}}
    </div>
    @endif
  <div>名前:{{Auth::user()->name}}</div>
  <div>メールアドレス:{{Auth::user()->email}}</div>
  <form action="{{route('logout')}}" method="POST">
    @csrf
    <button>ログアウト</button>
  </form>
</body>

</html>
