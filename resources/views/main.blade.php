@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/home.css') }}" rel="stylesheet">

<div class="flexcontainer">
<div class="col-md-12">
              <div class="row justify-content-center">
                    <div class="col-sm" id="column1">
                        <img src=" {{ asset('storage/company.png') }}" width="60%" height="90%"/>
                    </div>
                    <div class="col-sm" id="column2">
                         <img src=" {{ asset('storage/contacts.png') }}" width="60%" height="90%"/>         
                    </div>
                    <div class="col-sm" id="column3">
                        <img src=" {{ asset('storage/projects.png') }}" width="60%" height="90%"/>     
                    </div>
                    <div class="col-sm" id="column4">
                        <img src=" {{ asset('storage/User.png') }}" width="60%" height="90%"/>
                    </div>
</div>
                <div class="d-flex flex-row">
                    <div class="p-2" id="column5">
                        <img src=" {{ asset('storage/settings.png') }}" width="60%" height="90%"/>
                    </div>                  
    </div>
</div>
</div>



@endsection
