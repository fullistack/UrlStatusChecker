<?php

namespace App\Console\Commands;

use App\Classes\Server;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ServersStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $time = 0;
        while(true){
            if(time() - $time > env("check_time")){
                echo Carbon::now()->toDateTimeString();
                echo "\t Start";
                $time = time();
                $this->start();
                echo "\t END \n";
            }
        }
        return 0;
    }

    function start(){
        $sites = Site::all();
        Server::checkSites($sites);
    }
}
