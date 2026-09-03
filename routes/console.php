<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('spotify:refresh-access-token')
    ->everyMinute();