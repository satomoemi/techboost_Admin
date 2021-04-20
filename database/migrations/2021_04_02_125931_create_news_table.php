<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     // title と body と image_path を追記
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {//Blueprintオブジェクトのメソッドでカラムを定義する。カラムの型名が、そのままメソッド名になっている
            $table->bigIncrements('id');//主キーのデフォルト
            $table->string('title'); // ニュースのタイトルを保存するカラム
            $table->string('body');  // ニュースの本文を保存するカラム
            $table->string('image_path')->nullable();  // 画像のパスを保存するカラム//->nullable():画像のパスは空でも保存できますという意味
            $table->timestamps(); //NULL値可能なcreated_atとupdated_atカラム追加という二つのカラムを生成


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}