<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('posts') || !Schema::hasColumn('posts', 'tipo_post_id')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['tipo_post_id']);
        });

        DB::statement('ALTER TABLE posts MODIFY tipo_post_id BIGINT UNSIGNED NULL');

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('tipo_post_id')
                ->references('id')
                ->on('tipo_post')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('posts') || !Schema::hasColumn('posts', 'tipo_post_id')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['tipo_post_id']);
        });

        DB::statement('ALTER TABLE posts MODIFY tipo_post_id BIGINT UNSIGNED NOT NULL');

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('tipo_post_id')
                ->references('id')
                ->on('tipo_post')
                ->onDelete('restrict');
        });
    }
};
