<?php


namespace App\Classes;
use App\Jobs\SendMail;
use App\Models\SiteCheck;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Server
{
    private $url;
    private $client;

    function __construct($url)
    {
        $this->url = $url;
        $this->client = new Client();
    }

    function request($data){

        try {
            $res = $this->client->request('GET', $this->url."/index.php?url=".urlencode($data['url']), [
//                'form_params' => $data,
                'timeout'  => 10.0,
                'allow_redirects' => false,
                'http_errors' => true
            ]);
            $responseJson = $res->getBody()->getContents();
            return new Response($responseJson);
        }catch (\Exception $e){
            Log::error("Server Error",['code' => $e->getCode(),"message" => $e->getMessage()]);
        }
        return false;
    }

    static function create($url){
        return new Server($url);
    }

    function check(){
        $url = route('server.check');
        $response = $this->request(['url' => $url]);
        return ( $response!== false && $response->getStatus() == 200 && $response->getBody() == "SERVER_STATUS_TRUE" );
    }

    static function checkSites($sites){
        $servers = \App\Models\Server::all();
        foreach ($sites as $site) {
            $url = $site->url;
            $site_status = true;
            $error = false;
            foreach ($servers as $server) {
                $response = \App\Classes\Server::create($server->url)->request(['url' => $url]);
                if ($response === false) {
                    continue;
                } else {
                    $status = false;
                    if (!$response->getError()) {
                        if ($site->type == "http") {
                            if ($response->checkHttp($site->response) === true) {
                                $status = true;
                            } else {
                                $status = false;
                                $error = CheckErrors::HttpCodeError;
                            }
                        } elseif ($site->type == "string") {
                            if ($response->checkString($site->response) === true) {
                                $status = true;
                            } else {
                                $status = false;
                                $error = CheckErrors::StringError;
                            }
                        }
                    }
                }

                if ($status === false && $error === false) {
                    $error = $response->getCurlError();
                }

                $site->check->items()->create([
                    "server" => $server->url,
                    "status" => $status,
                ]);
                $site_status = $status;
            }
            $site->check->status = $site_status ? \App\Models\SiteCheck::STATUS_A : \App\Models\SiteCheck::STATUS_U;
            $site->check->error = $site_status ? null : $error;
            $site->check->save();

            $checks = $site->checks()->orderByDesc("created_at")->take(2)->get()->toArray();
            if(isset($checks[1])){
                $changed = $checks[0]['status'] != $checks[1]['status'];
            }else{
                $changed = true;
            }

            if($changed){

                SendMail::dispatch([
                    "dateTime"  => Carbon::now()->toDateString(),
                    "site"      => $site->url,
                    "status"    => $checks[0]['status'],
                    "error"     => $checks[0]['error'],
                    "required"  => $site->response,
                    "email"     => $site->email
                ]);
            }
        }
    }
}
