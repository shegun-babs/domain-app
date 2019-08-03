<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Lib\IpInfo;

class DomainCheck extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'domain:check {domainName}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Check a domain name and return its IP Address';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $domainName = $this->argument('domainName');

        try{
            if ( \validate_domain($domainName) ){
                $ip_addr = gethostbyname("$domainName.");
                $ipInfo = app(IpInfo::class)->ip_address($ip_addr);
                $loc = '';
                $isp = $ipInfo->get('org');
                $ipInfo->get('city') ? $loc .= $ipInfo->get('city'). ", " : '';
                $ipInfo->get('reqion') ? $loc .= $ipInfo->get('reqion'). ", " : '';
                $ipInfo->get('country') ? $loc .= $ipInfo->get('country') : '';

                $this->info("Domain Name: " .$domainName);
                $this->info("Domain IP: " .$ip_addr);
                $this->info("ISP: " .$isp);
                $this->info("Loc: " .$loc);
    
                exit(1);
            }
            $this->error("Invalid domain name");
        } catch (\Exception $e){
            $this->error($e->getMessage());
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
