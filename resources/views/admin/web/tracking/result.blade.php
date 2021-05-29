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
                    Tổng số order tìm được: <span id="count"></span>
                </small>
            </div>
            <div id="list" class="row"></div>
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('trackingLi').classList.add('active');
    console.log({!! $result !!});
    var result = JSON.parse('{!! $result !!}');
    var data = result.data;
    console.log('data', data);
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

        var redirect = '#';
        if(carrier == 'RoyalMail') {
            redirect = 'https://www3.royalmail.com/track-your-item#/tracking-results/' + tracking;
        } else if(carrier == 'DHLExpress') {
            redirect = 'https://www.dhl.com/us-en/home/tracking/tracking-ecommerce.html?submit=1&tracking-id=' + tracking;
        } else if(carrier == 'FedEx') {
            redirect = 'https://www.fedex.com/apps/fedextrack/?action=track&action=track&tracknumbers=' + tracking;
        } else if(carrier == 'UPS') {
            redirect = 'https://www.ups.com/WebTracking?loc=en_US&requester=ST&trackNums=' + tracking + '/trackdetails';
        } else if(carrier == 'Fastway') {
            redirect = 'https://www.aramex.com.au/tools/track/';
        } else if(carrier == 'AustraliaPost') {
            redirect = 'https://auspost.com.au/mypost/track/#/search';
        } else if(carrier == 'GSO') {
            redirect = 'https://www.gls-us.com/tracking';
        } else if(carrier == 'USPS') {
            redirect = 'https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=' + tracking;
        }
        
        document.getElementById('list').innerHTML += `
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${item.reference_id}</h5>
                        <p class="card-text">
                            <ul class="custom-ul">
                                <li>
                                    <b>Total cost:</b> $${item.total_cost}
                                </li>
                                <li>
                                    <b>Created at:</b> ${datee}
                                </li>
                                <li>
                                    <b>Carrier:</b> ${carrier}
                                </li>
                                <li>
                                    <b>Tracking:</b> ${tracking}
                                </li>
                                <li>
                                    <b>Status:</b> ${status}
                                </li>
                            </ul>
                        </p>
                        <a href="${redirect}" class="btn btn-primary" target="_blank">Track</a>
                    </div>
                </div>
            </div>
        `;
    });
</script>
@endsection
