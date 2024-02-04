@include('layout.header')

<div class="main-content app-content">

    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">DASHBOARD</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0)">Dashboard</a></li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title" style="display: flex; justify-content:space-between; align-items: center;">
                                    <p class="mg-b-0">On the Air</p>
                                    <p class="mg-b-0">
                                        {{$response->listeners->current}} Listeners
                                        <br>
                                        {{$response->listeners->unique}} Unique
                                    </p>
                                </div>
                            </div>
                            <div class="card-body px-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{$response->now_playing->song->art}}" style="width: 50px;">
                                            </div>
                                            <div class="col-9">
                                                Now Playing<br>
                                                {{$response->now_playing->song->title}}<br>
                                                Playlist : {{$response->now_playing->playlist}}<br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{$response->playing_next->song->art}}" style="width: 50px;">
                                            </div>
                                            <div class="col-9">
                                                Playing Next<br>
                                                {{$response->playing_next->song->title}}<br>
                                                Playlist : {{$response->playing_next->playlist}}<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title" style="display: flex; justify-content:space-between; align-items: center;">
                                    <p class="mg-b-0">Scheduled</p>
                                </div>
                            </div>
                            <div class="card-body px-3">
                                <div class="row">
                                    @foreach($schedule_response as $schedule)
                                    <div class="col-6">
                                        Playlist
                                        <br>
                                        <span style="font-weight: 700;">
                                            {{$schedule->name}}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        {{date('M d, Y, h:i A', $schedule->start_timestamp)}} - {{date('M d, Y, h:i A', $schedule->end_timestamp)}}<br>
                                        <span style="font-weight: 700;">
                                            @if($schedule->is_now)
                                            Now
                                            @else
                                            @php
                                            $start_date = new DateTime($schedule->start);
                                            $since_start = $start_date->diff(new DateTime());
                                            if($since_start->d > 0) {
                                            $remaining_time = "in ".$since_start->d." days";
                                            } else if($since_start->h > 0) {
                                            $remaining_time = "in ".$since_start->h." hours";
                                            } else if($since_start->i > 0) {
                                            $remaining_time = "in ".$since_start->i." minutes";
                                            }
                                            @endphp
                                            {{$remaining_time}}
                                            @endif
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title" style="display: flex; justify-content:space-between; align-items: center;">
                                    <p class="mg-b-0">
                                        Song Requests
                                        <span class="badge bg-primary">Enabled</span>
                                    </p>
                                </div>
                            </div>
                            <div class="card-body px-3">
                                <a href="javascript:void(0);" class="btn btn-warning">
                                    <i class="fa-solid fa-list"></i>
                                    View
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger">
                                    <i class="fas fa-times"></i>
                                    Disable
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title" style="display: flex; justify-content:space-between; align-items: center;">
                                    <p class="mg-b-0">
                                        Streamers/DJs
                                        <span class="badge bg-primary">Enabled</span>
                                    </p>
                                </div>
                            </div>
                            <div class="card-body px-3">
                                <a href="javascript:void(0);" class="btn btn-warning">
                                    <i class="fa-solid fa-gear"></i>
                                    Manage
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger">
                                    <i class="fas fa-times"></i>
                                    Disable
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                    </div>
                </div>
            </div><!-- col-end -->
        </div>

    </div>
    <!-- /Container -->

</div>
<!-- /main-content -->

@include('layout.footer')