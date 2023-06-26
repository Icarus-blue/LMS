<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetalistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metalists', function (Blueprint $table) {
            $table->id();
            $table->string('adm_no');
            $table->string('Name');
            $table->string('stream_name');
            $table->string('marks_new');
            $table->string('sbj');
            $table->string('kcpe');
            $table->string('vap');
            $table->string('mn_mks');
            $table->string('dev');
            $table->string('over_grad');
            $table->string('total_mark');
            $table->string('Total_pts');
            $table->string('stream_order');
            $table->string('order_form');
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
        Schema::dropIfExists('metalists');
    }
}
