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
            <small class="text-danger">
                Tổng số order tìm được: <span id="count"></span>
            </small>
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
    console.log(data);
    document.getElementById('count').textContent = data.length;

    Array.from(data).forEach(item => {
        var datee = item.created_at.split("T")[0];
        if(item.fulfillments[0].trackings.length == 0) {
            var carrier = "Unknown";
            var tracking = "Unknown";
            var status = "Not available yet";
        } else {
            var carrier = item.fulfillments[0].trackings[0].carrier;
            var tracking = item.fulfillments[0].trackings[0].tracking_number;
            var status = item.fulfillments[0].trackings[0].status;
        }
        document.getElementById('list').innerHTML += `
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <b>Order:</b> ${item.reference_id}
                </li>
                <li class="list-group-item">
                    <b>Total cost:</b> $${item.total_cost}
                </li>
                <li class="list-group-item">
                    <b>Created at:</b> ${datee}
                </li>
                <li class="list-group-item">
                    <b>Carrier:</b> ${carrier}
                </li>
                <li class="list-group-item">
                    <b>Tracking:</b> ${tracking}
                </li>
                <li class="list-group-item">
                    <b>Status:</b> <span class="text-capitalize">${status}</span>
                </li>
            </ul>
        `;
    });
</script>
@endsection
