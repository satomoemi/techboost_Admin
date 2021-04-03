<?php //modelのファイルだよ、validetion設定

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = array('id');
    
    //追記
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
}
