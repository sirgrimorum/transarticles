<?php

namespace Sirgrimorum\TransArticles\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreateSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transarticles:createseed {--all : Create a seed for all database tables except migrations table} {--force : Force the iseed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a seeder file with the current table Articles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = $this->options();
        if ($options['all']) {
            $dbName = env('DB_DATABASE');

            $query =  DB::select("SHOW TABLES WHERE Tables_in_$dbName <> 'migrations'");
            $collection = new Collection($query);
            $tables = $collection->implode("Tables_in_$dbName", ',');
            //$options = $this->options('force');
            if ($options['force']) {
                $nombre = "";
            } else {
                $nombre = date("YmdHis");
            }
            $this->info('Calling iseed for all tables except migrations with suffix "{$nombre}" ...');
            $this->call('iseed', [
                'tables' => $tables,
                '--classnamesuffix' => $nombre,
                '--chunksize' => "100",
                '--force' => $options['force'],
            ]);
        } else {
            $bar = $this->output->createProgressBar(2);
            $confirm = $this->choice("Do you wisth to clean the DatabaseSeeder.php list?", ['yes', 'no'], 0);
            $bar->advance();
            $nombre = date("YmdHis");
            if ($confirm == 'yes') {
                $this->line("Creating seed archive of articles table and celaning DatabaseSeeder");
                Artisan::call("iseed articles --classnamesuffix={$nombre} --chunksize=100 --clean");
            } else {
                $this->line("Creating seed archive of articles table and adding to DatabaseSeeder list");
                Artisan::call("iseed articles --classnamesuffix={$nombre} --chunksize=100");
            }
            $this->info("Seed file created with the name Articles{$nombre}Seeder.php");
            $bar->advance();
            $bar->finish();
        }
        return 0;
    }
}
