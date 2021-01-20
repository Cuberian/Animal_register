<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardsRegister;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function PrintRegister() {
        $cards = CardsRegister::GetCards();
        return view('register.register', compact('cards'));
    }
    function OpenCard(int $id) {
        $card = CardsRegister::GetCardByID($id);
        return view('card.open_card', compact('card'));
    }
}
