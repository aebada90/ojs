<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\MatchmakingGroupController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileChatController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

Route::get('/meetup', [PartnerController::class, 'dating'])->name('partners.dating');
Route::redirect('/dating', '/meetup', 301);
Route::get('/connect', [PartnerController::class, 'connect'])->name('partners.connect');
Route::get('/network', [NetworkController::class, 'index'])->name('network.index');
Route::get('/network/create', [NetworkController::class, 'create'])->name('network.create');
Route::post('/network/create', [NetworkController::class, 'store'])->name('network.store');
Route::redirect('/networking', '/network', 301);
Route::redirect('/digital-card', '/connect', 301);
Route::redirect('/connectapp', '/connect', 301);

Route::get('/chat', [ProfileChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{slug}', [ProfileChatController::class, 'show'])->name('chat.show');
Route::post('/chat/{slug}', [ProfileChatController::class, 'send'])->name('chat.send');

Route::get('/competition', [CompetitionController::class, 'index'])->name('competition.index');
Route::get('/competition/enter', [CompetitionController::class, 'enterForm'])->name('competition.enter');
Route::post('/competition/enter', [CompetitionController::class, 'enter'])->name('competition.enter.store');
Route::get('/competition/{slug}', [CompetitionController::class, 'show'])->name('competition.show');
Route::post('/competition/{slug}/vote', [CompetitionController::class, 'vote'])->name('competition.vote');
Route::redirect('/dirndl', '/competition', 301);
Route::redirect('/dirndl-competition', '/competition', 301);

Route::prefix('matchmaking')->name('matchmaking.')->group(function (): void {
    Route::get('/', [MatchmakingController::class, 'index'])->name('index');
    Route::get('/people', [MatchmakingController::class, 'people'])->name('people');
    Route::get('/people/{slug}', [MatchmakingController::class, 'show'])->name('show');
    Route::get('/groups', [MatchmakingGroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [MatchmakingGroupController::class, 'create'])->middleware('auth')->name('groups.create');
    Route::post('/groups', [MatchmakingGroupController::class, 'store'])->middleware('auth')->name('groups.store');
    Route::get('/groups/{slug}', [MatchmakingGroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{slug}/join', [MatchmakingGroupController::class, 'join'])->middleware('auth')->name('groups.join');
    Route::post('/groups/{slug}/leave', [MatchmakingGroupController::class, 'leave'])->middleware('auth')->name('groups.leave');

    Route::middleware('auth')->group(function (): void {
        Route::get('/profile', [MatchmakingController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [MatchmakingController::class, 'updateProfile'])->name('profile.update');
        Route::get('/connections', [MatchmakingController::class, 'connections'])->name('connections');
        Route::post('/people/{slug}/connect', [MatchmakingController::class, 'connect'])->name('connect');
        Route::post('/people/{slug}/accept', [MatchmakingController::class, 'accept'])->name('accept');
        Route::post('/people/{slug}/decline', [MatchmakingController::class, 'decline'])->name('decline');
    });
});
