<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgUrlToCooperationTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cooperation', function (Blueprint $table)
        {
            $table->string('img_url')->comment('图片地址');
            $table->string('name')->comment('名称');
            $table->string('summary')->comment('摘要');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cooperation', function (Blueprint $table)
        {
            //
        });
    }
}
