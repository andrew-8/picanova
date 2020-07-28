<?php

namespace App\Http\Controllers;

use App\Ingredients;
use App\Pizzas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pizza = [];
        if (isset($request->pizza_id)){
            $pizza = Pizzas::findOrFail($request->pizza_id);
        }
        return view('admin.ingredientCreate')->with('pizza', $pizza);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->validator($request, array(
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0.1'
        ), false);
        if (is_array($result)) {
            return response($result);
        } else {
            $ingredient = Ingredients::create($request->all());
            return response(['result' => $ingredient]);
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
    public function edit(Request $request, $id)
    {
        if (isset($id)){
            $data['ingredient'] = Ingredients::findOrFail($id);
        }
        if (isset($request->pizza_id)){
            $data['pizza'] = Pizzas::findOrFail($request->pizza_id);
        }
        return view('admin.ingredientEdit')->with('data', $data);
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
        $result = $this->validator($request, array(
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0.1'
        ), false);
        if (is_array($result)) {
            return response($result);
        } else {
            $ingredient = Ingredients::findOrFail($id);
            if ($ingredient->update($request->all())){
                return response(['result' => $ingredient]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['ingredient'] = Ingredients::findOrFail($id);
        if ($data['ingredient']->delete()){
            $objPizzas = new PizzasController();
            $data['pizzas'] = $objPizzas->getPizzas();
            return response(['result' => $data]);
        }
    }

    /**
     * Validate of field and save to storage
     * @param $request
     * @param $rules
     * @param $id
     * @return array
     */
    public function validator($request, $rules, $id){

        $validator = Validator::make($request->all(), $rules, Lang::get('validation'), Lang::get('validation.attributes'));
        if ($validator->fails()) {
            return [
                'info' => $validator->errors()->all(),
                'validate' => false
            ];
        }
        return true;

    }
}
