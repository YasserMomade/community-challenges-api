<?php

use App\Http\Controllers\Api\Community\ChallengeController;
use App\Http\Controllers\Api\Community\ChallengeParticipantController;
use App\Http\Controllers\Api\Community\ChallengeTaskController;
use App\Http\Controllers\Api\Community\CommunityController;
use App\Http\Controllers\Api\Community\CommunityMemberController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

    Route::middleware(['auth:api'])->group(function () {

        //Comunidades

        Route::prefix('communities')->group(function () {

            Route::get('/', [CommunityController::class, 'index']);
            Route::get('/my', [CommunityController::class, 'mycommunities']);
            Route::get('/{id}', [CommunityController::class, 'show']);
            Route::post('/', [CommunityController::class, 'store']);
            Route::put('/{id}', [CommunityController::class, 'update']);
            Route::post('/{id}/close', [CommunityController::class, 'close']);

            Route::post('/{id}/join', [CommunityMemberController::class, 'join']);
            Route::get('/{id}/join_requests', [CommunityMemberController::class, 'listJoinRequests']);
            Route::post('/{id}/join_requests/{requestId}/approve', [CommunityMemberController::class, 'approve']);
            Route::post('/{id}/join_requests/{requestId}/reject',  [CommunityMemberController::class, 'reject']);
            Route::post('/{id}/leave', [CommunityMemberController::class, 'leave']);
            Route::post('/{id}/members/{memberId}/remove',   [CommunityMemberController::class, 'removeMember']);
            Route::post('/{id}/members/{memberId}/promote',  [CommunityMemberController::class, 'promoteMember']);
        });

        //Criacao de desafios

        Route::prefix('communities')->group(function () {
            Route::post('/{communityId}/challenges', [ChallengeController::class, 'store']);
            Route::get('/{communityId}/challenges', [ChallengeController::class, 'index']);
            Route::get('/{communityId}/challenges/{id}', [ChallengeController::class, 'show']);
            Route::put('/{communityId}/challenges/{id}', [ChallengeController::class, 'update']);
            Route::patch('/{communityId}/challenges/{id}/close', [ChallengeController::class, 'close']);


            // Participar de desafios + ranking e proogresso

            Route::post('/{communityId}/challenges/{id}/join', [ChallengeParticipantController::class, 'join']);
            Route::Delete('/{communityId}/challenges/{id}/leave', [ChallengeParticipantController::class, 'leave']);
            Route::post('/{communityId}/challenges/{id}/join', [ChallengeParticipantController::class, 'join']);
            Route::get('/{communityId}/ranking', [ChallengeParticipantController::class, 'getCommunityRanking']);
            Route::get('/{communityId}/challenges/{id}/progress', [ChallengeParticipantController::class, 'getChallengeProgress']);
            Route::get('/{communityId}/progress', [ChallengeParticipantController::class, 'getCommunityProgress']);
            Route::put('/{communityId}/challenges/{id}/{taskId}/alter', [ChallengeParticipantController::class, 'toggleStatus']);
            Route::get('/users/tasks', [ChallengeParticipantController::class, 'listUserTasks']);
        });

        //Criacao de tarefas para desafios

        Route::prefix('community_tasks')->group(function () {
            Route::post('/{communityId}/challenges/{challengeId}', [ChallengeTaskController::class, 'store']);
            Route::get('/{communityId}/challenges/{challengeId}', [ChallengeTaskController::class, 'index']);
            Route::get('/{communityId}/challenges/{id}', [ChallengeTaskController::class, 'show']);
            Route::put('/{communityId}/challenges/{challengeId}/{taskId}', [ChallengeTaskController::class, 'update']);
            Route::delete('/{communityId}/challenges/{challengeId}/{taskId}', [ChallengeTaskController::class, 'destroy']);
        });
    });
});
