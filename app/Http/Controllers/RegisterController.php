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

    function UpdateRegister() {
        $cards = CardsRegister::GetCards();
        return response(['cards' => $cards], 200);
    }
    function UpdatePublicRegister() {
        $cards = PublicCircuit::GetCards();
        return response(['cards' => $cards], 200);
    }

    function PrintPublicRegister() {
        $cards = PublicCircuit::GetCards();
        return view('register.public_register', compact('cards'));
    }

    function PublicCard(int $id) {
        $card = CardsRegister::GetCardByID($id);
        $card['publicity_status'] = true;
        $card->save();
        return response(['message' => 'successful public'], 200);
    }
    function NonPublicCard(int $id) {
        $card = PublicCircuit::GetCardByID($id);
        $card['publicity_status'] = false;
        $card->save();
        return response(['message' => 'successful unpublic'], 200);
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

    function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    function SortRegister(Request $request) {
        $cards = CardsRegister::GetCards()->toArray();
        $input = $request->all();
        foreach ($input as $key => $value) {
            if($value['value'] !== null && $value['value'] === true) {
                dump($value['value']);
                $cards = self::array_sort($cards, $key, SORT_ASC);
            }
            elseif($value['value'] !== null && $value['value'] === false) {
                dump($value['value']);
                $cards = self::array_sort($cards, $key, SORT_DESC);
            }
            else {
                continue;
            }
        }
        $sortCards = [];
        foreach ($cards as $card)
        {
            $sortCards[] = $card;
        }
        dump( $sortCards);
        return response(['cards' => $sortCards], 200);
    }

    function FilterRegister(Request $request) {
        $cards = CardsRegister::GetCards();
        $input = $request->all();
        dump($input);
        $filtredCards = [];
        foreach ($cards as $card) {
            $check_valid = true;
            foreach ($input as $key => $value) {
                if($key == 'owner_signs')
                {
                    //continue;
                    if(utf8_encode($input[$key]) !== 'Нет черт' && $input[$key] !== null) {
                        dump(utf8_encode($input[$key]));
                        $filt_owner_signs = explode(', ', utf8_encode($input[$key]));
                        $owner_signs = explode(', ', utf8_encode($card[$key]));

                        foreach ($filt_owner_signs as $sign) {
                            if (!in_array($sign, $owner_signs)) {
                                $check_valid = false;
                                break;
                            }
                        }
                    }
                    elseif(utf8_encode($input[$key]) === 'Нет черт') {
                        if(utf8_encode($input[$key]) !== utf8_encode($card[$key]))
                        {
                            dump(utf8_encode($input[$key]));
                            $check_valid = false;
                            break;
                        }
                    }
                    else {
                        continue;
                    }
                }

                elseif($key == 'animal_traits')
                {
                    foreach ($input[$key] as $trait_name => $trait_value)
                    {
                        if($trait_value != null && $card['animal_traits'][$trait_name] != $trait_value)
                        {
                            $check_valid = false;
                            continue;
                        }
                    }
                }

                else {
                    if($value !== null && $card[$key] !== $value)
                    {
                        $check_valid = false;
                        break;
                    }

                }

            }
            if($check_valid)
            {
                $filtredCards[] = $card;
            }
        }

        return response(['cards'=>$filtredCards], 200);
    }
}
