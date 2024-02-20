<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("duration")->nullable();
            $table->date("start_date");
            $table->date("end_date");
            // $table->enum("contract_status",[0,1])->default(0);
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
        Schema::dropIfExists('employe_statuses');
    }
};
