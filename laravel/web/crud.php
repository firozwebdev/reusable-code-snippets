<?php

class EcommerceProductController extends Controller{

    public function store(Request $request){


        $messages = array(
            'product_title.required' => 'Product Name should not be empty...',
            'product_title.min' => 'Product Name should be minimum 3 characters...',
            'ecategory_id.required' => 'Category Name should be selected from the option...',
            'product_image.required' => 'Image should be uploaded...',
            'product_description.required' => 'Product Description should not be empty...',
            'product_type.required' => 'Product Type should not be seleted...',
            'product_price.required' => 'Price should not be empty...',
            'product_quantity.required' => 'Product Quantity should not be empty...',
            'publication_status.required' => 'Choose Publication Status from select option...',
    
        );
        $rules = array(
            'product_title' => 'required|min:3',
            'ecategory_id' => 'required',
            'product_image' => 'required',
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
    
            $file = $request->file('product_image');
            $fileName = $file->getClientOriginalName();
            $request->file('product_image')->move("front_assets/upload/",$fileName);
            if($fileName){
                Eproduct::create([
                    'product_title' => $request->product_title,
                    'ecategory_id' => $request->ecategory_id,
                    'product_image' => $fileName,
                    'product_description' => $request->product_description,
                    'product_type' => $request->product_type,
                    'product_price' => $request->product_price,
                    'product_quantity' => $request->product_quantity,
                    'publication_status' => $request->publication_status,
                ]);
                Session::put('message', 'Save Product Information Successfully !');
                return redirect()->route('ecommerce.add.product');
            }
    
    
    
        }
    
    }
    
     public function update(Request $request){

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
    
                $id=$request->id;
                $file = $request->file('product_image');
                if($file){   // update with image
                    $fileName = time().$file->getClientOriginalName();
                    $request->file('product_image')->move("front_assets/upload/",$fileName);
                    $update_category = Eproduct::findOrFail($id)->update([
                        'product_title' => $request->product_title,
                        'ecategory_id' => $request->ecategory_id,
                        'product_image' => $fileName,
                        'product_description' => $request->product_description,
                        'product_type' => $request->product_type,
                        'product_price' => $request->product_price,
                        'product_quantity' => $request->product_quantity,
                        'publication_status' => $request->publication_status,
                    ]);
                    if($update_category){
                        Session::put('message', 'Update Product Information Successfully !');
                        return redirect()->route('ecommerce.manage.product');
                    }
    
                }else{  //update without image
                    $update_product = Eproduct::findOrFail($id)->update([
                        'product_title' => $request->product_title,
                        'ecategory_id' => $request->ecategory_id,
                        'product_description' => $request->product_description,
                        'product_type' => $request->product_type,
                        'product_price' => $request->product_price,
                        'product_quantity' => $request->product_quantity,
                        'publication_status' => $request->publication_status,
                    ]);
                    if($update_product){
                        Session::put('message', 'Update Product Information Successfully !');
                        return redirect()->route('ecommerce.manage.product');
                    }
                }
    
    
    
            }
        }


        public function destroy($id){
            $delete_product = Eproduct::where('id',$id)->delete();
            if($delete_product){
                //Session::put('message','Delete Product Information Successfully !');
                Alert::success('Delete Product Information Successfully !','Awesome');
                return redirect()->route('ecommerce.manage.product');
            }
        }
}
