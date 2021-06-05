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
            $table->string('company_name');
            $table->string('company_website');
            $table->string('company_email')->unique();
            $table->string('company_phone');
            $table->string('company_product_url');
            $table->string('country');
            $table->enum('is_form',['Yes', 'No']);
            $table->enum('status',['Admin Approved', 'Auditor Approved', 'Admin Reject', 'Auditor Reject', 'Pending']);
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
