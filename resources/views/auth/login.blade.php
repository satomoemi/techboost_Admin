@extends('layouts.profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-box card">
                    {{--「__」:ヘルパ関数（viewで使うための関数）の一種で、翻訳文字列の取得として使われる--}}
                    {{--{{ __('◯◯') }}のmessagesの部分はファイル名ね--}}
                    <div class="login-header card-header mx-auto">{{ __('messages.Login') }}</div>

                    <div class="login-body card-body">
                        {{--route関数は、URLを生成したりリダイレクトしたりするため,今回であれば、”/login”というURLを生成--}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('messages.E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    {{--三項演算子とは、if文を一行(<条件式> ? <真式> : <偽式>),is-invalid:入力部品が異常値,is-valid:正常値--}}
                                    {{--$errorsというのは、Validationで返された時に代入されるメッセージが格納されている,has(‘email’):emailフィールドでエラーが起きているとその内容を取得できる--}}
                                    {{--{{ old('email') }}:入力してエラーが出て、その入力したものが全部消えてしまうのを防ぐ--}}
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                    {{--invalid-feedback:異常時のフィードバックメッセージを表示--}}
                                        <span class="invalid-feedback">
                                            {{--strongタグ：文字を太字にして強調することができる--}}
                                            {{-- $errors->first:特定のエラーの取得※配列形式で結果が返ってくるため、first()で最初のものを取得する）--}}
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('messages.Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection