@extends('admin.layouts.master')

@section('title')
Customer List
@endsection

@section('content')
<div class="container">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Tất cả khách hàng
            </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">
                            Tên
                        </th>
                        <th scope="col">
                            Email
                        </th>
                      </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="col">
                            {{$loop->iteration}}
                        </th>
                        <th scope="col">
                            {{ $user->name }}
                        </th>
                        <th scope="col">
                            {{ $user->email }}
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
    document.getElementById('userLi').classList.add('active');
</script>
@endsection
