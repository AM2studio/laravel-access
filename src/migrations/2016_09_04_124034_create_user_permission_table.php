<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references(config('access.user_primary_key'))->on(config('access.user_table'))
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('permission_id');
            $table->foreign('permission_id')
                ->references('id')->on('permissions')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('model_id');
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
        Schema::dropIfExists('user_permission');
    }
}
