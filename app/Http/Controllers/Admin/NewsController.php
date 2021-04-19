<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\News;
use App\History;
//なぜ追記？
use Carbon\Carbon;
use Storage;


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
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public'); //fileメソッドは画像をアップロードする。　storeメソッドどこのフォルダにファイルを保存するか、パスを指定する
        $news->image_path = Storage::disk('s3')->url($path); //$pathの中は「public/image/ハッシュ化されたファイル名」が入っている。basenameメソッドパスではなくファイル名だけ取得する。このファイル名をnewsテーブルのimage_pathに代入する
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
 
    
    // 投稿したニュースの一覧を表示するため
    public function index(Request $request)
  {
      $cond_title = $request->cond_title; //$requestの中のcond_titleの値を$cond_titleに代入している,なければnullが代入
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          //whereメソッドを使うと、newsテーブルの中のtitleカラムで$cond_title（ユーザーが入力した文字）に一致するレコードをすべて取得することができる.取得したテーブルを$posts変数に代入してる
          //where への引数で検索条件を設定している
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
  
  //投稿したニュースを更新/削除 edit Actionは編集画面
    public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      //また View テンプレートにnews_form,という変数を渡している
      return view('admin.news.edit', ['news_form' => $news]);
  }

  //update Actionは編集画面から送信されたフォームデータを処理する
    public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      //リクエスト時に指定されたidを元にどのニュースの編集画面を表示するか決めているため、idの指定がない場合表示するニュースが見つからずabort(404);が呼び出されて、404エラーになる
      $news = News::find($request->id); 
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      //画像を変更した時にエラーにならない方法
      if ($request->remove == 'true') {//remove画像を削除するチェックボックス
          $news_form['image_path'] = null;
      } elseif ($request->file('image')) {
          $path = Storage::disk('s3')->putFile('/',$news_form['image'],'public');
          $news->image_path = Storage::disk('s3')->url($path);
      } else {
          $news_form['image_path'] = $news->image_path;
      }

      unset($news_form['image']);
      unset($news_form['remove']);
      unset($news_form['_token']);

      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      
      //News Modelを保存するタイミングで、同時に History Modelにも編集履歴を追加するよう実装する
        $history = new History;
        $history->news_id = $news->id;
        //時刻を扱うためにCarbonという日付操作ライブラリを使うCarbonを使って取得した現在時刻を、History Modelの edited_at として記録
        $history->edited_at = Carbon::now();
        $history->save();

      return redirect('admin/news');
  }
    //データの削除
    public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = News::find($request->id);
      // delete()メソッド 削除する
      $news->delete();
      return redirect('admin/news/');
  }  

}
