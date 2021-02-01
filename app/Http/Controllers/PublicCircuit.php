<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class PublicCircuit extends Controller
{
    static function GetCards() {
        return Card::where('publicity_status', true)->get();
    }
    static function GetCardByID(int $id) {
        return Card::where('id', $id)->first();
    }
}
