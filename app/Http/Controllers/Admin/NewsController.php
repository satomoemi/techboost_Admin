<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\News;

class NewsController extends Controller
{
    //
    public function add()
    {
        return view('admin.news.create');
    }
    
    //投稿データを保存
    public function create(Request $request) //Requestクラスはブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクトを取得することができる
    {
        // Varidationを行う
      $this->validate($request, News::$rules); //$thisは擬似変数。News::$rulesは、News.phpファイルの$rules変数を呼び出すため
      $news = new News; //newはModelからインスタンス（レコード）を生成するメソッド
      $form = $request->all(); //ユーザーが入力したデータを取得できる
      
      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) { //issetメソッドは引数の中にデータがあるかないかを判断する
        $path = $request->file('image')->store('public/image'); //fileメソッドは画像をアップロードする。　storeメソッドどこのフォルダにファイルを保存するか、パスを指定する
        $news->image_path = basename($path); //$pathの中は「public/image/ハッシュ化されたファイル名」が入っている。basenameメソッドパスではなくファイル名だけ取得する。このファイル名をnewsテーブルのimage_pathに代入する
      } else {
          $news->image_path = null;
      }
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']); //$formには不要な「_token」と「image」というデータが入っている。削除するにはunsetメソッドを使う
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      // データベースに保存する
      $news->fill($form); //fillメソッド配列をカラムに代入する.これで、「title」「body」「image_path」の値にデータを入れることができた
      $news->save(); //saveメソッドデータベースに保存する
        
        return redirect('admin/news/create'); //カリキュラムでは、もう一度newsを投稿するページの「admin/news/create.blade.php」に移動しています。
    }
    
    // 以下を追記:投稿したニュースの一覧を表示するため
  public function index(Request $request)
  {
      $cond_title = $request->cond_title; //$requestの中のcond_titleの値を$cond_titleに代入している,なければnullが代入
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          //newsテーブルの中のtitleカラムで$cond_title（ユーザーが入力した文字）に一致するレコードをすべて取得することができる.取得したテーブルを$posts変数に代入してる
          $posts = News::where('title', $cond_title)->get(); 
      } else {
          // それ以外はすべてのニュースを取得する
          //News Modelを使って、データベースに保存されている、newsテーブルのレコードをすべて取得し、
          //whereメソッドwhereへの引数で検索条件を設定,検索条件となる名前が入力されていない場合は、登録してあるすべてのデータを取得
          $posts = News::all(); 
      }
      //index.blade.phpのファイルに取得したレコード（$posts）と、ユーザーが入力した文字列（$cond_title）を渡し、ページを開く
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }

}
