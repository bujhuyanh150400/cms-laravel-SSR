<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Commnent:
     * user_department: Phòng ban
     * user_position: chức vụ
     * status: trạng thái
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('birth');
            $table->smallInteger('gender')->default(1);
            $table->integer('access_login')->default(0);
            $table->string('phone')->default(null);
            $table->text('address')->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(null);
            $table->bigInteger('updated_by')->default(null);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
