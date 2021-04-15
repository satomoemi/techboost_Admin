{{--ユーザーが読むようのサイトview--}}
@extends('layouts.front')

@section('content')
    <div class="container">
        {{--hr タグ: 水平の横線を引くため--}}
        <hr color="#c0c0c0">
        {{--「!」:否定演算子でtrue、falseを反転する--}}
        {{--is_null():nullであればtrue、それ以外であればfalseを返す--}}
        {{--↓つまり$headlineが空なら飛ばして（実行しない）、データがあれば実行するという意味--}}
        @if (!is_null($headline))
            <div class="row">
                <div class="headline col-md-10 mx-auto">{{--mx-auto:コンテンツの中央寄せ--}}
                    <div class="row">{{--row やcol を用いて、画面をN個のカラムに等分することができる--}}
                        <div class="col-md-6">{{--col-{breakpoint}-{n}:画面サイズに応じてカラムの割合を変更する--}}
                            <div class="caption mx-auto">
                                <div class="image">
                                    @if ($headline->image_path)
                                    {{--asset:「publicディレクトリ」のパスを返すヘルパ,現在のURLのスキーマ（httpかhttps）を使い、アセットへのURLを生成するメソッド--}}
                                    {{--$headline->image_path:保存した画像のファイル名が入っている--}}
                                    {{--↓これで画像が保存されているパスのURLを生成することができた--}}
                                        <img src="{{ asset('storage/image/' . $headline->image_path) }}">
                                    @endif
                                </div>
                                {{--p-2:全てのサイズに対して,全方向のパディングを0.5rem--}}
                                <div class="title p-2">
                                    <h1>{{ str_limit($headline->title, 70) }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="body mx-auto">{{ str_limit($headline->body, 650) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
        {{--formatメソッド:日時の書式を設定,update_atカラムに保存されているデータは、「2018-12-08 08:57:33.0 UTC (+00:00)」という形になっているため,そのまま表示すると見づらい--}}
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="title">
                                    {{ str_limit($post->title, 150) }}
                                </div>
                                <div class="body mt-3">
                                    {{ str_limit($post->body, 1500) }}
                                </div>
                            </div>
                            <div class="image col-md-6 text-right mt-4">
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/image/' . $post->image_path) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection