<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function getTest()
    {
        $items = DB::select('select * from tests');
        return $items;
    }
    
}
