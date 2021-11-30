<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteStoreRequest;
use App\Http\Requests\SiteUpdateRequest;
use App\Jobs\SendMail;
use App\Jobs\SiteCheck;
use App\Models\Server;
use App\Models\Site;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public function index()
    {
        $data['sites'] = Auth::user()->sites->map(function (Site $site){
            $site['last_check'] = $site->checks->where("error","<>",null)->first();
            return $site;
        });
        return view('site.index',$data);
    }

    public function store(SiteStoreRequest $request){
        $data = $request->only("url","type","response","email");
        $user = Auth::user();
        $site = $user->sites()->create($data);
        $site->checks()->create();
        return response()->redirectToRoute("home.index");
    }

    public function create(){
        $data['site'] = new Site();
        return view('site.create',$data);
    }

    public function destroy($id){
        Auth::user()->sites()->where("id",$id)->firstOrFail()->delete();
        return response()->redirectToRoute("home.index");
    }

    public function edit($id){
        $data['site'] = Auth::user()->sites()->where("id",$id)->firstOrFail();
        return view('site.edit',$data);
    }

    public function update(SiteUpdateRequest $request,$id){
        $data = $request->only("url","type","response","email");
        Auth::user()->sites()->where("id",$id)->firstOrFail()->update($data);
        return response()->redirectToRoute("home.index");
    }

    public function startCheck(){

        $sites = [];
        foreach (Auth::user()->sites as $site){
            $site_item = $site;
            $site_item['check'] = $site->checks()->create(['status' => \App\Models\SiteCheck::STATUS_P]);
            $sites[] = $site_item;
        }

        SiteCheck::dispatch($sites);
        return response()->redirectToRoute("home.index");
    }

    public function checkSingle($id){
        $sites = [];
        foreach (Auth::user()->sites()->where("id",$id)->get() as $site){
            $site_item = $site;
            $site_item['check'] = $site->checks()->create(['status' => \App\Models\SiteCheck::STATUS_P]);
            $sites[] = $site_item;
        }

        SiteCheck::dispatch($sites);
        return response()->redirectToRoute("home.index");
    }
}
