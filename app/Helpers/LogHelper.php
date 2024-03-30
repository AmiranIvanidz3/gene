<?php

namespace App\Helpers;

use App\Models\Tag;

use App\Models\IpRequest;
use App\Models\ExcludedIp;
use App\Models\LogVisitor;
use App\Models\ExcludedUserAgents;
use App\Models\tagOfProjectProcess;
use App\Models\ExcludedUserAgentRequests;


class LogHelper
{
    /**
     * @param $tags
     * @return array
     */


    public static function store($reel_id = null, $author_id = null, $video_id = null, $page = null)
    {
    // foreach ($excluded_ips as &$ip) {
    //     $ip['ip'] = implode('.', array_slice(explode('.', $ip['ip']), 0, 3));
    // }

    $referrer = $_SERVER['HTTP_REFERER'] ?? null;

    $visitor_ip = $_SERVER['REMOTE_ADDR'];

    $excluded_ips = ExcludedIp::where('ip', $visitor_ip)->get();

    $excluded_user_agent = ExcludedUserAgents::where('user_agent', $_SERVER['HTTP_USER_AGENT'])->get();

    if (count($excluded_ips) > 0) {
        
        $now = now()->setTimezone('Asia/Tbilisi')->format('Y-m-d');

        $ip_id = ExcludedIp::where('ip', $visitor_ip)->pluck('id')->first();

        $count = IpRequest::where('date', $now)
        ->where('ip_id', $ip_id)
        ->pluck('count')
        ->first();


        IpRequest::updateOrInsert(
            ['date' =>  $now ], // The condition to check

            [
                'ip_id' => $ip_id,
                'count' => $count+1
                
            ] 
        );


    } else if (count($excluded_user_agent) > 0) {

    
        $now = now()->setTimezone('Asia/Tbilisi')->format('Y-m-d');

        $user_agent_id = ExcludedUserAgents::where('user_agent', $_SERVER['HTTP_USER_AGENT'])->pluck('id')->first();

        $count = ExcludedUserAgentRequests::where('date', $now)
        ->where('user_agent_id', $user_agent_id)
        ->pluck('count')
        ->first();

     


        ExcludedUserAgentRequests::updateOrInsert(
            ['date' =>  $now ], // The condition to check

            [
                'user_agent_id' => $user_agent_id,
                'count' => $count+1
                
            ] 
        );

    }else {

        $query_string = request()->getQueryString();
        
        $path = request()->path();
        $query_string = request()->getQueryString();
        $query_string = $path . ($query_string ? "?".$query_string : "");

        if ($query_string == '/') {
            $query_string = null;
        }
        
        $data = [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'session_id' => session()->getId(),
            'reel_id' => $reel_id ?? null,
            'author_id' => $author_id ?? null,
            'video_id' => $video_id ?? null,
            'page' => $page ?? null,
            'query_string' => urldecode($query_string) ?? null,
            'referrer' => urldecode($referrer),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'created_at' => now()->setTimezone('Asia/Tbilisi')
        ];
        
        LogVisitor::insertOrIgnore($data);
    }

        // LogVisitorHelper::store($ip, $session_id, $reel_id, $author_id, $video_id, $page, $query_string, $referrer);

    }

}
