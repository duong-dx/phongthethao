@extends('layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/cssProfileAdmin.css') }}">
@endsection
@section('content')
	<div style="font-size: 15px !important;" class="container">
		<div class="container emp-profile">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                        	@if(Auth::user()->thumbnail==null)
                            	<img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt=""/>
                            @else
                            	<img src="/storage/{{ Auth::user()->thumbnail }}" alt=""/>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                       {{ Auth::user()->name }}
                                    </h5>
                                    <h6>
                                        {{ Auth::user()->email }}
                                    </h6>
                                  
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>WORK LINK</p>
                            <a href="javascript:;">Website Link</a><br/>
                            <a href="javascript:;">Bootsnipp Profile</a><br/>
                            <a href="javascript:;">Bootply Profile</a>
                            <p>SKILLS</p>
                            <a href="javascript:;">Web Designer</a><br/>
                            <a href="javascript:;">Web Developer</a><br/>
                            <a href="javascript:;">WordPress</a><br/>
                            <a href="javascript:;">WooCommerce</a><br/>
                            <a href="javascript:;">PHP, .Net</a><br/>
                        </div>
                    </div>
                    <div class="col-md-8">
                   
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ Auth::user()->id }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ Auth::user()->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ Auth::user()->mobile }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Profession</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Web Developer and Designer</p>
                                            </div>
                                        </div>
                           
                    </div>
                </div>
                
        </div>
	</div>

@endsection
@section('js')
@endsection