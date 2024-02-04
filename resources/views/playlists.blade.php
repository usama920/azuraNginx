@include('layout.header')

<div class="main-content app-content">

    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Playlists</span>
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
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="{{url('/playlists/add')}}" class="btn btn-outline-primary">Add Playlist</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>Playlist</th>
                                        <th>Scheduling</th>
                                        <th>Songs</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($playlists as $playlist)
                                    <tr>
                                        <th scope="row">
                                            {{$playlist->name}}
                                            <br>
                                            @if($playlist->source == "remote_url")
                                            <span class="badge badge-sm badge-secondary-transparent me-1">Remote URL</span>
                                            @elseif($playlist->source == "songs")
                                            <span class="badge badge-sm badge-secondary-transparent me-1">Song-based</span>
                                            @endif
                                            {{$playlist->remote_url}}
                                        </th>

                                        @if($playlist->type == "default")
                                        <td>
                                            General Rotation
                                            <br>
                                            Weight: {{$playlist->weight}}
                                        </td>
                                        @elseif($playlist->type == "once_per_x_songs")
                                        <td>Once Per {{$playlist->play_per_songs}} Songs</td>
                                        @elseif($playlist->type == "once_per_x_minutes")
                                        <td>Once Per {{$playlist->play_per_minutes}} Minutes</td>
                                        @elseif($playlist->type == "once_per_hour")
                                        <td>Once Per Hour (at {{$playlist->play_per_hour_minute}})</td>
                                        @elseif($playlist->type == "custom")
                                        <td>Custom</td>
                                        @endif

                                        @if($playlist->type == "default")
                                        <td></td>
                                        @elseif($playlist->type == "custom")
                                        <td>{{$playlist->num_songs}} ({{secondsToTime($playlist->total_length)}})</td>
                                        @elseif($playlist->type == "once_per_x_songs" || $playlist->type == "once_per_x_minutes" || $playlist->type == "once_per_hour")
                                        <td>{{$playlist->num_songs}}</td>
                                        @endif
                                        <td name="bstable-actions">
                                            <div class="d-flex align-items-center">
                                                <a href="{{url('/playlists/edit/'.$playlist->id)}}" class="btn btn-sm btn-def tx-muted">
                                                    <i class="fe fe-edit"> </i>
                                                </a>
                                                <a href="{{url('/playlists/delete/'.$playlist->id)}}" class="btn btn-sm btn-def tx-muted">
                                                    <i class="fe fe-trash-2"> </i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Container -->

</div>
<!-- /main-content -->

<script src="{{asset('assets/js/index-4.js')}}"></script>

@include('layout.footer')