<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Using DB facade since we haven't set up full Eloquent models yet

class MenuItemController extends Controller
{
    public function index()
    {
        // This query matches the SQL logic we tested earlier
        $menu = DB::table('menu_items')
            ->join('categories', 'menu_items.category_id', '=', 'categories.id')
            ->select('menu_items.*', 'categories.name as category_name')
            ->where('menu_items.is_available', true)
            ->get();

        return response()->json($menu);
    }
}