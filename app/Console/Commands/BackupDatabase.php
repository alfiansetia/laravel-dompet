<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will create backup of database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $root = storage_path();
        $path = 'app/backup/';
        $full_path = $root . '/' . $path;
        if (!file_exists($full_path)) {
            File::makeDirectory($full_path, 0777, true);
        }
        $defaultConnection = Config::get('database.default');
        $defaultConfig = Config::get('database.connections.' . $defaultConnection);
        $host = $defaultConfig['host'];
        $database = $defaultConfig['database'];
        $username = $defaultConfig['username'];
        $password = $defaultConfig['password'];
        $filename = "backup-" . date('YmdHis') . ".sql";
        $command = "mysqldump --user=" . $username . " --password=" . $password . " --host=" . $host . " " . $database . " > " . $full_path . "/" . $filename;
        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);
        $this->info('Backup Created');
        return Command::SUCCESS;
    }
}
