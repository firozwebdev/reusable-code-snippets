<?php

public function getAllContactData(){
      // return Contact::all();
        if(request()->ajax())
        {
            return datatables()->of(Contact::latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<a href="/admin/contact-list/'.$data->id.'/view" class="btn btn-warning">View</a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a    href="/admin/contact-list/'.$data->id.'/delete" class="btn btn-danger">Delete</a>';
                        return $button;
                    })->editColumn('name', function($data) {
                        if($data->first_name && $data->last_name){
                            return $data->first_name.' '.$data->last_name;
                        }
                       

                    })->editColumn('services', function($data) {
                        $services_data = json_decode($data->services);
                        if(!empty($services_data)){
                            // $services ='';
                            // foreach($services_data as $services){
                            //     $services .= ', '. $services;
                            // }
                            // return $services;

                            $services = '';
                            foreach ($services_data as $service) { 
                                if ($services) $services .= ', ';
                                $services .= $service; 
                            }
                            return $services;
                        }
                        
                    })->editColumn('status', function($data) {
                        if($data->status == 1){
                            return "Read";
                        }else{
                            return "Unread";
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true); 
            
           
        }
        
    }