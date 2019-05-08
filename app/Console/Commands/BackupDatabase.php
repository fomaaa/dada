<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Backup the database';

    protected $process;

    public function __construct()
    {
        parent::__construct();

        $this->process = new Process(sprintf(
            'mysqldump -u%s -p%s %s | gzip > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            storage_path('backups/backup'.Carbon::now()->toDateString().'.sql.gz')
        ));
    }

    public function handle()
    {
        try {
            $this->process->mustRun();

            $this->info('Backup Succeeded');
            Log::info('Backup Succeeded on '.Carbon::now());

        } catch (ProcessFailedException $exception) {
            $this->error('Backup Failed');
            Log::error('Backup Failed on '.Carbon::now(), [ 'error' =>$exception->getMessage() ]);
        }
    }
}