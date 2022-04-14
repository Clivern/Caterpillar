<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class WaitForDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wait:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Waits until database is up and running';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = false;
        $this->info('Waiting for database...');

        while (!$connection) {
            try {
                DB::connection()->getPdo();
                $connection = true;
            } catch (\Exception $e) {
                $this->info('Database unavailable, waiting 1 second...');
                sleep(1);
            }
        }

        $this->info('Database available!');
    }
}
