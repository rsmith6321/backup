@extends('layouts.app')
@section('header')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<style>
    .box {
        width: 500px;
        margin: 0 auto;
        border: 1px solid #ccc;
    }

    .button:active {
        background-color: #3e8e41;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }
</style>
@endsection

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h3>จองคิวออนไลน์</h3>
            <form>
                <div class="form-row" id="dropdown">
                    <div class="form-group col-md-4">
                        <label for="province">จังหวัด</label>
                        <select name="province_id" id="province" class="form-control province">
                            <option value="">เลือกจังหวัดของท่าน</option>
                            @foreach ($list as $row)
                            <option value="{{ $row->id }}">{{$row->name_th}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="amphure">อำเภอ</label>
                        <select name="amphure_id" id="amphure" class="form-control amphures">
                            <option value="">เลือกอำเภอของท่าน</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="district">ตำบล</label>
                        <select name="district_id" id="districts" class="form-control districts">
                            <option value="">เลือกตำบลของท่าน</option>
                        </select>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
{{ csrf_field()}}

<div class="container">
    <div class="response"></div>
    <div id='calendar'></div>
</div>



<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h2 class="modal-title">คำแนะนำ</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                คำอธิบาย
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                <button class="btn btn-default btn-success" type="submit" name="submit" value="Submit">ตกลง</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('foot_script')
<!-- dropdown -->
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




    // calendar
    jQuery(document).ready(function($) {
        var SITEURL = "{{url('/')}}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //holiday 
        function getDate(today = new Date()) {
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            return yyyy + '-' + mm + '-' + dd;
        }

        var calendar = $('#calendar').fullCalendar({
            displayEventTime: true,
            fixedWeekCount: false,
            contentHeight: 500,

            events: function(start, end, timezone, callback) {
                $.ajax({
                    type: 'GET',
                    url: 'http://127.0.0.1:8000/api/holiday',
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',

                    success: function(doc) {
                        var events = [];
                        var date = new Date();
                        var obj = doc;
                        var allDay = [];
                        var holidays = [];
                        var dayy = [];
                        // วันเปิดทั้งหมด
                        for (var i = 0; i < 90; i++) {
                            date.setDate(date.getDate() + 1);
                            if (date.getDay() != 0 && date.getDay() != 6) {
                                allDay.push({
                                    title: 'เปิดจอง',
                                    start: getDate(date),
                                })
                            }
                        }
                        // วันหยุด
                        $(doc).each(function() {
                            holidays.push({
                                title: $(this).attr('hol_name'),
                                start: $(this).attr('hol_date'), // will be parsed
                                color: '#ff0000'
                            });

                        });
                        // รวมทั้งหมด
                            dayy = allDay.map(dcut => holidays.find(allDays => allDays.start == dcut.start) || dcut);
                        

                        callback(dayy);
                    }

                });
            },
        });
    });



    // hide calendar
    $(document).ready(function() {
        $("#calendar").show()
        $("#districts").change(function() {
            if ($("#districts").val() != "") {
                $("#myModal").modal("show")
            }
        });

        $(".btn-success").click(function() {
            $("#dropdown").submit();
            $("#dropdown").submit(function() {
                var val = $("input[type=submit][clicked=true]").val();
                // DO WORK
            });
            $("#calendar").show();
            $("#myModal").modal("toggle")
        });
    });
</script>
@endsection