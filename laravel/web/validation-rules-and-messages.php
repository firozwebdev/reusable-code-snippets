<?php

public function store(Request $request){
    $messages = array(
        'product_title.required' => 'Product Name should not be empty...',
        'product_title.min' => 'Product Name should be minimum 3 characters...',
        'ecategory_id.required' => 'Category Name should be selected from the option...',
        //'product_image.required' => 'Image should be uploaded...',
        'product_type.required' => 'Product Type should not be seleted...',
        'product_description.required' => 'Product Description should not be empty...',
        'product_price.required' => 'Price should not be empty...',
        'product_quantity.required' => 'Product Quantity should not be empty...',
        'publication_status.required' => 'Choose Publication Status from select option...',

    );
    $rules = array(
        'product_title' => 'required|min:3',
        'ecategory_id' => 'required',
        //'product_image' => 'required',
        'product_description' => 'required',
        'product_type' => 'required',
        'product_price' => 'required',
        'product_quantity' => 'required',
        'publication_status' => 'required',
    );

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
    } else {
        //All code goes here if validates............
    }
}