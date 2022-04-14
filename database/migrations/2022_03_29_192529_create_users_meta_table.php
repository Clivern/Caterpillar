<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersMetaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users_meta', function (Blueprint $table) {
            $table->id();
            $table->string('meta_key')->index();
            $table->text('meta_value');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users_meta');
    }
}
