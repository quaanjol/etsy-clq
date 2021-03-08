@extends('admin.layouts.master')

@section('title')
Admin Profile
@endsection

@section('content')
<div class="container">
    
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <small style="">
                *Để trống password nếu không đổi password
            </snall>
            <form action="{{ Route('admin.profile.update') }}" method="post" class="mt-2">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Tên
                            </label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="email">
                                Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password">
                                Đổi mật khẩu
                            </label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password2">
                                Xác nhận mật khẩu
                            </label>
                            <input type="password" name="password2" id="password2" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">
                                Cập nhật
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

@endsection
