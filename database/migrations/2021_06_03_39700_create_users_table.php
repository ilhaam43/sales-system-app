<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('users_role')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_category_id')->nullable()->constrained('product_category');
            $table->foreignId('status_id')->constrained('users_status');
            $table->foreignId('country_id')->constrained('country');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->integer('quantity_research_paid')->nullable();
            $table->integer('quantity_inquire_paid')->nullable();
            $table->integer('quantity_reply_paid')->nullable();
            $table->double('amount_paid')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
