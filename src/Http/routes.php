<?php

Route::get('/poster', 'PosterController@index')->name('poster.index');
Route::post('/poster', 'PosterController@send')->name('poster.send');
Route::get('/poster/show', 'PosterController@show')->name('poster.show');
