<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToHomeworksTable extends Migration
{
    public function up()
    {
        Schema::table('homeworks', function (Blueprint $table) {
            
            $table->unsignedBigInteger('user_id')->after('id');
            
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('homeworks', function (Blueprint $table) {
            
            $table->dropForeign(['user_id']);
            
            $table->dropColumn('user_id');
        });
    }
}
