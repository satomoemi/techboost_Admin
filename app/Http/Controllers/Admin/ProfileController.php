<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

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
        $profiles = new Profile;
        $form = $request->all();
        // フォームから送信されてきた_tokenを削除する{{csrf_field ()}}があり、csrf対策用のトークンが送られてきますがデータベースへ保存するときにいらないので、ここで削除しています。
        unset($form['_token']);
        // データベースに保存する
        $profiles->fill($form);
        $profiles->save();
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
         $profiles = Profile::find($request->id);
      if (empty($profiles)) {
        abort(404);    
      }
        return view('admin.profile.edit',['profiles_form' => $profiles]);
    }
    
    public function update()
    {
        return redirect('admin/profile/edit');
    }
}
