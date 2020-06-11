@extends('layouts.app')

<title>province</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<style>
    .box {
        width: 500px;
        margin: 0 auto;
        border: 1px solid #ccc;
    }
</style>

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
</div>
@endif
เทส
</div>
</div>
</div>
</div>
</div> --}}
<div class="container box">
    <h3>ข้อมูลจังหวัดในประเทศไทย</h3>
    <div class="form-group">
        <select name="province" id="province" class="form-control province">
            <option value="">เลือกข้อมูลจังหวัด</option>
            @foreach ($list as $row)
            <option value="{{ $row->id }}">{{$row->name_th}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select name="amphures" id="amphures" class="form-control amphures">
            <option value="">เลือกข้อมูลอำเภอ</option>
        </select>
    </div>

    <div class="form-group">
        <select name="districts" id="districts" class="form-control districts">
            <option value="">เลือกข้อมูลตำบล</option>
        </select>
    </div>

</div>
{{ csrf_field()}}
@endsection


<script type="text/javascript">
    $(document).ready(function() {
        $('.province').change(function() {
            if ($(this).val() != '') {
                var select = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('dropdown.fetchAmphures')}}",
                    method: "POST",
                    data: {
                        select: select,
                        _token: _token
                    },
                    success: function(result) {
                        $('.amphures').html(result);
                    }
                })
            }
        });


    });

    $(document).ready(function() {
        $('.amphures').change(function() {
            if ($(this).val() != '') {
                var select = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('dropdown.fetchDistricts')}}",
                    method: "POST",
                    data: {
                        select: select,
                        _token: _token
                    },
                    success: function(result) {
                        $('.districts').html(result);
                    }
                })
            }
        });
    });
</script>