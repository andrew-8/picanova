<?php

namespace App\Http\Controllers;

use App\Pizzas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PizzasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pizzas = $this->getPizzas();
        if (!empty($pizzas)){
            return view('admin.pizzas')->with('pizzas', $pizzas);
        }
        return redirect('/admin/pizzas/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pizzaCreate');
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
            'price' => 'required|integer|min:1'
        ), false);
        if (is_array($result)) {
            return response($result);
        } else {
            $pizza = Pizzas::create($request->all());
            return response(['result' => $pizza]);
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
        if (isset($id)){
            $pizza = Pizzas::findOrFail($id);
        }
        return view('admin.pizzaEdit')->with('pizza', $pizza);
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
            'price' => 'required|integer|min:1'
        ), false);
        if (is_array($result)) {
            return response($result);
        } else {
            $pizza = Pizzas::findOrFail($id);
            if ($pizza->update($request->all())){
                return response(['result' => $pizza]);
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
        $pizza = Pizzas::findOrFail($id);
        if ($pizza->delete()){
            return response(['result' => $pizza]);
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

    public function getPizzas(){
        $rsPizzas = Pizzas::orderBy('updated_at', 'DESC')->get();
        foreach ($rsPizzas as $key => $item){
            $item->ingredients;
            $sumIngr = array_reduce($item->ingredients->toArray(), function($sum, $item){
                return $sum + $item['price'];
            });
            $rsPizzas[$key]['total_price'] = $item['price'] + $sumIngr;
        }
        return $rsPizzas->toArray();
    }

}
