<?php

declare(strict_types=1);

/*
 * This file is part of Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsStatusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jobs_status', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 100)->index();
            $table->string('status', 30);
            $table->string('type', 60);
            $table->longText('payload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('jobs_status');
    }
}
