<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());
        try{
            $message = [];
            $rules = [];

            $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            /*
            * Laravel simple image file upload
            */
            
            if ($request->has('photo')) {
                $imageName = time().'.'.$request->photo->extension();  
                $request->photo->move(public_path('images'), $imageName);
            }

            /*
             * Image upload with Image Intervention   package
             * use Intervention\Image\Facades\Image;
             */

            if ($request->has('photo')) {

                $img = Image::make($request->photo)->resize(700, 850);
                $imageName = time().'.'.$request->photo->extension();
                $img->save('images'.$imageName, 60);

            }

            Post::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'photo' => $imageName,
            ]);
            alert()->success('Post Created');

            return redirect()->route('posts.index');

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('post.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        try{
            $message = [];
            $rules = [];

            $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            
            /*
             * Laravel simple image file upload
             */

            if ($request->has('photo')) {
                $imageName = time().'.'.$request->photo->extension();  
                $request->photo->move(public_path('images'), $imageName);
            }

            /*
             * Image upload with Image Intervention   package
             * use Intervention\Image\Facades\Image;
             */

            if ($request->has('photo')) {

                $img = Image::make($request->photo)->resize(700, 850);
                $imageName = time().'.'.$request->photo->extension();
                $img->save('images'.$imageName, 60);

            }

           

            $post->title = $request->title;
            $post->category_id = $request->category_id;
            $post->description = $request->description;
            $post->photo = $imageName;
            $post->save();
            alert()->success('Post updated'); //sweet alert message

            return redirect()->route('posts.index');
             //return redirect()->route('categories.index')->with('message',"Post Created"); // this line will work for normal session message


        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        unlink(public_path() . '/images/'. $post->photo);
        $post->delete();
        alert()->success('Post Deleted');

        return redirect()->route('posts.index');
          //return redirect()->route('categories.index')->with('message',"Post Deleted"); // this line will work for normal session message
    }


    public function adminRegister(Request $request){
        $request->validate([
            'email'=>'required|unique:admins',
            'password'=>'required',
            'password_confirmation'=>'same:password'
        ]);
        unset($request['password_confirmation']);
        $password = Hash::make($request->password);
        $request['password'] = $password;
        Admin::create($request->all());
    }
}
