@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<script src="{{ asset('js/home.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a id="breadcrumbid">Dashboard</a></li>
                    </ol>
                </nav>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-6 col-sm-4 col-md-3" id="column1">
                                <a href="{{ route('companies') }}">
                                <img class="img-fluid" src=" {{ asset('storage/company.png') }}"
                                    onmouseover="this.src='storage/company2.png'"
                                    onmouseout="this.src='storage/company.png'"/>
                                </a>
                                <p>Companies</p>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3" id="column2">
                                <div id="extra_options_1"></div>
                                <div id="extra_options_2"></div>
                                 <a href="{{ route('customers') }}">
                                <img class="img-fluid" src=" {{ asset('storage/contacts.png') }}"
                                    onmouseover="this.src='storage/contacts2.png'"
                                    onmouseout="this.src='storage/contacts.png'" />
                                </a>
                                <p>Contacts</p>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3" id="column3">
                                 <a href="{{ route('projects') }}"> 
                                <img class="img-fluid" src=" {{ asset('storage/projects.png') }}"
                                    onmouseover="this.src='storage/projects2.png'"
                                    onmouseout="this.src='storage/projects.png'" />
                                </a>
                                <p>Projects</p>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3" id="column4">
                                <a href="{{ route('users') }}">
                                    <img class="img-fluid" src=" {{ asset('storage/User.png') }}"
                                    onmouseover="this.src='storage/User2.png'"
                                    onmouseout="this.src='storage/User.png'" />
                                </a>
                                <p>Users</p>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3" id="column5">
                                <img class="img-fluid" src=" {{ asset('storage/settings.png') }}"
                                    onmouseover="this.src='storage/settings2.png'"
                                    onmouseout="this.src='storage/settings.png'" />
                                <p>Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection