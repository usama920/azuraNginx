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
                    Edit Playlist
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
                <form method="post" action="{{url('/playlists/update')}}">
                    @csrf
                    <input type="hidden" name="playlist_id" value="{{$playlist->id}}">

                    <div class="card ">
                        <div class="card-header">
                            <div class="card-title">Basic Info</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Playlist Name</label>
                                        <input type="text" class="form-control" name="name" value="{{$playlist->name}}" required placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <span class="me-2">Enable</span>
                                            <input type="checkbox" name="enable" class="custom-switch-input" {{$playlist->is_enabled ? 'checked' : ''}}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            If disabled, the playlist will not be included in radio playback, but can still be managed.
                                        </span>
                                    </div>
                                </div>

                                <label>Source</label>
                                <div class="col-12">
                                    <label class="rdiobox">
                                        <input name="source" type="radio" value="songs" onchange="sourceChanged(this.value)" {{$playlist->source == "songs" ? 'checked' : ''}}>
                                        <span>Song-Based</span>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <label class="rdiobox">
                                        <input name="source" onchange="sourceChanged(this.value)" type="radio" value="remote_url" {{$playlist->source == "remote_url" ? 'checked' : ''}}>
                                        <span>Remote URL</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="song_based_card" style="{{$playlist->source == 'songs' ? 'display:block' : 'display:none'}}">
                        <div class="card-header">
                            <div class="card-title">Song-Based Playlist</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="avoid_duplicate" class="custom-switch-input" {{$playlist->avoid_duplicates ? 'checked' : ''}}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="me-2">Avoid Duplicate Artists/Titles</span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            Whether the AutoDJ should attempt to avoid duplicate artists and track titles when playing media from this playlist.
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="on_demand" class="custom-switch-input" {{$playlist->include_in_on_demand ? 'checked' : ''}}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="me-2">Include in On-Demand Player</span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            If this station has on-demand streaming and downloading enabled, only songs that are in playlists with this setting enabled will be visible.
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="allow_requests" class="custom-switch-input" {{$playlist->include_in_requests ? 'checked' : ''}}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="me-2">Allow Requests from This Playlist</span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            If requests are enabled for your station, users will be able to request media that is on this playlist.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="is_jingle" class="custom-switch-input" {{$playlist->is_jingle ? 'checked' : ''}}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="me-2">Hide Metadata from Listeners ("Jingle Mode")</span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            Enable this setting to prevent metadata from being sent to the AutoDJ for files in this playlist. This is useful if the playlist contains jingles or bumpers.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mg-t-15">
                                <div class="col-md-6">
                                    <label>Playlist Type</label>
                                    <label class="rdiobox">
                                        <input name="playlist_type" value="default" onchange="songBasedTypeChanged(this.value)" type="radio" {{$playlist->type == "default" ? 'checked' : ''}}>
                                        <span>General Rotation</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            Standard playlist, shuffles with other standard playlists based on weight.
                                        </p>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="playlist_type" value="once_per_x_songs" onchange="songBasedTypeChanged(this.value)" type="radio" {{$playlist->type == "once_per_x_songs" ? 'checked' : ''}}>
                                        <span>Once per x Songs</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            Play once every $x songs.
                                        </p>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="playlist_type" value="once_per_x_minutes" onchange="songBasedTypeChanged(this.value)" type="radio" {{$playlist->type == "once_per_x_minutes" ? 'checked' : ''}}>
                                        <span>Once per x Minutes</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            Play once every $x minutes.
                                        </p>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="playlist_type" value="once_per_hour" onchange="songBasedTypeChanged(this.value)" type="radio" {{$playlist->type == "once_per_hour" ? 'checked' : ''}}>
                                        <span>Once per x Hour</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            Play once per hour at the specified minute.
                                        </p>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="playlist_type" value="custom" onchange="songBasedTypeChanged(this.value)" type="radio" {{$playlist->type == "custom" ? 'checked' : ''}}>
                                        <span>Advanced</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            Manually define how this playlist is used in Liquidsoap configuration.
                                        </p>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <label>Song Playback Order</label>
                                    <label class="rdiobox">
                                        <input name="order" type="radio" value="shuffle" {{$playlist->order == "shuffle" ? 'checked' : ''}}>
                                        <span>Shuffled</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            The full playlist is shuffled and then played through in the shuffled order.
                                        </p>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="order" type="radio" value="random" {{$playlist->order == "random" ? 'checked' : ''}}>
                                        <span>Random</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            A completely random track is picked for playback every time the queue is populated.
                                        </p>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="order" type="radio" value="sequential" {{$playlist->order == "sequential" ? 'checked' : ''}}>
                                        <span>Sequential</span>
                                        <p class="tx-11" style="padding-inline-start: 30px;">
                                            The order of the playlist is manually specified and followed by the AutoDJ.
                                        </p>
                                    </label>

                                </div>

                                <div class="col-12 bd mg-t-10 pd-t-10" id="generalRotationCard" style="{{$playlist->type == 'default' ? 'display:block' : 'display:none'}}">
                                    <span class="tx-18">General Rotation</span>
                                    <hr>
                                    <div class="form-group select2-sm">
                                        <label for="weight">Playlist Weight</label>
                                        <select name="weight" class="form-select form-select-sm select2 select2-sm select2-no-search" id="inputGroupSelect01">
                                            @for($i = 1; $i <= 25; $i++) <option value="{{$i}}" {{$playlist->weight == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                        </select>
                                        <span class="tx-11">Higher weight playlists are played more frequently compared to other lower-weight playlists.</span>
                                    </div>
                                </div>

                                <div class="col-12 bd mg-t-10 pd-t-10" id="oncePerXSongsCard" style="{{$playlist->type == 'once_per_x_songs' ? 'display:block' : 'display:none'}}">
                                    <span class="tx-18">Once per x Songs</span>
                                    <hr>
                                    <div class="form-group select2-sm">
                                        <label for="play_per_songs">Number of Songs Between Plays</label>
                                        <input type="number" class="form-control" name="play_per_songs" id="play_per_songs" value="{{$playlist->play_per_songs}}">
                                        <span class="tx-11">This playlist will play every $x songs, where $x is specified here.</span>
                                    </div>
                                </div>

                                <div class="col-12 bd mg-t-10 pd-t-10" id="oncePerXMinutesCard" style="{{$playlist->type == 'once_per_x_minutes' ? 'display:block' : 'display:none'}}">
                                    <span class="tx-18">Once per x Minutes</span>
                                    <hr>
                                    <div class="form-group select2-sm">
                                        <label for="play_per_minutes">Number of Minutes Between Plays</label>
                                        <input type="number" class="form-control" name="play_per_minutes" id="play_per_minutes" value="{{$playlist->play_per_minutes}}">
                                        <span class="tx-11">This playlist will play every $x minutes, where $x is specified here.</span>
                                    </div>
                                </div>

                                <div class="col-12 bd mg-t-10 pd-t-10" id="oncePerHourCard" style="{{$playlist->type == 'once_per_hour' ? 'display:block' : 'display:none'}}">
                                    <span class="tx-18">Once per Hour</span>
                                    <hr>
                                    <div class="form-group select2-sm">
                                        <label for="play_per_hour_minute">Minute of Hour to Play</label>
                                        <input type="number" class="form-control" name="play_per_hour_minute" id="play_per_hour_minute" value="{{$playlist->play_per_hour_minute}}" max="60">
                                        <span class="tx-11">Specify the minute of every hour that this playlist should play.</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card" id="remote_url_card" style="{{$playlist->source == 'remote_url' ? 'display:block' : 'display:none'}}">
                        <div class="card-header">
                            <div class="card-title">Remote URL Playlist</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remote_url">Remote URL</label>
                                        <input type="text" class="form-control" name="remote_url" value="{{$playlist->remote_url}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="remote_url">Remote Playback Buffer (Seconds)</label>
                                        <input type="number" value="{{$playlist->remote_buffer}}" class="form-control" name="remote_buffer">
                                        <span class="tx-11">
                                            The length of playback time that Liquidsoap should buffer when playing this remote playlist. Shorter times may lead to intermittent playback on unstable connections.
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Remote URL Type</label>
                                    <label class="rdiobox">
                                        <input name="remote_type" value="stream" type="radio" {{$playlist->remote_type == 'stream' ? 'checked' : ''}}>
                                        <span>Icecast/Shoutcast Stream URL</span>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="remote_type" value="playlist" type="radio" {{$playlist->remote_type == 'playlist' ? 'checked' : ''}}>
                                        <span>Playlist (M3U/PLS) URL</span>
                                    </label>
                                    <label class="rdiobox">
                                        <input name="remote_type" value="other" type="radio" {{$playlist->remote_type == 'other' ? 'checked' : ''}}>
                                        <span>Other Remote URL (File, HLS, etc.)</span>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>

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
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-success mb-3" onclick="addSchedule()">+ Add Schedule Item</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Advanced</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Advanced Manual AutoDJ Scheduling Options
                                    </label>
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" name="interrupt" data-checkboxes="mygroup" class="custom-control-input" id="interrupt" {{in_array("interrupt", $playlist->backend_options) ? 'checked' : ''}}>
                                            <label for="interrupt" class="custom-control-label mt-1">Interrupt other songs to play at scheduled time.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" name="single_track" data-checkboxes="mygroup" class="custom-control-input" id="single_track" {{in_array("single_track", $playlist->backend_options) ? 'checked' : ''}}>
                                            <label for="single_track" class="custom-control-label mt-1">Only play one track at scheduled time.</label>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" name="merge" data-checkboxes="mygroup" class="custom-control-input" id="merge" {{in_array("merge", $playlist->backend_options) ? 'checked' : ''}}>
                                            <label for="merge" class="custom-control-label mt-1">Merge playlist to play as a single track.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                        </div>
                    </div>


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

    function sourceChanged(value) {
        if (value == "remote_url") {
            $('#song_based_card').css("display", "none");
            $('#remote_url_card').css("display", "block");
        } else if (value == "songs") {
            $('#remote_url_card').css("display", "none");
            $('#song_based_card').css("display", "block");
        }
    }

    function songBasedTypeChanged(value) {
        console.log(value);
        if (value == "default") {
            $('#oncePerXSongsCard').css("display", "none");
            $('#oncePerXMinutesCard').css("display", "none");
            $('#oncePerHourCard').css("display", "none");
            $('#generalRotationCard').css("display", "block");
        } else if (value == "once_per_x_songs") {
            $('#oncePerXMinutesCard').css("display", "none");
            $('#oncePerHourCard').css("display", "none");
            $('#generalRotationCard').css("display", "none");
            $('#oncePerXSongsCard').css("display", "block");
        } else if (value == "once_per_x_minutes") {
            $('#oncePerHourCard').css("display", "none");
            $('#generalRotationCard').css("display", "none");
            $('#oncePerXSongsCard').css("display", "none");
            $('#oncePerXMinutesCard').css("display", "block");
        } else if (value == "once_per_hour") {
            $('#oncePerXMinutesCard').css("display", "none");
            $('#generalRotationCard').css("display", "none");
            $('#oncePerXSongsCard').css("display", "none");
            $('#oncePerHourCard').css("display", "block");
        } else if (value == "custom") {
            $('#oncePerXMinutesCard').css("display", "none");
            $('#generalRotationCard').css("display", "none");
            $('#oncePerXSongsCard').css("display", "none");
            $('#oncePerHourCard').css("display", "none");
        }
    }
</script>
@include('layout.footer')