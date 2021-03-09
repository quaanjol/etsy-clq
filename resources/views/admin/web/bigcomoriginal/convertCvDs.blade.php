@extends('admin.layouts.master')

@section('title')
Bigcommerce Convert
@endsection

@section('content')
<div class="container">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">From {{ config('app.name') }} with <i class="fas fa-heart text-danger"></i></h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <form action="{{ route('bigcomoriginal.cvds.convert.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">File Excel</label>
                        <br>
                        <input type="file" class="form-file-control" name="file" id="file" required>
                    </div>
                    <div class="form-group">
                        <small class="text-danger" id="error"></small>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" type="submit" id="submiBtn">
                            Convert Canvas Ds
                        </button>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('bigcommerceLi').classList.add('active');


    var _validFileExtensions = [".xlsx", ".csv"];  
    document.getElementById('file').addEventListener('change', validateFile);

    function validateFile() {
        if(validate()) {
            document.getElementById('error').textContent = '';
            document.getElementById('submiBtn').disabled = false;
        } else {
            document.getElementById('error').textContent = 'Chỉ được file csv or xlsx thôi nha cưng';
            document.getElementById('submiBtn').disabled = true;
        }
    }

    function validate() {
        var arrInputs = document.getElementsByTagName("input");
        for (var i = 0; i < arrInputs.length; i++) {
            var oInput = arrInputs[i];
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                    
                    if (!blnValid) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

</script>
@endsection
