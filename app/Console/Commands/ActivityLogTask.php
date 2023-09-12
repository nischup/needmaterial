<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ActivityLogTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // DB::table('activity_log')->delete();
        info('hello world before');

        // sleep(65);

        //  info('hello world before');

        return 0;
    }
}
