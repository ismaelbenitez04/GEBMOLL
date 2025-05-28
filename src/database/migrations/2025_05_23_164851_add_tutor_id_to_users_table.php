<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('tutor_id')->nullable()->after('role');
        $table->foreign('tutor_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['tutor_id']);
        $table->dropColumn('tutor_id');
    });
}

};
