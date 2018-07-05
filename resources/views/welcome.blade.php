@extends('layouts.app')

@section('content')
{{-- <router-view :user="{{ Auth::user() }}" :role="{{ json_encode($rolename) }}"></router-view> --}}
@guest
Logged out
@else
<my-header :user="{{ Auth::user() }}"></my-header>
<router-view :user="{{ Auth::user() }}"></router-view>
@endguest
@endsection()