<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Database\Query\Builder;

class userController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query();  
        for ($counter = 0; $counter < count($request->queries);$counter++)
        {
            $query = $request->queries[$counter];

            $query['rel'] = 'and' ? $query['rel'] == null : $query['rel'];

            // switch based on filter name 
            switch ($query['fil']):
                case 'name':
                    $q->name($query['comp'] , $query['val'] , $query['rel']);
                    break;
                case 'age':
                    $q->age($query['comp'] , $query['val'] , $query['rel']);
                    break;
                case 'gender':
                    $q->gender($query['comp'] , $query['val'] , $query['rel']);
                    break;
                case 'posts':
                    $q->postnumber($query['comp'] , $query['val'] , $query['rel']);
                    break;
                case 'country':
                    $q->countryname($query['comp'] , $query['val'] , $query['rel']);
                    break;
                endswitch;
        }
        return UserResource::collection($q->paginate(5));
       
    }

    }
