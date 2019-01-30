<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ingredient;
use App\Stock;
use App\Http\Resources\Stock as StockResource;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Stock::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock = $request->isMethod('put') ? Stock::findOrFail($request->id) : new Stock;

        $stock->id = $request->input('id');
        $stock->ingredient_id = $request->input('ingredient');
        $stock->bought_date = date('Y-m-d', strtotime($request->input('bought_date')));
        $stock->bought_location = $request->input('location');
        $stock->brand = $request->input('brand');
        $stock->bought_num = $request->input('bought_num');
        $stock->price = $request->input('price');
        $stock->expire = date('Y-m-d', strtotime($request->input('expire_date')));

        if($stock->save())
        {
            return new StockResource($stock);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        $stocks = Stock::all();

        return view('ingredient_stock', [
            'title' => '原料採買紀錄',
            'name' => $ingredient->name,
            'last_num' => $ingredient->last_num,
            'unit' => $ingredient->unit,
            'brands' => $ingredient->brand,
            'stocks' => $stocks,
            'ingredient' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
