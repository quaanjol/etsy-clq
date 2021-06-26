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
                <input type="hidden" name="{{ $formIndex }}_carrer" value="Not available yet">
                @else
                    @if(count($item->fulfillments[0]->trackings) == 0)
                    <input type="hidden" name="{{ $formIndex }}_carrer" value="Not available yet">
                    @else
                    <input type="hidden" name="{{ $formIndex }}_carrer" value="{{ $item->fulfillments[0]->trackings[0]->carrier }}">
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
                        <tr>
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
