<?php

namespace App\Commands;

use App\Lib\BackUp;
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
	 * @var BackUp
	 */
	private $backUp;

	/**
	 * Database constructor.
	 * @param BackUp $backUp
	 */
	public function __construct(BackUp $backUp)
	{
		parent::__construct();

		$this->process = new Process(
			sprintf(
				'mysqldump -u%s -p%s %s > %s',
				$backUp->getUsername(),
				$backUp->getPassword(),
				$backUp->getDatabases(),
				$backUp->filenameAndPath()
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
		    $this->task("Saving file", function () {
			    $this->process->mustRun();
			    return true;
		    });
		    $this->task('File saved', function (){
		    	return true;
		    });

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
        $schedule->command(static::class)->everyHour();
    }
}