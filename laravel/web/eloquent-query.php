<?php

/*
 * Relationship query many to many
 */

$product = new Product;
$product->title = 'Cap';
$product->price = 50;
$product->save();
// category_id and product_id are set in pivot table
// using belongsToMany relationship
$category = Category::find(3);
$product->categories()->attach($category);





/*
 * normal query
 */
$category = Category::whereIn('title', ['Food', 'Fashion'])->get();


/*
 * Buyer-Seller Api query
 */

// 1.
public function index(Category $category)
{
    $buyers = $category->products()
        ->whereHas('transactions')
        ->with('transactions.buyer')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->pluck('buyer')
        ->unique('id')
        ->values();


    return $this->showAll($buyers);
}


// 2.
public function index(Category $category)
{
    $sellers = $category->products()
        ->with('seller')->get()->pluck('seller') ->unique('id')
        ->values();

    return $this->showAll($sellers);
}

// 3.

  public function index(Category $category)
    {
        $transactions = $category->products()
                        ->whereHas('transactions')
                        ->with('transactions')->get()
                        ->pluck('transactions')
                        ->collapse()
                        ->unique('id')
                        ->values();

        return $this->showAll($transactions);
   }


   // 4.

        public function index(Product $product)
        {
            $buyers = $product->transactions()
                ->whereHas('buyer')
                ->with('buyer')->get()
                ->pluck('buyer')
                ->unique('id')
                ->values();

            return $this->showAll($buyers);
        }
   // 5.
    public function update(Request $request, Product $product, Category $category)
    {
        //attach, sync, syncWithoutDetach
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('The specified category is not a category of this product',404);
        }

        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);
    }
   // 6.
        public function index(Product $product)
        {
            $transactions = $product->transactions;

            return $this->showAll($transactions);
        }

   // 7.

        public function index(Seller $seller)
        {
            $buyers = $seller->products()
                ->whereHas('transactions')
                ->with('transactions.buyer')->get()
                ->pluck('transactions')
                ->collapse()
                ->pluck('buyer')
                ->unique()
                ->values();

            return $this->showAll($buyers);
        }

   // 8.
        public function index(Seller $seller)
        {
            $categories = $seller->products()->whereHas('categories')
                ->with('categories')->get()
                ->pluck('categories')
                ->collapse()
                ->unique('id')
                ->values();

            return $this->showAll($categories);
        }
   // 9.
    public function index()
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }


    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];

        $this->validate($request,$rules);

        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);

        return $this->showOne($product);
    }
   // 10.

        public function index(Seller $seller)
        {
            $transactions = $seller->products()
                ->whereHas('transactions')
                ->with('transactions')->get()
                ->pluck('transactions')
                ->collapse()
                ->unique('id')
                ->values();

            return $this->showAll($transactions);
        }
   // 11.

        public function index(Transaction $transaction)
        {
            $categories = $transaction->product->categories;
            return $this->showAll($categories);

        }
        public function index(Transaction $transaction)
        {
            $sellers = $transaction->product->seller;
            return $this->showOne($sellers);
        }

   // 12.

        public function update(Request $request, User $user)
        {

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'required|min:6|confirmed',
                'admin' => 'in:'. User::ADMIN_USER .','.User::REGULAR_USER,
            ];

            if($request->has('name')){
                $user->name = $request->name;
            }
            if($request->has('email') && $user->email != $request->email ){
                $user->verified = User::UNVERIFIED_USER;
                $user->verification_token = User::generateVerificationCode();
                $user->email = $request->email;
            }

            if($request->has('password')){
                $user->password = bcrypt($request->password);
            }
            if($request->has('admin')){
                if(!$user->isVerified()){
                    return $this->errorResponse('Only verified users can modify the admin field !', 409);
                }
                $user->admin = $request->admin;
            }

            if(!$user->isDirty()){
                return $this->errorResponse('You need to specify a different value to update !', 422);
            }

            $user->save();

            return $this->showOne($user);

        }
   // 13.

        class User extends Authenticatable
        {
            use Notifiable, SoftDeletes;

            const VERIFIED_USER = '1';
            const UNVERIFIED_USER = '0';

            const ADMIN_USER = 'true';
            const REGULAR_USER = 'false';


            protected $dates = ['deleted_at'];
            protected $table = 'users';
            /**
             * The attributes that are mass assignable.
             *
             * @var array
             */
            protected $fillable = [
                'name',
                'email',
                'password',
                'verified',
                'verification_token',
                'admin'
            ];

            /**
             * The attributes that should be hidden for arrays.
             *
             * @var array
             */
            protected $hidden = [
                'password',
                'remember_token',
                'verification_token'
            ];

            public function setNameAttribute($name){
                $this->attributes['name'] = $name;
            }

            public function getNameAttribute($name){
                return ucwords($name);
            }

            public function setEmailAttribute($email){
                $this->attributes['email'] = strtolower($email);
            }

            public function isVerified(){
                return $this->verified == User::VERIFIED_USER;
            }

            public function isAdmin(){
                return $this->admin == User::ADMIN_USER;
            }

            public static function generateVerificationCode(){
                return str_random(40);
            }
        }



public function getAllData()
{
    $categories = Category::with(['matches'=> function($q){
        $q->where('matches.status','ACTIVE')->orWhere('matches.status','LIVE')->orderBy('matches.match_datetime', 'ASC'); //Check Live Match
    },'matches.tournaments','matches.bets' => function($q){
        $q->whereNull('bet_result')->whereIn('bet_status',[1,3])->orderBy('id', 'ASC');
    },'matches.bets.betEvents' => function($q){
        $q->whereNull('bet_result')->orderBy('id', 'ASC');
    },])->active()->get();  //Get All Data With Active Category


    return response()->json($categories,200);

}

public function match_details($id)
{
    // $match = Match::with('live_score')->findOrFail($id);
    try {
        $data_url = route('get-match-data',$id);

        $match = Match::with(['live_score','tournaments','bets' => function($q){
            $q->whereNull('bet_result')->whereIn('bet_status',[1,3])->orderBy('id', 'ASC');
        },'bets.betEvents' => function($q){
            $q->whereNull('bet_result')->orderBy('id', 'ASC');
        },])->whereIn('status',['LIVE','ACTIVE','ADVANCE'])->findOrFail($id);

        return view('frontend.home.match-details', compact('match','data_url'));
    } catch (\Exception $e) {
        return abort(404);
    }
}

// Retrieve all posts that have at least one comment...
$posts = App\Post::has('comments')->get();

// Retrieve all posts that have three or more comments...
$posts = App\Post::has('comments', '>=', 3)->get();

// Retrieve posts that have at least one comment with votes...
$posts = App\Post::has('comments.votes')->get();

// Retrieve posts with at least one comment containing words like foo%...
$posts = App\Post::whereHas('comments', function (Builder $query) {
    $query->where('content', 'like', 'foo%');
})->get();

// Retrieve posts with at least ten comments containing words like foo%...
$posts = App\Post::whereHas('comments', function (Builder $query) {
    $query->where('content', 'like', 'foo%');
}, '>=', 10)->get();

// Retrieve posts  that don't have any comments.
$posts = App\Post::doesntHave('comments')->get();

// retrieve all posts with comments from authors that are not banned:
use Illuminate\Database\Eloquent\Builder;

$posts = App\Post::whereDoesntHave('comments.author', function (Builder $query) {
    $query->where('banned', 0);
})->get();


// Querying Polymorphic Relationships


// Retrieve comments associated to posts or videos with a title like foo%...
$comments = App\Comment::whereHasMorph(
    'commentable',
    ['App\Post', 'App\Video'],
    function (Builder $query) {
        $query->where('title', 'like', 'foo%');
    }
)->get();


// Retrieve comments associated to posts with a title not like foo%...
$comments = App\Comment::whereDoesntHaveMorph(
    'commentable',
    'App\Post',
    function (Builder $query) {
        $query->where('title', 'like', 'foo%');
    }
)->get();

// You may use the $type parameter to add different constraints depending on the related model:
use Illuminate\Database\Eloquent\Builder;

$comments = App\Comment::whereHasMorph(
    'commentable',
    ['App\Post', 'App\Video'],
    function (Builder $query, $type) {
        $query->where('title', 'like', 'foo%');

        if ($type === 'App\Post') {
            $query->orWhere('content', 'like', 'foo%');
        }
    }
)->get();

/*
Instead of passing an array of possible polymorphic models, you may
provide * as a wildcard and let Laravel retrieve all the possible
polymorphic types from the database. Laravel will execute an
additional query in order to perform this operation:
*/

use Illuminate\Database\Eloquent\Builder;

$comments = App\Comment::whereHasMorph('commentable', '*', function (Builder $query) {
    $query->where('title', 'like', 'foo%');
})->get();

/*
If you want to count the number of results from a relationship
without actually loading them you may use the withCount method, which will place
a {relation}_count column on your resulting models. For example:
*/
$posts = App\Post::withCount('comments')->get();

foreach ($posts as $post) {
    echo $post->comments_count;
}

/*Sometimes you may wish to eager load a relationship,
but also specify additional query conditions for the
eager loading query. Here's an example:
*/

$users = App\User::with(['posts' => function ($query) {
    $query->where('title', 'like', '%first%');
}])->get();

$users = App\User::with(['posts' => function ($query) {
    $query->orderBy('created_at', 'desc');
}])->get();