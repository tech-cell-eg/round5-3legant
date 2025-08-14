@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>E-commerce Dashboard</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $counts['products'] }}</h3>

                    <p>Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $counts['customers'] }}</h3>

                    <p>Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-house-user"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

    </div>
@stop
