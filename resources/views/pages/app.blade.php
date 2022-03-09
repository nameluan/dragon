@extends('pages.index')
@section('content')
    <div class="container m-auto">

        <h1 class="lg:text-2xl text-lg font-extrabold leading-none text-gray-900 tracking-tight mb-5"> Feed </h1>

        <div class="lg:flex justify-center lg:space-x-10 lg:space-y-0 space-y-5">

            @include('pages.left-slidebar')

            @include('pages.right-slidebar')

        </div>


    </div>
@endsection
