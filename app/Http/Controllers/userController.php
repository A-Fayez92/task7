<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;

class userController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query();        
        for ($counter = 0; $counter < count($request->queries);$counter++)
        {
            
            $query = $request->queries[$counter];

            // if contains
            if ($query['comp'] == "contains")
            {
                $query['comp'] = 'like';
                $query['val'] = '%'.$query['val'].'%';
            }
           
            //if start with
            if ($query['comp'] == "startWith")
            {
                $query['comp'] = 'like';
                $query['val'] = $query['val'].'%';
            }

            //if End with
            if ($query['comp'] == "endWith")
            {
                $query['comp'] = 'like';
                $query['val'] = '%'.$query['val'];
            }

            if($counter ==0)
            {
                $q = $q->where($query['fil'],$query['comp'],$query['val']);
                continue;
            }

            if($request->queries[$counter-1]['rel'] == 'and' )
            {
                $q = $q->where($query['fil'],$query['comp'],$query['val']);
            }
            elseif($request->queries[$counter-1]['rel'] =='or')
            {
                $q = $q->orwhere($query['fil'],$query['comp'],$query['val']);

            }
           
        }
        return UserResource::collection($q->paginate(5));

    }
}
