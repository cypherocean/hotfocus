<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileNameTwoFieldToPostsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'file_name_two')) {
                $table->string('file_name_two')->nullable()->after('file_name_one');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'file_name_two')) {
                $table->dropColumn('file_name_two');
            }
        });
    }
}
