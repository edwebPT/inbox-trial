<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactListController;
use App\Http\Controllers\Api\CampaignController;

Route::get('/contacts',[ContactController::class,'index']);
Route::post('/contacts',[ContactController::class,'store']);
Route::post('/contacts/{id}/unsubscribe',[ContactController::class,'unsubscribe']);

Route::get('/contact-lists',[ContactListController::class,'index']);
Route::post('/contact-lists',[ContactListController::class,'store']);
Route::post('/contact-lists/{id}/contacts',[ContactListController::class,'addContact']);

Route::get('/campaigns',[CampaignController::class,'index']);
Route::post('/campaigns',[CampaignController::class,'store']);
Route::get('/campaigns/{id}',[CampaignController::class,'show']);
Route::post('/campaigns/{id}/dispatch',[CampaignController::class,'dispatch']);
