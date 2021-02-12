<?php

namespace App\Http\Controllers\API\Purches;

use App\Http\Controllers\Controller;
use App\Model\Purches;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class PurchesController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purches=Purches::all();
        return $this->showAll($purches);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'inputs.*.quantity'  =>'required',
            'inputs.*.price_puyer'=>'required',
            'inputs.*.component_id'=>'required',

        ]);
        $purches=Purches::create(
            $request->only([
                'total_price',
                'date_price',
                'date_price',
                'image',
            ])
        );
        foreach ($request->inputs as $key=>$details) {

        $purches->components()->attach($purches->id,//,$request->inputs[0]);
        [
            'quantity'=>$details['quantity'],
            'price_puyer'=>$details['price_puyer'],
            'component_id'=>$details['component_id']
        ]);

        }
        return  $request->inputs;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Purches $purches)
    {
        return $this->showOne($purches);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purches $purches)
    {
        $purches->fill($request->only([
            'quantity'  =>'required',
            'price'=>'required',
            'component_id'=>'required',
        ]));

        if($purches->isClean())
        return $this->errorResponse('Sory u should specific diffrent Values ',422);

        $purches->save();
        return $this->showOne($purches);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purches $purches)
    {
        $purches->delete();
        return $this->showOne($purches);
    }
}
