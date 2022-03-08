<?php

namespace App\Http\Controllers\Api\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information\News;
use App\Http\Resources\Information\NewsList as ListResource;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::orderBy('id','desc')
                    ->where('status',1)
                    ->paginate(20);
        return new ListResource($news);
    }
}
