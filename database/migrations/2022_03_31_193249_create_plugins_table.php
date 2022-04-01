<?php

declare(strict_types=1);

/*
 * Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) clivern <hello@clivern.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('status');
            $table->string('author');
            $table->string('email');
            $table->string('version');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('plugins');
    }
}
