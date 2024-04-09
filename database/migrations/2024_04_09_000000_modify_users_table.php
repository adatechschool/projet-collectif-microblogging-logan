<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\isTrue;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change column to nullable
            $table->string('bio')->nullable(true)->change();
            $table->string('photo')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert the column to not nullable
            $table->string('bio')->nullable(false)->change();
            $table->string('photo')->nullable(false)->change();
        });
    }
};