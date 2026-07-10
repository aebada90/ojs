<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('locale', 10)->default('en')->after('avatar');
            $table->string('timezone')->default('Europe/Berlin')->after('locale');
            $table->string('currency', 3)->default('EUR')->after('timezone');
            $table->text('bio')->nullable()->after('currency');
            $table->boolean('is_active')->default(true)->after('bio');
            $table->boolean('two_factor_enabled')->default(false)->after('is_active');
            $table->string('provider')->nullable()->after('two_factor_confirmed_at');
            $table->string('provider_id')->nullable()->after('provider');
            $table->json('metadata')->nullable()->after('provider_id');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'username', 'phone', 'avatar', 'locale', 'timezone', 'currency', 'bio',
                'is_active', 'two_factor_enabled', 'provider', 'provider_id', 'metadata',
            ]);
        });
    }
};
