@extends('admin.layouts.master')

@section('title')
Create Admin
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.all') }}">
        <button class="btn btn-primary mb-3" type="button">
            Quay lại danh sách
        </button>
    </a>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From Liquor Store with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <form action="{{ Route('admin.storeCreate') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Tên
                            </label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="email">
                                Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password">
                                Password
                            </label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password2">
                                Confirm Password
                            </label>
                            <input type="password" name="password2" id="password2" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">
                                Hoàn tất
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
<!-- <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
    //CKEDITOR.instances['description'].setData(data);
    CKEDITOR.replace('descriptionEng');
</script> -->
<script>
    document.getElementById('adminLi').classList.add('active');
</script>
@endsection
