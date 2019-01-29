<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ingredient;
use App\Http\Resources\Ingredient as IngredientResource;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredient = Ingredient::paginate(10);

        return IngredientResource::collection($ingredient);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stuck()
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
        $ingredient = $request->isMethod('put') ? Ingredient::findOrFail($request->id) : new Ingredient;

        $ingredient->id = $request->input('id');
        $ingredient->name = $request->input('name');
        $ingredient->unit = $request->input('unit');
        $ingredient->brand = json_encode($request->input('brands'));
        $ingredient->last_num = $request->input('last_num');
        $ingredient->alert_num = $request->input('alert_num');

        if($ingredient->save())
        {
            return new IngredientResource($ingredient);
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
        //
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
        $ingredient = Ingredient::findOrFail($id);

        if($ingredient->delete()) {
            return new IngredientResource($ingredient);
        }
    }
}
