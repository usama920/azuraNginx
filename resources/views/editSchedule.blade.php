@include('layout.header')

<script src="{{asset('assets/js/index-4.js')}}"></script>
<script src="{{asset('assets/plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/js/flatpickr.js')}}"></script>

<div class="main-content app-content">

    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1" style="display: flex; align-items: baseline;">
                    Edit Schedules
                </span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0)">Playlists</a></li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- row -->
        <div class="row">
            <div class="col-12">
                <form method="post" action="{{url('/playlists/schedule/update')}}">
                    @csrf
                    <input type="hidden" name="playlist_id" value="{{$playlist->id}}">

                    <div class="card" id="scheduleItems">
                        @foreach($playlist->schedule_items as $key => $schedule)
                        <div id="scheduleItem{{$key+1}}">
                            <input type="hidden" name="id[]" value="{{$schedule->id}}">
                            <div class="card-header pd-t-0">
                                <div class="card-title" style="display: flex; align-items:baseline;">
                                    Scheduled Time #{{$key + 1}}
                                    <button type="button" onclick='removeSchedule("{{$key+1}}")' class="btn btn-secondary mt-3 mb-0 mg-s-10">Remove</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Start Time</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-stopwatch tx-24 lh--9 op-6"></i>
                                                </div>
                                                <input type="text" class="form-control" id="starttime{{$key + 1}}" name="start_time[]" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">End Time</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-stopwatch tx-24 lh--9 op-6"></i>
                                                </div>
                                                <input type="text" name="end_time[]" class="form-control" id="endtime{{$key + 1}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Station Time Zone</label>
                                            <p class="tx-11">
                                                Standard playlist, shuffles with other standard playlists based on weight.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Start Date</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                                <input type="text" name="start_date[]" class="form-control" id="startdate{{$key + 1}}" required>
                                                <p class="tx-11">
                                                    To set this schedule to run only within a certain date range, specify a start and end date.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">End Date</label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                                <input type="text" name="end_date[]" class="form-control" id="enddate{{$key + 1}}" placeholder="Choose date" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="custom-switch">
                                                <input type="checkbox" name="loop_once{{$schedule->id}}" class="custom-switch-input" {{$schedule->loop_once == 1 ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="me-2">Loop Once</span>
                                            </label>
                                            <br>
                                            <span class="tx-11">
                                                Only loop through playlist once.
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Scheduled Play Days of Week</label>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="monday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="monday{{$schedule->id}}" {{in_array(1, $schedule->days) ? 'checked' : ''}}>
                                                <label for="monday{{$schedule->id}}" class="custom-control-label mt-1">Monday</label>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="tuesday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="tuesday{{$schedule->id}}" {{in_array(2, $schedule->days) ? 'checked' : ''}}>
                                                <label for="tuesday{{$schedule->id}}" class="custom-control-label mt-1">Tuesday</label>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="wednesday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="wednesday{{$schedule->id}}" {{in_array(3, $schedule->days) ? 'checked' : ''}}>
                                                <label for="wednesday{{$schedule->id}}" class="custom-control-label mt-1">Wednesday</label>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="thursday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="thursday{{$schedule->id}}" {{in_array(4, $schedule->days) ? 'checked' : ''}}>
                                                <label for="thursday{{$schedule->id}}" class="custom-control-label mt-1">Thursday</label>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="friday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="friday{{$schedule->id}}" {{in_array(5, $schedule->days) ? 'checked' : ''}}>
                                                <label for="friday{{$schedule->id}}" class="custom-control-label mt-1">Friday</label>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="saturday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="saturday{{$schedule->id}}" {{in_array(6, $schedule->days) ? 'checked' : ''}}>
                                                <label for="saturday{{$schedule->id}}" class="custom-control-label mt-1">Saturday</label>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="sunday{{$schedule->id}}" data-checkboxes="mygroup" class="custom-control-input" id="sunday{{$schedule->id}}" {{in_array(7, $schedule->days) ? 'checked' : ''}}>
                                                <label for="sunday{{$schedule->id}}" class="custom-control-label mt-1">Sunday</label>
                                            </div>
                                        </div>
                                        <p class="tx-11">
                                            Leave blank to play on every day of the week.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                        $referenceArray = str_split($schedule->start_time, 2);
                        if (count($referenceArray) > 1) {
                            $startMinutes = $referenceArray[1];
                            $startHour = $referenceArray[0];
                        } else {
                            $startMinutes = $referenceArray[0];
                            $startHour = "00";
                        }

                        $referenceArray = str_split($schedule->end_time, 2);
                        if (count($referenceArray) > 1) {
                            $endMinutes = $referenceArray[1];
                            $endHour = $referenceArray[0];
                        } else {
                            $endMinutes = $referenceArray[0];
                            $endHour = "00";
                        }

                        ?>

                        <script>
                            flatpickr("#starttime" + "{{$key+1}}", {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i",
                                defaultDate: "{{$startHour}}" + ":" + "{{$startMinutes}}"
                            });

                            flatpickr("#endtime" + "{{$key+1}}", {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i",
                                defaultDate: "{{$endHour}}" + ":" + "{{$endMinutes}}"
                            });

                            flatpickr("#startdate" + "{{$key+1}}", {
                                enableTime: true,
                                dateFormat: "Y-m-d",
                                defaultDate: "{{$schedule->start_date}}"
                            });

                            flatpickr("#enddate" + "{{$key+1}}", {
                                enableTime: true,
                                dateFormat: "Y-m-d",
                                defaultDate: "{{$schedule->end_date}}"
                            });
                        </script>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success mb-3" onclick="addSchedule()">+ Add Schedule Item</button>
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                    <a href="{{url('/playlists/edit/'.$playlist->id)}}" class="btn btn-warning mb-3">Cancel</a>
                </form>
            </div>
        </div>

    </div>
    <!-- /Container -->

</div>
<!-- /main-content -->




<script>
    let today = new Date();
    let startHours = today.getHours();
    let counter = (+"{{count($playlist->schedule_items)}}") + 1;
    let reference = +"{{$scheduleCountFinalId}}";

    if (startHours == 23) {
        endHours = 0;
    } else {
        endHours = startHours + 1;
    }


    function addSchedule() {
        reference++;
        html = `
        <div id="scheduleItem${counter}">
        <input type="hidden" name="reference[]" value="${reference}">
            <div class="card-header pd-t-0">
                <div class="card-title" style="display: flex; align-items:baseline;">
                    Scheduled Time #${counter}
                    <button type="button" onclick="removeSchedule(${counter})" class="btn btn-secondary mt-3 mb-0 mg-s-10">Remove</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Start Time</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="typcn typcn-stopwatch tx-24 lh--9 op-6"></i>
                                </div>
                                <input type="text" class="form-control" id="starttime${counter}" name="start_time[]">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">End Time</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="typcn typcn-stopwatch tx-24 lh--9 op-6"></i>
                                </div>
                                <input type="text" name="end_time[]" class="form-control" id="endtime${counter}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Station Time Zone</label>
                            <p class="tx-11">
                                Standard playlist, shuffles with other standard playlists based on weight.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Start Date</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                                <input type="text" name="start_date[]" class="form-control" id="startdate${counter}">
                                <p class="tx-11">
                                    To set this schedule to run only within a certain date range, specify a start and end date.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">End Date</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                                <input type="text" name="end_date[]" class="form-control" id="enddate${counter}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="loop_once${reference}" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="me-2">Loop Once</span>
                            </label>
                            <br>
                            <span class="tx-11">
                                Only loop through playlist once.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Scheduled Play Days of Week</label>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="monday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="monday${reference}">
                                <label for="monday${reference}" class="custom-control-label mt-1">Monday</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="tuesday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="tuesday${reference}">
                                <label for="tuesday${reference}" class="custom-control-label mt-1">Tuesday</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="wednesday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="wednesday${reference}">
                                <label for="wednesday${reference}" class="custom-control-label mt-1">Wednesday</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="thursday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="thursday${reference}">
                                <label for="thursday${reference}" class="custom-control-label mt-1">Thursday</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="friday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="friday${reference}">
                                <label for="friday${reference}" class="custom-control-label mt-1">Friday</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="saturday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="saturday${reference}">
                                <label for="saturday${reference}" class="custom-control-label mt-1">Saturday</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="sunday${reference}" data-checkboxes="mygroup" class="custom-control-input" id="sunday${reference}">
                                <label for="sunday${reference}" class="custom-control-label mt-1">Sunday</label>
                            </div>
                        </div>
                        <p class="tx-11">
                            Leave blank to play on every day of the week.
                        </p>
                    </div>

                </div>
            </div>
        </div>`;
        $('#scheduleItems').append(html);

        flatpickr("#starttime" + counter, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            defaultDate: startHours + ":" + today.getMinutes()
        });

        flatpickr("#endtime" + counter, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            defaultDate: endHours + ":" + today.getMinutes()
        });

        flatpickr("#startdate" + counter, {
            enableTime: true,
            dateFormat: "Y-m-d",
            defaultDate: today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate()
        });

        flatpickr("#enddate" + counter, {
            enableTime: true,
            dateFormat: "Y-m-d",
            defaultDate: today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate()
        });

        counter++;
    }

    function removeSchedule(value) {
        $('#scheduleItem' + value).remove();
    }
</script>
@include('layout.footer')