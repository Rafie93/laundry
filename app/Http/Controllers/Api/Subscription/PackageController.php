<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sistem\PackageMember;
use App\Http\Resources\Subscription\PackageList as ListResource;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $pakets = PackageMember::orderBy('id','asc')
                    ->whereNull('deleted_at')
                    ->where('id','!=',1)->get();
        return new ListResource($pakets);
    }
}
