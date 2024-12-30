<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('app:get-playlist-tracks')
    ->everyTwoHours(offset: 30);