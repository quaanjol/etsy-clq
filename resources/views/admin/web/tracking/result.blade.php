@extends('admin.layouts.master')

@section('title')
Dreamship Tracking Result
@endsection

@section('content')
<div class="container">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <div id="list"></div>
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('trackingLi').classList.add('active');

    var result = JSON.parse('{!! ($result) !!}');
    var data = result.data;

    Array.from(data).forEach(item => {
        document.getElementById('list').innerHTML += `
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <b>Order:</b> ${item.reference_id}
                </li>
                <li class="list-group-item">
                    <b>Total cost:</b> $${item.total_cost}
                </li>
                <li class="list-group-item">
                    <b>Carrier:</b> ${item.fulfillments[0].trackings[0].carrier}
                </li>
                <li class="list-group-item">
                    <b>Tracking:</b> ${item.fulfillments[0].trackings[0].tracking_number}
                </li>
                <li class="list-group-item">
                    <b>Status:</b> <span class="text-capitalize">${item.fulfillments[0].trackings[0].status}</span>
                </li>
            </ul>
        `;
    });
</script>
@endsection
