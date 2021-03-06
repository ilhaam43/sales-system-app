<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('product_category_id')->constrained('product_category')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('country');
            $table->foreignId('job_status_id')->constrained('jobs_status');
            $table->string('company_name')->unique();
            $table->string('company_website')->unique();
            $table->string('company_email')->unique();
            $table->string('company_phone')->unique();
            $table->string('company_product_url')->unique();
            $table->enum('is_form',['Yes', 'No']);
            $table->enum('is_blacklist',['Yes', 'No']);
            $table->integer('count_inquiry')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_jobs');
    }
}
