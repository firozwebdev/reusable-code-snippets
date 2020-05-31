<?php

namespace App\Http\Controllers\Manager;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
              
        try{
            $message = [];
            $rules = [];
            $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }



            // if we have image -single image upload
            if ($request->hasfile('multiple')) {
                foreach ($request->file('multiple') as $image) {
                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('uploads/documents') . '/productimages/', $imageName);
                    $data[] = $imageName;
                }
            }
           // if we have image -single image upload
           
            $post = new Post();
            $post->title = $request->title;
            $post->category_id = $request->category_id;
            $post->description = $request->description;
            $product->multiple = json_encode($data);
            $post->save();
            alert()->success('Post created'); // sweet alert externel package

            return redirect()->route('posts.index');
            //return redirect()->route('categories.index')->with('message',"Post Created"); // this line will work for normal session


        }catch(\Exception $e){
            return $e->getMessage();
        }


    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        unlink(public_path() . '/images/'. $post->photo);
        $post->delete();
        alert()->success('Post Deleted');

        return redirect()->route('posts.index');

    }
}
