@extends('admin.layouts.master')

@section('title')
Dreamship Tracking Result
@endsection

@section('style')
<style>
    .custom-ul {
        list-style-type: square;;
    }

    .custom-ul li {
        margin-left: -18px;
    }

    .col-md-4 .card:hover {
        background-color: rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <small class="text-danger">
                    Tổng số order tìm được: <span id="count">{{ count($result) }}</span>
                </small>
            </div>
            <div class="mb-3">
                <form action="{{ route('tracking.dreamship.export') }}" method="post">
                @csrf

                <input type="hidden" name="total_order" value="{{ count($result) }}">

                @foreach($result as $formIndex => $item)
                <input type="hidden" name="{{ $formIndex }}_order_number" value="{{ $item->reference_id }}">
                <input type="hidden" name="{{ $formIndex }}_created_at" value="{{  explode('T', $item->created_at)[0] }}">
                <input type="hidden" name="{{ $formIndex }}_total_cost" value="${{ $item->total_cost }}">
                
                @if(count($item->fulfillments) == 0)
                <input type="hidden" name="{{ $formIndex }}_carrier" value="Not available yet">
                @else
                    @if(count($item->fulfillments[0]->trackings) == 0)
                    <input type="hidden" name="{{ $formIndex }}_carrier" value="No tracking yet">
                    @else
                    <input type="hidden" name="{{ $formIndex }}_carrier" value="{{ $item->fulfillments[0]->trackings[0]->carrier }}">
                    @endif
                @endif

                @if(count($item->fulfillments) == 0)
                <input type="hidden" name="{{ $formIndex }}_tracking" value="">
                @else
                    @if(count($item->fulfillments[0]->trackings) == 0)
                    <input type="hidden" name="{{ $formIndex }}_tracking" value="">
                    @else
                    <input type="hidden" name="{{ $formIndex }}_tracking" value="{{ $item->fulfillments[0]->trackings[0]->tracking_number }}">
                    @endif
                @endif
                
                @if(count($item->fulfillments) == 0)
                <input type="hidden" name="{{ $formIndex }}_delivery_status" value="">
                @else
                    @if(count($item->fulfillments[0]->trackings) == 0)
                    <input type="hidden" name="{{ $formIndex }}_delivery_status" value="">
                    @else
                    <input type="hidden" name="{{ $formIndex }}_delivery_status" value="{{ $item->fulfillments[0]->trackings[0]->status }}">
                    @endif
                @endif
                
                @endforeach

                <div class="form-group mb-2">
                    <select name="order_type" id="order_type" class="form-control">
                        <option value="" selected>
                            All orders
                        </option>
                        <option value="amz">
                            AMZ
                        </option>
                        <option value="ca">
                            CA
                        </option>
                        <option value="fyi">
                            FYI
                        </option>
                        <option value="hkl">
                            HKL
                        </option>
                        <option value="lkh">
                            LKH
                        </option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <select name="download_type" id="download_type" class="form-control">
                        <option value="normal_tracking" selected>
                            Download tracking file
                        </option>
                        <option value="bigcom_add_tracking">
                            Download Bigcommerce add tracking file
                        </option>
                    </select>
                </div>
                

                <button class="btn btn-success" type="submit">
                    Export tracking file
                </button>
                </form>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>
                                Order Number                            
                            </td>
                            <td>
                                Created at
                            </td>
                            <td>
                                Total cost
                            </td>
                            <td>
                                Carrier
                            </td>
                            <td>
                                Tracking
                            </td>
                            <td>
                                Delivery status
                            </td>
                            <td>
                                Rejected status
                            </td>   
                            <td>
                                Track
                            </td>         
                        </tr>
                    </thead>
                    <tbody id="list">
                        @foreach($result as $viewIndex => $item)
                        <tr class="tr_list" data-order_id="{{ $item->reference_id }}">
                            <td>
                                {{ $item->reference_id }} - {{ $viewIndex }}
                            </td>
                            <td>
                                {{  explode("T", $item->created_at)[0] }}
                            </td>
                            <td>
                                ${{ $item->total_cost }}
                            </td>
                            <td class="text-uppercase">
                                @if(count($item->fulfillments) == 0)
                                Not available yet
                                @else
                                    @if(count($item->fulfillments[0]->trackings) == 0)
                                    Not available yet
                                    @else
                                    {{ $item->fulfillments[0]->trackings[0]->carrier }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(count($item->fulfillments) == 0)
                                
                                @else
                                    @if(count($item->fulfillments[0]->trackings) == 0)
                                    
                                    @else
                                    {{ $item->fulfillments[0]->trackings[0]->tracking_number }}
                                    @endif
                                @endif
                            </td>
                            <td class="text-capitalize">
                                @if(count($item->fulfillments) == 0)
                                
                                @else
                                    @if(count($item->fulfillments[0]->trackings) == 0)
                                    
                                    @else
                                    {{ $item->fulfillments[0]->trackings[0]->status }}
                                    @endif
                                @endif
                            </td>
                            <td class="text-capitalize">
                                {{ $item->rejected_status }}
                            </td>   
                            <td>
                                @if(count($item->fulfillments) == 0)
                                <button class="btn btn-primary" disabled="true">Track</button>
                                @else
                                    @if(count($item->fulfillments[0]->trackings) == 0)
                                    <button class="btn btn-primary" disabled="true">Track</button>
                                    @else
                                    <a href="{{ $item->fulfillments[0]->trackings[0]->tracking_url }}" class="btn btn-primary" target="_blank">Track</a>
                                    @endif
                                @endif
                            </td>         
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
    const order_type = document.getElementById('order_type')
    const tr_list = document.querySelectorAll('.tr_list');

    Array.from(tr_list).forEach(item => {
        if(order_type.value == '') {
            item.style.display = 'table-row'
        } else {
            var itemOrderId = item.dataset.order_id
            
            if(itemOrderId.toLowerCase().indexOf(order_type.value) != -1) {
                item.style.display = 'table-row'
            } else {
                item.style.display = 'none'
            }
        }
    })

    order_type.addEventListener('change', e => {
        Array.from(tr_list).forEach(item => {
            if(e.target.value == '') {
                item.style.display = 'table-row'
            } else {
                var itemOrderId = item.dataset.order_id
                
                if(itemOrderId.toLowerCase().indexOf(e.target.value) != -1) {
                    item.style.display = 'table-row'
                } else {
                    item.style.display = 'none'
                }
            }
        })
    })
</script>
@endsection

