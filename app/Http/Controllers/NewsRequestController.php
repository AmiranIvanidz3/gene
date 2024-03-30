<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ModalNew;
use App\Models\UserSeenNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewsRequestController extends Controller
{
    public function getNews(request $request){

      
        $currentDate = Carbon::now()->toDateString();

      

        $news_ids = UserSeenNews::where('cookie', $request->cookie)->pluck('news_id')->toArray();

        $news = ModalNew::with('userSeen')
        ->whereNotIn('id', $news_ids)
        ->where('active', 1)
        ->orderBy('id', 'desc')
        ->whereDate('from', '<=', $currentDate)
        ->whereDate('to', '>=', $currentDate)
        ->orderBy('id', 'desc')
        ->first();


        $next = ModalNew::with('userSeen')
        ->whereNotIn('id', $news_ids)
        ->where('active', 1)
        ->orderBy('id', 'desc')
        ->whereDate('from', '<=', $currentDate)
        ->whereDate('to', '>=', $currentDate)
        ->skip(1) // Skip the first record
        ->first();
        
        return response()->json([
            'news' => $news,
            'next' => $next,
            'success' => true,
      ]);
    }

    public function userSeenNews(request $request){

        $item = new UserSeenNews();
        $item->news_id = $request->news_id;
        $item->user_id = Auth::user()->id ?? null;
        $item->ip = $request->ip();
        $item->cookie = $request->cookie;
        $item->save();

        return response()->json([
            'success' => true,
      ]);
    }
}
