<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;

class HomeController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view ('index', ['items' => $items]);
    }
}
