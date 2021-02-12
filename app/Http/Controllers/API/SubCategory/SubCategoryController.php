<?php

namespace App\Http\Controllers\API\SubCategory;

use App\Http\Controllers\Controller;
use App\Model\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories=Subcategory::with('category')->get();
        return $this->showAll($subcategories);

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
            'category_id'=>'required',
        ]);

        return Subcategory::create($request->only(['name','description','category_id']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategories)
    {
        return $this->showOne($subcategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$subcategories)
    {
        $subcategories=Subcategory::find($subcategories);
        $subcategories->fill($request->only([
            'name',
            'description',
            'category_id'
        ]));

        if($subcategories->isClean())
        return $this->errorResponse('Sory u should specific diffrent Values ',422);

        $subcategories->save();
        return $this->showOne($subcategories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subcategories)
    {
        $subcategories=Subcategory::find($subcategories);
        // return $this->showOne($subcategories);
        $subcategories->delete();
        return $this->showOne($subcategories);
    }
}
