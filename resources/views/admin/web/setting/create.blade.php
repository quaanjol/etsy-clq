@extends('admin.layouts.master')

@section('title')
Create setting
@endsection

@section('content')
<div class="container">
    <a href="{{ Route('admin.setting.all') }}">
        <button class="btn btn-primary mb-3" type="button">
            Back to list
        </button>
    </a>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <form action="{{ Route('admin.setting.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">
                            Name
                            </label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="value">
                            Value
                            </label>
                            <input type="text" name="value" id="value" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="encrypt">
                            Encrypt
                            </label>
                            <br>
                            <input type="checkbox" name="encrypt" id="encrypt">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">
                            Description
                            </label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-success" type="submit" id="submitBtn">
                                Finish
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
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('description');
</script>
<script>
    document.getElementById('settingLi').classList.add('active');

</script>
@endsection
