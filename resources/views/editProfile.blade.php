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
                    Edit Profile
                    <a href="{{url('/playlists/schedule/edit')}}" class="btn btn-info mt-3 mb-0 mg-s-10">Schedule</a>
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
                <form method="post" action="{{url('/playlists/save')}}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Basic Info</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" required placeholder="Name" value="{{$response->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Genre</label>
                                        <input type="text" class="form-control" name="genre" placeholder="Genre">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Description</label>
                                        <textarea class="form-control" name="description">{{$response->name}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Web Site URL</label>
                                        <input type="text" class="form-control" name="name" placeholder="Web Site URL" value="{{$response->url}}">
                                        <span class="tx-11">
                                            This should be the public-facing homepage of the radio station, not the AzuraCast URL. It will be included in broadcast details.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Time Zone</label>
                                        <input type="text" class="form-control" name="name" placeholder="Genre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">URL Stub</label>
                                        <input type="text" class="form-control" name="shortcode" placeholder="URL Stub" value="{{$response->shortcode}}">
                                        <span class="tx-11">
                                            Optionally specify a short URL-friendly name, such as "my_station_name", that will be used in this station's URLs. Leave this field blank to automatically create one based on the station name.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Number of Visible Recent Songs</label>
                                        <input type="text" class="form-control" name="name" placeholder="Web Site URL">
                                        <span class="tx-11">
                                            Customize the number of songs that will appear in the "Song History" section for this station and in all public APIs.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <span class="me-2">Enable Public Pages</span>
                                            <input type="checkbox" name="is_public" class="custom-switch-input" {{$response->is_public ? 'checked' : ''}}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            Show the station in public pages and general API results.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <span class="me-2">Enable On-Demand Streaming</span>
                                            <input type="checkbox" name="enable" class="custom-switch-input" checked>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            If enabled, music from playlists with on-demand streaming enabled will be available to stream via a specialized public page.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <span class="me-2">Enable Downloads on On-Demand Page</span>
                                            <input type="checkbox" name="enable" class="custom-switch-input" checked>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                        <br>
                                        <span class="tx-11">
                                            If enabled, a download button will also be present on the public "On-Demand" page.
                                        </span>
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


@include('layout.footer')