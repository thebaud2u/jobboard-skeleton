<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('cron:regenerate_site_map')->dailyAt('06:30');
Schedule::command('check:permissions')->dailyAt('00:00');
Schedule::command('check:publication')->dailyAt('01:00');
Schedule::command('check:mail_queues')->dailyAt('01:30');
Schedule::command('refresh:all')->dailyAt('02:00');
Schedule::command('subscription:bank_transfer_waiting')->dailyAt('04:30');
Schedule::command('user:profile_completion')->dailyAt('05:00');
Schedule::command('user:no_connection')->dailyAt('05:30');
Schedule::command('article:publication')->hourly();
Schedule::command('cron:regenerate_site_map')->dailyAt('06:30');
Schedule::command('cron:regenerate_articles_google_discover_site_map')->dailyAt('06:50');