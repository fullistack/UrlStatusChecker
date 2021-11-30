<?php

namespace App\Console\Commands;

use App\Models\Server;
use Illuminate\Console\Command;

class ServersAdd extends Command
{
    private $serverUrl;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:add {serverUrl}';

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
        $serverUrl = $this->argument("serverUrl");
        Server::create(['url' => $serverUrl]);
        echo "Server '".$serverUrl."' Added !!!";
    }
}
