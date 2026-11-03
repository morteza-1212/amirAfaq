<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('carts:abandon-stale')
    ->dailyAt('00:00')
    ->withoutOverlapping()
    ->onOneServer();
