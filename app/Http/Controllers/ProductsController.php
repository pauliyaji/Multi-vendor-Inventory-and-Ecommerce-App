<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Picqer;

class ProductsController extends Controller
{
    public function index()
    {
        $data = Product::all();

        return view ('products.index', ['data'=>$data]);

        // return redirect()->back()->with('error', 'No data found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'product_code'=>'required|max:9',

        ]);
        //$data = Product::create($request->all());
        $product_code = $request->product_code;
//        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
//        $barcodes = $generator->getBarcode($product_code, $generator::TYPE_STANDARD_2_5, 2, 60);

        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('myproducts/barcodes/' .$product_code . '.jpg',
            $generator->getBarcode( $product_code, $generator::TYPE_CODE_128, 3, 50));

        $data = new Product();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->batch_quantity = $request->batch_quantity;
        $data->product_code = $product_code;
        $data->barcode = $product_code .'.jpg';
        $data->save();


        return redirect()->route('products.index')->with('success', 'New recored entered successfully');
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
        $data = Product::find($id);
        return view ('products.edit', ['data'=>$data]);
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
        $data = Product::find($id);
        if($data->barcode != '') {
            $barcode_path = public_path() . '/myproducts/barcodes/' . $data->barcode;
            unlink($barcode_path);
        }
            if($data){
            $product_code = $request->product_code;
           $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
            file_put_contents('myproducts/barcodes/' .$product_code . '.jpg',
                $generator->getBarcode( $product_code, $generator::TYPE_CODE_128, 3, 50));

            $data->name = $request->name;
            $data->description = $request->description;
            $data->batch_quantity = $request->batch_quantity;
            $data->product_code = $product_code;
            $data->barcode = $product_code. '.jpg';
            $data->update();
            return redirect()->route('products.index')->with('success', 'Records updated successfully');
        }
        return redirect()->route('products.index')->with('error', 'Records not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
        $data->delete();

        return redirect()->route('products.index')
            ->with('success', 'Method deleted successfully');
    }
}
