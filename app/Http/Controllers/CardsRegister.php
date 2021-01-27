<?php

namespace App\Http\Controllers;

use App\Models\AnimalTrait;
use App\Models\Card;
use Illuminate\Http\Request;

class CardsRegister extends Controller
{
    /**
     * Выводит общий реестр карт.
     *
     * @return Card[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    static function GetCards() {
        return Card::all();
    }

    static function GetCardByID(int $id) {
        return Card::where('id', $id)->first();
    }

    /**
     * Show the form for creating a new resource.
     * @param array $input
     */
    static function AddCard(array $input)
    {
        $animal_traits = AnimalTrait::create($input['animal_traits']);
        $input['animal_traits_id'] = $animal_traits['id'];
        $id = Card::create($input)->id;
        return response()->json(['id' => $id], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}
