@extends('admin.layouts.master')

@section('title')
Dashboard
@endsection

@section('content')
<div class="container">

    <div class="row">
        <!-- bigcommerce -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Bigcommerce
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    
                                </div>
                        </div>
                        <div class="col-auto">
                            <i class="fab fa-bootstrap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- shopify -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Shopify
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fab fa-shopify fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ config('app.name', 'Laravel') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ URL::asset('admin/img/undraw_posting_photo.svg') }}" alt="">
                    </div>
                    <p>
                        
                    </p>
                    <a target="_blank" rel="nofollow" href="" target="_blank">
                        
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('dashboardLi').classList.add('active');
</script>
@endsection
