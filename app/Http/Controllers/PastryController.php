<?php

namespace App\Http\Controllers;

use App\Models\Pastry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PastryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            Pastry::all(),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                400
            );
        }

        $pastry = new Pastry;

        $pastry->name = $data['name'];
        $pastry->price = $data['price'];
        $pastry->photo = $data['photo'];

        $pastry->save();

        return response()->json(
            'Successfully created.',
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pastry  $pastry
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->json(
            Pastry::where('id', $id)->first(),
            200
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pastry  $pastry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                400
            );
        }

        $pastry = Pastry::where('id', $id)->first();

        $pastry->name = $data['name'] ?? $pastry->name;
        $pastry->price = $data['price'] ?? $pastry->price;
        $pastry->photo = $data['photo'] ?? $pastry->photo;

        $pastry->save();

        return response()->json(
            'Successfully updated.',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pastry  $pastry
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $pastry = Pastry::where('id', $id)->first();

        $data = $pastry->array();

        $pastry->delete();

        return response()->json(
            $data,
            200
        );
    }

    private function rules(): array
    {
        return [
            'name' => 'required',
            'price' => ['required', 'numeric'],
            'photo' => ['required', 'url'],
        ];
    }
}
