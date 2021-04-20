{{-- @extends:継承するレイアウトを指定する layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')
{{-- @section:Bladeレイアウトを拡張するビュー admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'ニュースの新規作成')
{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            {{--col-md-8:画面サイズに応じてカラムの割合を変更できる md (Medium:タブレットサイズ)--}}
            {{--mx-auto:コンテンツの中央寄せ--}}
            <div class="col-md-8 mx-auto">
                <h2>ニュース新規作成</h2>
                {{--<form>タグにおける”action”は送信先を指定するためのもの--}}
                <form action="{{ action('Admin\NewsController@create') }}" method="post" enctype="multipart/form-data">

            {{--$errors:validateを設定するとエラーメッセージを操作する便利な$errorsが自動的に作成され、全てのビューで使用できる--}}
                    {{--countメソッドは配列の個数を返すメソッド--}}
                    @if (count($errors) > 0)
                        <ul>
                {{--foreachは配列の数だけループする構文.$errors->all()ですべてのエラーの取得し、その中身を$eに代入$eに代入された中身を下記の文で表示--}}
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    
                    <div class="form-group row">
                        <label class="col-md-2" for="title">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">本文</label>
                        <div class="col-md-10">
                 {{--old('変数名'):入力してエラーが出て、その入力したものが全部消えてしまうのを防ぐ。残しておく--}}
                            <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="title">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
            </div>
        </div>
    </div>
@endsection