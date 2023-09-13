<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActivityLogTask extends Command
{
    protected $signature = 'activity-log:clear';
    protected $description = 'Clears all records from the activity_log table';

    public function handle()
    {
        // Delete all records from the activity_log table
        DB::table('activity_log')->truncate();

        $this->info('All records from the activity_log table have been deleted.');

        return Command::SUCCESS;
    }
}
