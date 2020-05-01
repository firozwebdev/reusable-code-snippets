<!--

1. composer require laravelcollective/html
2. add your new provider to the providers array of config/app.php:
    'providers' => [
        
        'Collective\Html\HtmlServiceProvider',
        
    ],

3. Finally, add two class aliases to the aliases array of config/app.php:
    'aliases' => [
        
        'Form' => 'Collective\Html\FormFacade',
        'Html' => 'Collective\Html\HtmlFacade',
        
    ],

Not: When collective form is used , no need to place {{ csrf_field() }} inside the form because it is automatically included.
-->



{!!Form::open( array('route' =>['save.category',['parameter' => 'value']],'method'=>'post','class'=>'form-horizontal contact_form'))!!}

    <div class="form-group">
        {{Form::label('name', 'Name', array('class' => ''))}}
        {{Form::text('name', $category_name = null, array('class' => 'form-control','id'=>'name',  'placeholder' => 'Name'))}}
        @if ($errors->has('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
    </div>
    <div class="form-group">
        {{Form::label('description', 'Description', array('class' => ''))}}
        {{Form::textarea('description', $description = null, array('class' => 'form-control','id'=>'description',  'placeholder' => 'Description'))}}
        @if ($errors->has('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
    </div>
    <div class="form-group">
        {{Form::label('publication_status', 'Publication Status', array('class' => ''))}}

            <select class="form-control" name="publication_status" data-placeholder="Choose a Category" tabindex="1">
                <option value="">Select Status...</option>
                <option value="1">Published</option>
                <option value="0">Unpublish</option>
            </select>
        @if ($errors->has('publication_status')) <p class="text-danger">{{ $errors->first('publication_status') }}</p> @endif
    </div>

    <div class="form-group">
        <button type="submit" id="submit" class="btn btn-primary">Create</button>
    </div>
{!!Form::close()!!}



<!-- This below form should be used for delete method with  laravel resource controller   -->

//Form

 {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', 'id'=>$post->id]]) !!}
    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
 {!! Form::close() !!}

 // Controller code will be ....
<?php 

 public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        Session::put('message', 'Delete !');
        return redirect()->route('posts.index');
}

