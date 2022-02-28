<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function proses(Request $request)
    {
        // product
        // echo "</br>Product Name = " . $request->input('productName');

        // // gambar
        // echo "</br></br> Gambar";
        // echo "</br>gambar ada? " . ($request->hasFile('gambar') ? 'true' : 'false');
        // echo "</br> Ekstensi = " . $request->gambar->extension();

        // // country
        // echo "</br>Country = " . $request->input('originCountry');
        // // price
        // echo "</br> Price: " . $request->input('price') . "$";
        // // stock
        // echo "</br> Stock = " . $request->input('stock');
        $this->validate($request,[
            'productName' => 'required|min:2|max:30',
            'originCountry' => 'required|alpha',
            'price' => 'required|numeric|between:2.50,99.99',
            'gambar' => 'required|mimes:jpg,jpeg,png|between:0.001,2000.0',
            'stock' => 'required|numeric'
         ]);
        //save the gambar
        // $path = $request->gambar->storeAs('images', 'filename' . $request->productName . '.jpg');
        $path = $request->gambar->path();
        // $data = $request->gambar;
        $data = file_get_contents($path);
        $base64 = 'data:image/jpg' . ';base64,' . base64_encode($data);
        return redirect()->route('completed')
        ->with(['success' => 'Input data telah sesuai dan berhasil'])
        ->with(['imgData' => $base64])
        ->with(['productName' => $request->productName])
        ->with(['price' => $request->price])
        ->with(['stock' => $request->stock])
        ->with(['country' => $request->originCountry]);
    }
}