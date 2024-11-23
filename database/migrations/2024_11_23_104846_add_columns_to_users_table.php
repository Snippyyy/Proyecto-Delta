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
            $table->string('avatar')->nullable()->after('name');
            $table->string('province')->after('avatar');
            $table->string('address')->after('province');
            $table->string('postal_code')->after('address');
            $table->string('phone_number')->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('province');
            $table->dropColumn('address');
            $table->dropColumn('postal_code');
            $table->dropColumn('phone_number');
        });
    }
};
