<?php

namespace App\Http\Controllers\API\Components;

use App\Http\Controllers\Controller;
use App\Model\Component;
use Illuminate\Http\Request;

class ComponentssController extends Controller
{

       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $components=Component::all();

        return $this->showAll($components);
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
            // 'icon'=>'required',
            'packaging_type'=>'required',
            'quantity'=>'required',

        ]);

        return $this->showOne(Component::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Component $component)
    {
        return $this->showOne($component);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Component $component)
    {
        // return $request->all();
        $component->fill($request->only([
            'name',
            'description',
            'packaging_type',
            'quantity',
            
        ]));

        // if($component->isClean())
        // return $this->errorResponse('Sory u should specific diffrent Values ',422);

        $component->save();
        return $this->showOne($component);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return $this->showOne($component);
    }
}
