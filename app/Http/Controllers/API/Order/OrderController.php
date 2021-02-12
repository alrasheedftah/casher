<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Model\Item;
use App\Model\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::with('items')->get();
        return $this->showAll($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderData = $this->validate($request,[
            'orderItems.*.item_id'=> 'required|exists:items,id',
            'orderItems.*.quantity'=> 'required|integer',
            'totalPrice'=>'required|integer',

        ]);
        

        
            
        try{
            DB::beginTransaction();
            $totalPrice=0;
            foreach($orderData['orderItems'] as $orderItem){
                $item= Item::find($orderItem['item_id']);
                if($item){
                    $totalPrice+=$item->price * $orderItem['quantity']; 
                }
            }

            $order=Order::create([
                'total'=>$totalPrice,
                'user_id'=>auth()->user()->id    
            ]);

        foreach ($orderData['orderItems'] as $orderItem) {
            $order->items()->attach($order->id,[
                'quantity'=>$orderItem['quantity'],
                'item_id'=>$orderItem['item_id']
            ]);    
        }
            DB::commit();
            logger($totalPrice);

        }catch(Exception $ex){
            logger($ex->getMessage());
            DB::rollBack();
            return $this->errorResponse($ex->getMessage(),500);

        }

        // $order =Order::create($request->only([

        // ]));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $this->showOne($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        return "Unable To Update ";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return $this->showOne($order);
    }
}
