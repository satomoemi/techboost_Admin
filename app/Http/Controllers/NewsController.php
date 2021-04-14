<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // News::all():すべてのnewsテーブルを取得するというメソッド
        //sortByDesc('updated_at'):投稿日時順に新しい方から並べるという並べ換えをしていることを意味
        //updated_at:$table->timestamps();がupdated_atカラム追加してる
        $posts = News::all()->sortByDesc('updated_at');

        if (count($posts) > 0) {
            //shift()メソッドは、配列の最初のデータを削除し,その値を返す
            //最新の記事を変数$headlineに代入し、$postsは代入された最新の記事以外の記事が格納されていることになる
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}
