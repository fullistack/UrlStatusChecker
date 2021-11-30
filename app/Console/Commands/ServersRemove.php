<?php

namespace App\Console\Commands;

use App\Models\Server;
use Illuminate\Console\Command;

class ServersRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:remove {id}';

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
        $id = $this->argument("id");
        $server = Server::find($id);
        $serverUrl = $server->url;
        $server->delete();
        echo "Server '".$serverUrl."' Removed !!!";
    }
}
