<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('spotify:get-playlist-tracks')
    ->hourlyAt(offset: 30);

Schedule::command('spotify:refresh-access-token')
    ->everyMinute();