<?php

namespace App\Commands;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Database extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'backup a list of databases';
	private $process;

	/**
	 * Database constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$db = '*';
		$db_username = 'homestead';
		$db_password = 'secret';
		$filename = 'backup-' .Carbon::now()->format('Y_m_d_H_i_s'). '.sql';
		$backup_dir = storage_path("backups");
		is_dir($backup_dir) ?: mkdir($backup_dir, true);
		$backup_storage = $backup_dir. '/' .$filename;

		echo $backup_storage;

		$this->process = new Process(
			sprintf(
				'mysqldump -u%s -p%s %s > %s',
				$db_username,
				$db_password,
				'--all-databases',
				$backup_storage
			)
		);
	}

	/**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	try{
    		$this->process->mustRun();
	    } catch (ProcessFailedException $exception) {
		    $this->error('The backup process failed.');
		    $this->info($exception->getMessage());
	    }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}