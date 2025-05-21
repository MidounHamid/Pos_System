@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">

        <!-- Left Column: Client + Panier -->
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                    @livewire('client-l')
            </div>

            <div class="card shadow-sm">
                    @livewire('panier-index')
            </div>
        </div>

        <!-- Right Column: Articles -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    @livewire('articles-index')
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
