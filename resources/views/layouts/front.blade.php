<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"> {{--PHPで書かれた内容を表示、PHPで書かれた内容を表示する意味 --}}　

    <head>
        <meta charset="utf-8">
        {{--windowsの基本ブラウザであるedgeに対応する記載 --}}
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{--画面幅を小さくしたとき、たとえばスマートフォンで見たときなどに文字や画像の大きさを調整してくれるタグ--}}
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
         {{-- 後の章で説明します --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- @yieldは指定したセッションの内容を表示するために使用 各ページごとにtitleタグを入れるために@yieldで空けておきます。 --}}
        <title>@yield('title')</title>
        <!-- Scripts -->
         {{-- Laravel標準で用意されているJavascriptを読み込みます --}}
         {{--secure_asset(‘ファイルパス’)は、publicディレクトリのパスを返す関数,要するに、「/js/app.js」というパスを生成--}}
        <script src="{{ secure_asset('js/app.js') }}" defer></script>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        {{-- Laravel標準で用意されているCSSを読み込みます --}}
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        {{-- この章の後半で作成するCSSを読み込みます --}}
        <link href="{{ secure_asset('css/front.css') }}" rel="stylesheet">
    </head>
    <body>
        {{--idはそのidが指定されている箇所のみに対応するような操作やスタイルを適用したい場合に使用 classは複数おk--}}
        <div id="app">
            {{-- 画面上部に表示するナビゲーションバーです。 --}}
            {{--nav-expand-{breakpoint}:画面が狭い時はナビゲーションアイコンとして、画面が広い時はナビゲーションバー上にメニューを展開して表示--}}
            <nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
                <div class="container">
                    {{--url(“パス”)は、そのままURLを返すメソッド--}}
                    <a class="navbar-brand" href="{{ url('/') }}">
                   {{--configフォルダのapp.phpの中にあるnameにアクセス 基本的にはアプリケーションの名前「Laravel」が格納されている--}}
                        {{ config('app.name', 'Laravel') }}
                    </a>
    {{--navbar-toggler,data-toggle="collapse",data-target="#...",navbar-toggler-icon,navbar-collapse,navbar-nav,nav-item,nav-link:スマホ表示時の三本ボタン(ハンバーガーメニュー)を作成--}}
                {{--data-toggle="collapse":開閉を切り替える　data-target="#...":ターゲット要素を指定　--}}
                {{--aria-*="..." :読み上げブラウザなどに付加情報を与えるもので、aria-expand="..." :開閉状態(開くとtrueになる)、aria-controls="..." :対象を示す aria-label:説明書きとかを書いてペタっと貼りつけておく目印のこと--}}
                {{--navbar-toggler-icon:ボタンの中の三本線のこと--}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    {{-- navbar-collapse:画面幅が所定のサイズ以下になったときに折りたたまれグルーピングされる--}}
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- .mr-auto:PCからみた右側に最大限のマージンをつける　Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- .ml-auto:PCから見た左側に最大限のマージンをつける　Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                    {{--@guest:現在のユーザーが認証されているか、もしくはゲストであるかを簡単に判定するために使用@guestはユーザーは認証されていなければを指す--}}    
                            @guest
                    {{--route関数は、URLを生成したりリダイレクトしたりするため,今回であれば、”/login”というURLを生成--}}
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
                        @else
                        {{--dropdown,dropdown-toggle:ドロップダウンリスト(下にメニュー)が出てくる--}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{--{{ Auth::user()->id }}:ログイン後に右上に出ている名前を表示してる--}}
                            {{--class="caret":キャレット・アイコンという小さい三角を表示するクラス--}}
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
            
                                {{--display none:スマホとパソコンでHTMLの要素を消したり出したりすることができる--}}
                                {{--method="POST":POSTメソッドで送信させる--}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- ここまでナビゲーションバー --}}
            <main class="py-4">
                {{-- コンテンツをここに入れるため、@yieldで空けておきます。 --}}
                @yield('content')
            </main>
        </div>
    </body>
</html>


