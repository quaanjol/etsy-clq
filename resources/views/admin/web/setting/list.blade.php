@extends('admin.layouts.master')

@section('title')
All settings
@endsection

@section('style')
<style>
    .custom-ul li {
        list-style-type: square;
        margin-left: -18px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.setting.create') }}"><button class="btn btn-primary mb-3">
    Create new
    </button></a>
        
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
            All settings
            </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Value
                        </th>
                        <th scope="col">
                            Encrypted
                        </th>
                        <th scope="col">
                            Description
                        </th>
                        <th scope="col">
                            Update
                        </th>
                        <th scope="col">
                            Delete
                        </th>
                      </tr>
                </thead>
                <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <th scope="col">
                                {{$loop->iteration}}
                            </th>
                            <th>
                                {{ $setting->name }}
                            </th>
                            <th>
                                @if($setting->encrypt == 1)
                                {{ Illuminate\Support\Facades\Crypt::decryptString($setting->value) }}
                                @else
                                {{ $setting->value }}
                                @endif
                            </th>
                            <th>
                                @if($setting->encrypt == 1)
                                <i class="fas fa-check-circle text-success"></i>
                                @else
                                <i class="fas fa-times-circle text-danger"></i>
                                @endif
                            </th>
                            <th>
                                {!! $setting->description !!}
                            </th>
                            <th>
                                <a href="{{ Route('admin.setting.update', ['id' => $setting->id]) }}">
                                    <button class="btn btn-info">
                                        Udpate
                                    </button>
                                </a>
                            </th>
                            <th>
                                <form method="post" action="../../settings/{{$setting->id}}" onsubmit="return confirm('Are you sure you want to delete this?')">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" name="" value="Delete" class="btn btn-danger">
                                </form>
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
    document.getElementById('settingLi').classList.add('active');
</script>
@endsection
