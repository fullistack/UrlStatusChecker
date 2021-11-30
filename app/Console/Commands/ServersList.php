<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\SiteCheck;
use Illuminate\Console\Command;

class ServersList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:list {--check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show servers list';

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
        $servers = Server::query()->select("id","url","created_at")->get();
        if($this->option("check")){
            foreach ($servers as &$server){
                $server['status'] = \App\Classes\Server::create($server->url)->check() ? SiteCheck::STATUS_A : SiteCheck::STATUS_U;
                $this->table(['id','url','created_at','status'], $servers);
            }
        }
        $this->table(['id','url','created_at'], $servers);
    }
}
