<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {

            $table->string('title')->nullable()->after('id');

            $table->string('image')->after('title');

            $table->string('link')->nullable()->after('image');

            $table->boolean('active')->default(true)->after('link');

            $table->integer('position')->default(1)->after('active');

        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {

            $table->dropColumn([
                'title',
                'image',
                'link',
                'active',
                'position'
            ]);

        });
    }
};