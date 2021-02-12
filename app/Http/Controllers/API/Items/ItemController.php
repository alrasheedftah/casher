<?php

namespace App\Http\Controllers\API\Items;

use App\Http\Controllers\Controller;
use App\Model\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Item::with('subcategory')->get();

        return $this->showAll($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'  =>'required',
            'description'=>'required',
            'quantity'=>'required',
            // 'photo'=>'required',
            'price'=>'required',
            'packaging_type'=>'required',
            'subcategory_id'=>'required',
        ]);

        return Item::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $this->showOne($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $item->update($request->only([
            'name',
            'description',
            'quantity',
            'price',
            'packaging_type'
        ]));

        if($item->isClean())
        return $this->errorResponse('sorry u  should specific diffrent Values',422);

        $item->save();

        return $this->showOne($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return $this->showOne($item);

    }
}
