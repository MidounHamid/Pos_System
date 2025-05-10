@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div>
            @livewire('client-l')
        </div>
        <div class="col-md-5">
            @livewire('panier-index')
        </div>
        <div class="col-md-7">
            @livewire('articles-index')
        </div>
    </div>
</div>

@endsection
