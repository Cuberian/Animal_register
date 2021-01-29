<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardsRegister;
use App\Models\Card;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function PrintRegister() {
        $cards = CardsRegister::GetCards();
        return view('register.register', compact('cards'));
    }
    function PrintPublicRegister() {
        $cards = PublicCircuit::GetCards();
        return view('register.public_register', compact('cards'));
    }

    function OpenCard(int $id) {
        $card = CardsRegister::GetCardByID($id);
        return view('card.open_card', compact('card'));
    }

    function CreateCard() {
        return view('card.add_card');
    }

    function EditCard(int $id) {
        $card = CardsRegister::GetCardByID($id);
        return view('card.edit_card', compact('card'));
    }

    function DeleteCard(int $id) {
        $card = CardsRegister::GetCardByID($id);
        $card->delete();
    }

    function UpdateCard(Request $request, int $id)
    {
        $card = CardsRegister::GetCardByID($id);
        $input = $request->all();
        $card->fill($input)->save();
    }

    function StoreCard(Request $request)
    {
        $input = $request->all();
        return CardsRegister::AddCard($input);

    }
}
