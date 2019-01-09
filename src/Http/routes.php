<?php

Route::get('/poster', 'PosterController@index')->name('post.index');
Route::post('/poster', 'PosterController@send')->name('post.send');
Route::get('/poster/show', 'PosterController@show')->name('post.show');
