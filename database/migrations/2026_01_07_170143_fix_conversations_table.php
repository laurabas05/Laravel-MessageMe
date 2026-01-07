<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('conversations', function (Blueprint $table) {

            // 1️⃣ Eliminar foreign keys
            $table->dropForeign(['user_one_id']);
            $table->dropForeign(['user_two_id']);

            // 2️⃣ Eliminar índice unique
            $table->dropUnique('conversations_user_one_id_user_two_id_unique');

            // 3️⃣ Eliminar columnas
            $table->dropColumn(['user_one_id', 'user_two_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};