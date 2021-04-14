<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id');//主キー
            $table->integer('news_id');//外部キー(必ず単数形の名前にする)/newsレコードのidのデータを代入して関連付けをしてる/integerデータが文字列でもこのキャストを使うことで型を数字にすることができる
            $table->string('edited_at');//stringデータを文字列化するキャスト
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
