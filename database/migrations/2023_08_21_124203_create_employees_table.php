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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string("nip")->unique();
            $table->string("nik")->unique();
            $table->string("name");
            $table->string("email")->unique();
            $table->string("whatsapp_number")->unique();
            $table->text("address");
            $table->integer("position_id");
            $table->string("no_bpjstk")->unique();
            $table->string("no_npwp")->unique();
            $table->string("bank_account")->unique();
            $table->string("bank_code");
            $table->string("employe_status_id");
            $table->integer("salary")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
};
