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
                <form action="{{ action('Admin\NewsController@create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
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