<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = array('id');
    //
    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' => 'required',
    );
    
    public function histories()
    {
      //hasMany主テーブルのあるレコードに対して、従テーブルの複数のレコードが紐付けるとき使う
      return $this->hasMany('App\ProfileHistory');

    }
}
