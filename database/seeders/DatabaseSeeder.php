<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\Site;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Server::create(["url" => "http://server1"]);
        Server::create(["url" => "http://server2"]);

        //http status
        Site::create([
            "user_id"   => 1,
            "url"       => "http://test.theideamonitoring.com/get/200",
            "type"      => "http",
            "response"  => 200,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "http://test.theideamonitoring.com/get/301",
            "type"      => "http",
            "response"  => 301,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "http://test.theideamonitoring.com/get/404",
            "type"      => "http",
            "response"  => 404,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "http://test.theideamonitoring.com/get/500",
            "type"      => "http",
            "response"  => 500,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        //https status
        Site::create([
            "user_id"   => 1,
            "url"       => "https://test.theideamonitoring.com/get/200",
            "type"      => "http",
            "response"  => 200,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "https://test.theideamonitoring.com/get/301",
            "type"      => "http",
            "response"  => 301,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "https://test.theideamonitoring.com/get/404",
            "type"      => "http",
            "response"  => 404,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "https://test.theideamonitoring.com/get/500",
            "type"      => "http",
            "response"  => 500,
            "email"     => "test@gmail.com",
        ])->checks()->create();

        //http string

        Site::create([
            "user_id"   => 1,
            "url"       => "http://test.theideamonitoring.com/get/string1",
            "type"      => "string",
            "response"  => "string1",
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "http://test.theideamonitoring.com/get/string2",
            "type"      => "string",
            "response"  => "string2",
            "email"     => "test@gmail.com",
        ])->checks()->create();

        //https string

        Site::create([
            "user_id"   => 1,
            "url"       => "https://test.theideamonitoring.com/get/string1",
            "type"      => "string",
            "response"  => "string1",
            "email"     => "test@gmail.com",
        ])->checks()->create();

        Site::create([
            "user_id"   => 1,
            "url"       => "https://test.theideamonitoring.com/get/string2",
            "type"      => "string",
            "response"  => "string2",
            "email"     => "test@gmail.com",
        ])->checks()->create();
    }
}
