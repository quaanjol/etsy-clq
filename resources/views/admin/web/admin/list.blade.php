@extends('admin.layouts.master', ['user' => $user])

@section('title')
Admin List
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.create') }}"><button class="btn btn-primary mb-3">
        Tạo tài khoản admin
    </button></a>
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Tát cả tài khoản admin
            </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">
                            Tên
                        </th>
                        <th scope="col">
                            Email
                        </th>
                        <th scope="col">
                            Trạng thái
                        </th>
                        <th scope="col">
                            Xoá
                        </th>
                        <th scope="col">
                            Khôi phục
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
                        <th scope="col">
                            @if($user->deleted_at == null)
                            <span class="badge badge-primary">Active</span>
                            @else
                            <span class="badge badge-danger">Deleted</span>
                            @endif
                        </th>
                        <th>
                            @if($user->id == 1)
                            <button class="btn btn-secondary" disabled>
                                Xoá
                            </button>
                            @else
                                @if($user->deleted_at == null)
                                <form method="post" action="../../admins/{{$user->id}}" onsubmit="return confirm('Bạn chắc muốn xoá chứ?')">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" name="" value="Xoá" class="btn btn-danger">
                                </form>
                                @else
                                <button class="btn btn-secondary" disabled>
                                    Xoá
                                </button>
                                @endif
                            @endif
                        </th>
                        <th>
                            @if($user->deleted_at != null)
                            <form method="post" action="{{ Route('admin.restore', ['id' => $user->id]) }}" onsubmit="return confirm('Bạn chắc muốn khôi phục chứ?')">
                                    @csrf
                                    <input type="submit" name="" value="Khôi phục" class="btn btn-success">
                            </form>
                            @else
                            <button class="btn btn-secondary" disabled>
                                Khôi phục
                            </button>
                            @endif
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <div  class="d-flex justify-content-center">

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('adminLi').classList.add('active');
</script>
@endsection
