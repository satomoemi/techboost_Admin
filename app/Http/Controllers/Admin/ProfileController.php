<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;


class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Profile::$rules);
        $profile = new Profile;
        $form = $request->all();
        // フォームから送信されてきた_tokenを削除する{{csrf_field ()}}があり、csrf対策用のトークンが送られてきますがデータベースへ保存するときにいらないので、ここで削除しています。
        unset($form['_token']);
        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
  {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            $posts = Profile::where('name', $cond_title)->get(); 
    } else { 
        $posts = Profile::all();
    }
    return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
    
    public function edit(Request $request)
    {
         $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
        return view('admin.profile.edit',['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id); 
        $profile_form = $request->all();
        
        unset($profile_form['_token']);
        
        $profile->fill($profile_form)->save();
        
        //Profile Modelを保存するタイミングで、同時に History Modelにも編集履歴を追加するよう実装する
        $history = new ProfileHistory;
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();
        
        return redirect('admin/profile/');
    }
    
     //データの削除
    public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $profile = Profile::find($request->id);
      // delete()メソッド 削除する
      $profile->delete();
      return redirect('admin/profile/');
  }  
}
