<table class="table table-striped table-boardered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Photo</th>
            <th>Date</th>
            <th style="width:162px;">Action</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($posts as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name }}</td>
                <td><img  style="width:50px;height:50px" src="{{ asset('images/'.$item->photo) }}" alt=""></td>
                <td>{{ Str::limit($item->description, 100, '...') }}</td>
                <td>{{ $item->created_at->format("d-m-Y") }}</td>
                <td><a class="btn btn-warning" href=" {{ route('posts.edit', $item->id) }}">Edit</a> | 
                    <form style="display:inline" action="{{ route('posts.destroy',$item->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input style="width:75px;" class="btn btn-danger" type="submit" value="Delete" />
                    </form>
                </td>
            </tr>   
        @endforeach
    </tbody>
</table>
{{ $posts->links() }}