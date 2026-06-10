<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('posts') || !Schema::hasTable('tipo_post') || !Schema::hasColumn('posts', 'tipo_post_id')) {
            return;
        }

        if ($this->foreignKeyExists('posts', 'tipo_post_id')) {
            return;
        }

        DB::statement('ALTER TABLE posts MODIFY tipo_post_id BIGINT UNSIGNED NULL');

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('tipo_post_id')
                ->references('id')
                ->on('tipo_post')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('posts') || !Schema::hasColumn('posts', 'tipo_post_id')) {
            return;
        }

        $constraint = $this->foreignKeyName('posts', 'tipo_post_id');

        if ($constraint) {
            Schema::table('posts', function (Blueprint $table) use ($constraint) {
                $table->dropForeign($constraint);
            });
        }
    }

    private function foreignKeyExists(string $table, string $column): bool
    {
        return $this->foreignKeyName($table, $column) !== null;
    }

    private function foreignKeyName(string $table, string $column): ?string
    {
        $result = DB::selectOne(
            'SELECT CONSTRAINT_NAME
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?
               AND REFERENCED_TABLE_NAME IS NOT NULL
             LIMIT 1',
            [$table, $column]
        );

        return $result?->CONSTRAINT_NAME;
    }
};
