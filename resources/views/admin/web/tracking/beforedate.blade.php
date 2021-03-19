@extends('admin.layouts.master')

@section('title')
Dreamship Tracking
@endsection

@section('content')
<div class="container">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tracking.dreamship.get') }}" method="get">
                @csrf
                <div class="form-group">
                    <label for="file">Trước ngày</label>
                    <input type="date" class="form-control" name="before_date" id="before_date" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit" id="submiBtn">
                        Track
                    </button>
                </div>
            </form>
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('trackingLi').classList.add('active');
</script>
@endsection
