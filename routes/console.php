<?php

use App\Schedule\UpdateTopUsers;
use Illuminate\Support\Facades\Schedule;

Schedule::call(UpdateTopUsers::class)->everyTenMinutes();
