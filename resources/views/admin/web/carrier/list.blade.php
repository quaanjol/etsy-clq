@extends('admin.layouts.master')

@section('title')
All carriers
@endsection

@section('style')
<style>
    .custom-ul li {
        list-style-type: square;
        margin-left: -18px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.carrier.create') }}"><button class="btn btn-primary mb-3">
    Create new
    </button></a>
        
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
            All carriers
            </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            DS Name
                        </th>
                        <th scope="col">
                            Bigcommerce
                        </th>
                        <th scope="col">
                            Shopify
                        </th>
                        <th scope="col">
                            PayPal
                        </th>
                        <th scope="col">
                            Update
                        </th>
                        <th scope="col">
                            Delete
                        </th>
                      </tr>
                </thead>
                <tbody>
                    @foreach($carriers as $carrier)
                        <tr>
                            <th scope="col">
                                {{$loop->iteration}}
                            </th>
                            <th>
                                {{ $carrier->name }}
                            </th>
                            <th>
                                {{ $carrier->ds_name }}
                            </th>
                            <th>
                                {{ $carrier->bigcom_name }} ({{ $carrier->bigcom_code }})
                            </th>
                            <th>
                                {{ $carrier->shopify_name }} ({{ $carrier->shopify_code }})
                            </th>
                            <th>
                                {{ $carrier->paypal_name }} ({{ $carrier->paypal_code }})
                            </th>
                            <th>
                                <a href="{{ Route('admin.carrier.update', ['id' => $carrier->id]) }}">
                                    <button class="btn btn-info">
                                        Update
                                    </button>
                                </a>
                            </th>
                            <th>
                                <form method="post" action="../../carriers/{{$carrier->id}}" onsubmit="return confirm('Are you sure you want to delete this?')">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" name="" value="Delete" class="btn btn-danger">
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
        
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('carrierLi').classList.add('active');
</script>
@endsection
