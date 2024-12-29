@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container-fluid" style="padding-top: 40px;">
    <!-- Header Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Menyertakan bagian default -->
    @include('default')

    <div class="p-6 m-20 bg-white rounded shadow">
        <!-- Menampilkan chart -->
        {!! $chart->container() !!}
    </div>

    <!-- Memasukkan CDN dan script chart -->
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endsection
