@extends('layout.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight:bold">
                    
                    Contact List
                    
                    
                   
                
                </div>
                

                <div class="card-body">
                    
                    <table id="loadData" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                              
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Services</th>
                                <th>Status</th>
                                <th style="width:117px;">Action</th>
                            </tr>
                        </thead>
                        
                        
                    </table>
                 
                  
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
@section('scripts')
<script>
    console.log('Hello I amhere');
</script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        
               $('#loadData').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ route('getAllContactData') }}',
               columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'country', name: 'country' },
                    { data: 'services', name: 'services' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
         });



       
 </script>

@endsection
