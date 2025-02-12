<?php

protected function schedule(Schedule $schedule)
{
    $schedule->command('feeds:fetch')->hourly(); // Runs every hour
}

protected function schedule(Schedule $schedule)
{
    $schedule->command('reports:send')->daily();
}
