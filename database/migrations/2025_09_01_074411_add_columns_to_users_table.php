<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus phone jika sudah ada
            // $table->string('phone')->nullable()->after('email');
            
            // Tambahkan hanya kolom yang belum ada
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('avatar');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn('phone'); // jangan drop jika sudah ada sebelumnya
            $table->dropColumn(['address', 'bio', 'avatar', 'status']);
        });
    }
};