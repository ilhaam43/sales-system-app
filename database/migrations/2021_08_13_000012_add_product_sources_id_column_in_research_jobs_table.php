<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductSourcesIdColumnInResearchJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('research_jobs', function (Blueprint $table) {
            $table->foreignId('product_sources_id')->constrained('product_sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('research_jobs', function (Blueprint $table) {
            //
        });
    }
}
