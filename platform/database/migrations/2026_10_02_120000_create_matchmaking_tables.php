<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('matchmaking_profiles')) {
            Schema::create('matchmaking_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('slug')->unique();
                $table->string('display_name');
                $table->string('headline')->nullable();
                $table->text('bio')->nullable();
                $table->string('city')->default('Munich');
                $table->string('country')->default('Germany');
                $table->unsignedTinyInteger('age')->nullable();
                $table->string('intent')->default('friends'); // dating|friends|business|events|travel
                $table->json('interests')->nullable();
                $table->json('languages')->nullable();
                $table->string('avatar_url')->nullable();
                $table->boolean('is_public')->default(true);
                $table->boolean('open_to_connect')->default(true);
                $table->string('company')->nullable();
                $table->string('role_title')->nullable();
                $table->string('linkedin_url')->nullable();
                $table->string('nexora_url')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('matchmaking_connections')) {
            Schema::create('matchmaking_connections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('requester_profile_id')->constrained('matchmaking_profiles')->cascadeOnDelete();
                $table->foreignId('receiver_profile_id')->constrained('matchmaking_profiles')->cascadeOnDelete();
                $table->string('status')->default('pending'); // pending|accepted|declined
                $table->text('message')->nullable();
                $table->timestamps();
                $table->unique(['requester_profile_id', 'receiver_profile_id'], 'matchmaking_conn_unique');
            });
        }

        if (! Schema::hasTable('matchmaking_groups')) {
            Schema::create('matchmaking_groups', function (Blueprint $table) {
                $table->id();
                $table->foreignId('owner_profile_id')->constrained('matchmaking_profiles')->cascadeOnDelete();
                $table->string('slug')->unique();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('intent')->default('friends');
                $table->string('city')->default('Munich');
                $table->timestamp('meets_at')->nullable();
                $table->unsignedSmallInteger('capacity')->default(12);
                $table->boolean('is_public')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('matchmaking_group_members')) {
            Schema::create('matchmaking_group_members', function (Blueprint $table) {
                $table->id();
                $table->foreignId('group_id')->constrained('matchmaking_groups')->cascadeOnDelete();
                $table->foreignId('profile_id')->constrained('matchmaking_profiles')->cascadeOnDelete();
                $table->string('role')->default('member'); // owner|member
                $table->string('status')->default('joined'); // joined|pending
                $table->timestamps();
                $table->unique(['group_id', 'profile_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('matchmaking_group_members');
        Schema::dropIfExists('matchmaking_groups');
        Schema::dropIfExists('matchmaking_connections');
        Schema::dropIfExists('matchmaking_profiles');
    }
};
