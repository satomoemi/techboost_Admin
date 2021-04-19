<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Profile;


class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $posts = Profile::all();

        

        // profile/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('profile.index', [ 'posts' => $posts]);
    }
}