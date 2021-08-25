@extends('admin.layouts.master')

@section('title')
Create carrier
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.carrier.all') }}">
        <button class="btn btn-primary mb-3" type="button">
            Back to list
        </button>
    </a>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <form action="{{ Route('admin.carrier.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">
                            Name
                            </label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="ds_name">
                            Dreamship Name
                            </label>
                            <input type="text" name="ds_name" id="ds_name" class="form-control">
                        </div>
                    </div>
                    
                    <!-- bigcommerce -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="bigcom_name">
                            Bigcommerce Name
                            </label>
                            <input type="text" name="bigcom_name" id="bigcom_name" class="form-control">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="bigcom_code">
                            Bigcommerce Code
                            </label>
                            <input type="text" name="bigcom_code" id="bigcom_code" class="form-control">
                        </div>
                    </div>
                    
                    <!-- shopify -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="shopify_name">
                            Shopify Name
                            </label>
                            <input type="text" name="shopify_name" id="shopify_name" class="form-control">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="shopify_code">
                            Shopify Code
                            </label>
                            <input type="text" name="shopify_code" id="shopify_code" class="form-control">
                        </div>
                    </div>

                    <!-- paypal -->
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="paypal_name">
                            PayPal Name
                            </label>
                            <input type="text" name="paypal_name" id="paypal_name" class="form-control">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="paypal_code">
                            PayPal Code
                            </label>
                            <input type="text" name="paypal_code" id="paypal_code" class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-success" type="submit" id="submitBtn">
                                Finish
                            </button>
                        </div>
                    </div>    
                </div>
            </form>
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('carrierLi').classList.add('active');

</script>
@endsection
