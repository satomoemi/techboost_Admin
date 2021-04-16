@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        @if (!is_null($posts))
            <div class="row">
                <div class="headline col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="caption mx-auto">
                                <div class="title p-2">
                                    <h1>Name：{{ str_limit($posts->name, 70) }}</h1>
                                </div>
                            </div>
                                <div class="gender">
                                    <h5>Gender：{{ str_limit($posts->gender, 70) }}</h1>
                                </div>
                                <div class="hobby">
                                    <h5>Hobby：{{ str_limit($posts->hobby, 70) }}</h1>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <p class="body mx-auto">Introduction：{{ str_limit($posts->introduction, 650) }}</p>
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
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="title">
                                    Name：{{ str_limit($post->name, 150) }}
                                </div>
                                <div class="gender">
                                    Gender：{{ str_limit($post->gender, 150) }}
                                </div>
                                <div class="hobby">
                                    Hobby：{{ str_limit($post->hobby, 150) }}
                                </div>
                                <div class="body mt-3">
                                    Introduction：{{ str_limit($post->introduction, 1500) }}
                                </div>
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