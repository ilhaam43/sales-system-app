<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueEmailFromResearchJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('research_jobs', function (Blueprint $table) {
            $table->dropUnique('research_jobs_company_email_unique');
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
            $table->dropUnique('research_jobs_company_email_unique');
        });
    }
}
