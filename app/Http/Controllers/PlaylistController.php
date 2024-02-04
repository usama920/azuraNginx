<?php

namespace App\Http\Controllers;

use App\Models\User;
use AzuraCast\Api\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PlaylistController extends Controller
{
    public function Playlists()
    {
        $url = "https://azuracast.casthost.net/api/station/27/playlists";

        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $playlists = json_decode(curl_exec($ch));

        return view('playlists', compact('playlists'));
    }

    public function AddPlaylist()
    {
        return view('addPlaylist');
    }

    public function SavePlaylist(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'source' => 'required',
            'order' => 'required',
            'remote_type' => 'required',
            'playlist_type' => 'required'
        ]);

        $schedule = [];
        $referenceCounter = 0;
        if (isset($request->start_time)) {
            foreach ($request->start_time as $key => $startTime) {
                $reference = [];

                if (isset($request->reference[$referenceCounter])) {
                    $loop_once_reference = "loop_once" . $request->reference[$referenceCounter];
                    $days = [];

                    $forMonday = "monday" . $request->reference[$referenceCounter];
                    if (isset($request->$forMonday)) {
                        array_push($days, 1);
                    }
                    $forTuesday = "tuesday" . $request->reference[$referenceCounter];
                    if (isset($request->$forTuesday)) {
                        array_push($days, 2);
                    }
                    $forWednesday = "wednesday" . $request->reference[$referenceCounter];
                    if (isset($request->$forWednesday)) {
                        array_push($days, 3);
                    }
                    $forThursday = "thursday" . $request->reference[$referenceCounter];
                    if (isset($request->$forThursday)) {
                        array_push($days, 4);
                    }
                    $forFriday = "friday" . $request->reference[$referenceCounter];
                    if (isset($request->$forFriday)) {
                        array_push($days, 5);
                    }
                    $forSaturday = "saturday" . $request->reference[$referenceCounter];
                    if (isset($request->$forSaturday)) {
                        array_push($days, 6);
                    }
                    $forSunday = "sunday" . $request->reference[$referenceCounter];
                    if (isset($request->$forSunday)) {
                        array_push($days, 7);
                    }

                    $reference = [
                        "start_time" => trim(str_replace(':', '', $startTime)),
                        "end_time" => trim(str_replace(':', '', $request->end_time[$key])),
                        'start_date' => $request->start_date[$key],
                        'end_date' => $request->end_date[$key],
                        'loop_once' => isset($request->$loop_once_reference) ? true : false,
                        'days' => $days
                    ];
                    array_push($schedule, $reference);
                }
                $referenceCounter++;
            }
        }


        if (empty($request->remote_buffer) || $request->remote_buffer < 0) {
            $request->merge(['remote_buffer' => 0]);
        }

        if (empty($request->play_per_songs) || $request->play_per_songs < 0) {
            $request->merge(['play_per_songs' => 0]);
        }

        if (empty($request->play_per_minutes) || $request->play_per_minutes < 0) {
            $request->merge(['play_per_minutes' => 0]);
        }

        if (empty($request->play_per_hour_minute) || $request->play_per_hour_minute < 0) {
            $request->merge(['play_per_hour_minute' => 0]);
        }

        if (empty($request->weight) || $request->weight < 1 || $request->weight > 25) {
            $request->merge(['weight' => 1]);
        }

        $backend_options = [];
        if (isset($request->interrupt) && $request->interrupt == "on") {
            array_push($backend_options, "interrupt");
        }
        if (isset($request->single_track) && $request->single_track == "on") {
            array_push($backend_options, "single_track");
        }
        if (isset($request->merge) && $request->merge == "on") {
            array_push($backend_options, "merge");
        }

        $data = [
            "name" => $request->name,
            "is_enabled" => isset($request->enable) && $request->enable == "on" ? true : false,
            'type' => $request->source == "remote_url" ? "default" : $request->playlist_type,
            "source" => $request->source,
            "order" => $request->order,
            "remote_url" => $request->remote_url,
            "remote_type" => $request->remote_type,
            "remote_buffer" => $request->remote_buffer,
            "is_jingle" => isset($request->is_jingle) && $request->is_jingle == "on" ? true : false,
            "play_per_songs" => $request->play_per_songs,
            "play_per_minutes" => $request->play_per_minutes,
            "play_per_hour_minute" => $request->play_per_hour_minute,
            "weight" => $request->weight,
            "include_in_requests" => isset($request->allow_requests) && $request->allow_requests == "on" ? true : false,
            "include_in_on_demand" => isset($request->on_demand) && $request->on_demand == "on" ? true : false,
            "backend_options" => $backend_options,
            "avoid_duplicates" => isset($request->avoid_duplicate) && $request->avoid_duplicate == "on" ? true : false,
            "schedule_items" => $schedule
        ];

        $json_data = json_encode($data);
        $url = "https://azuracast.casthost.net/api/station/27/playlists";
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return redirect('/playlists');
    }

    public function EditPlaylist($id)
    {
        $url = "https://azuracast.casthost.net/api/station/27/playlist/" . $id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $playlist = json_decode(curl_exec($ch));
        $scheduleCount = count($playlist->schedule_items);
        if ($scheduleCount > 0) {
            $scheduleCountFinalId = $playlist->schedule_items[$scheduleCount - 1]->id;
        } else {
            $scheduleCountFinalId = 0;
        }
        return view('editPlaylist', compact('playlist', 'scheduleCount', 'scheduleCountFinalId'));
    }

    public function UpdatePlaylist(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'source' => 'required',
            'order' => 'required',
            'remote_type' => 'required',
            'playlist_type' => 'required',
            'playlist_id' => 'required'
        ]);

        $schedule = [];
        $referenceCounter = 0;
        if (isset($request->start_time)) {
            foreach ($request->start_time as $key => $startTime) {
                $reference = [];
                if (isset($request->id[$key])) {
                    $loop_once_reference = "loop_once" . $request->id[$key];
                    $days = [];

                    $forMonday = "monday" . $request->id[$key];
                    if (isset($request->$forMonday)) {
                        array_push($days, 1);
                    }
                    $forTuesday = "tuesday" . $request->id[$key];
                    if (isset($request->$forTuesday)) {
                        array_push($days, 2);
                    }
                    $forWednesday = "wednesday" . $request->id[$key];
                    if (isset($request->$forWednesday)) {
                        array_push($days, 3);
                    }
                    $forThursday = "thursday" . $request->id[$key];
                    if (isset($request->$forThursday)) {
                        array_push($days, 4);
                    }
                    $forFriday = "friday" . $request->id[$key];
                    if (isset($request->$forFriday)) {
                        array_push($days, 5);
                    }
                    $forSaturday = "saturday" . $request->id[$key];
                    if (isset($request->$forSaturday)) {
                        array_push($days, 6);
                    }
                    $forSunday = "sunday" . $request->id[$key];
                    if (isset($request->$forSunday)) {
                        array_push($days, 7);
                    }

                    $reference = [
                        "id" => $request->id[$key],
                        "start_time" => trim(str_replace(':', '', $startTime)),
                        "end_time" => trim(str_replace(':', '', $request->end_time[$key])),
                        'start_date' => $request->start_date[$key],
                        'end_date' => $request->end_date[$key],
                        'loop_once' => isset($request->$loop_once_reference) ? true : false,
                        'days' => $days
                    ];
                    array_push($schedule, $reference);
                } else {
                    if (isset($request->reference[$referenceCounter])) {
                        $loop_once_reference = "loop_once" . $request->reference[$referenceCounter];
                        $days = [];

                        $forMonday = "monday" . $request->reference[$referenceCounter];
                        if (isset($request->$forMonday)) {
                            array_push($days, 1);
                        }
                        $forTuesday = "tuesday" . $request->reference[$referenceCounter];
                        if (isset($request->$forTuesday)) {
                            array_push($days, 2);
                        }
                        $forWednesday = "wednesday" . $request->reference[$referenceCounter];
                        if (isset($request->$forWednesday)) {
                            array_push($days, 3);
                        }
                        $forThursday = "thursday" . $request->reference[$referenceCounter];
                        if (isset($request->$forThursday)) {
                            array_push($days, 4);
                        }
                        $forFriday = "friday" . $request->reference[$referenceCounter];
                        if (isset($request->$forFriday)) {
                            array_push($days, 5);
                        }
                        $forSaturday = "saturday" . $request->reference[$referenceCounter];
                        if (isset($request->$forSaturday)) {
                            array_push($days, 6);
                        }
                        $forSunday = "sunday" . $request->reference[$referenceCounter];
                        if (isset($request->$forSunday)) {
                            array_push($days, 7);
                        }

                        $reference = [
                            "start_time" => trim(str_replace(':', '', $startTime)),
                            "end_time" => trim(str_replace(':', '', $request->end_time[$key])),
                            'start_date' => $request->start_date[$key],
                            'end_date' => $request->end_date[$key],
                            'loop_once' => isset($request->$loop_once_reference) ? true : false,
                            'days' => $days
                        ];
                        array_push($schedule, $reference);
                    }
                    $referenceCounter++;
                }
            }
        }

        if (empty($request->remote_buffer) || $request->remote_buffer < 0) {
            $request->merge(['remote_buffer' => 0]);
        }

        if (empty($request->play_per_songs) || $request->play_per_songs < 0) {
            $request->merge(['play_per_songs' => 0]);
        }

        if (empty($request->play_per_minutes) || $request->play_per_minutes < 0) {
            $request->merge(['play_per_minutes' => 0]);
        }

        if (empty($request->play_per_hour_minute) || $request->play_per_hour_minute < 0) {
            $request->merge(['play_per_hour_minute' => 0]);
        }

        if (empty($request->weight) || $request->weight < 1 || $request->weight > 25) {
            $request->merge(['weight' => 1]);
        }

        $backend_options = [];
        if (isset($request->interrupt) && $request->interrupt == "on") {
            array_push($backend_options, "interrupt");
        }
        if (isset($request->single_track) && $request->single_track == "on") {
            array_push($backend_options, "single_track");
        }
        if (isset($request->merge) && $request->merge == "on") {
            array_push($backend_options, "merge");
        }

        $data = [
            "id" => $request->playlist_id,
            "name" => $request->name,
            "is_enabled" => isset($request->enable) && $request->enable == "on" ? true : false,
            'type' => $request->source == "remote_url" ? "default" : $request->playlist_type,
            "source" => $request->source,
            "order" => $request->order,
            "remote_url" => $request->remote_url,
            "remote_type" => $request->remote_type,
            "remote_buffer" => $request->remote_buffer,
            "is_jingle" => isset($request->is_jingle) && $request->is_jingle == "on" ? true : false,
            "play_per_songs" => $request->play_per_songs,
            "play_per_minutes" => $request->play_per_minutes,
            "play_per_hour_minute" => $request->play_per_hour_minute,
            "weight" => $request->weight,
            "include_in_requests" => isset($request->allow_requests) && $request->allow_requests == "on" ? true : false,
            "include_in_on_demand" => isset($request->on_demand) && $request->on_demand == "on" ? true : false,
            "backend_options" => $backend_options,
            "avoid_duplicates" => isset($request->avoid_duplicate) && $request->avoid_duplicate == "on" ? true : false,
            "schedule_items" => $schedule
        ];

        $json_data = json_encode($data);
        $url = "https://azuracast.casthost.net/api/station/27/playlist/" . $request->playlist_id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);


        return redirect('/playlists');
    }

    public function EditPlaylistSchedule($id)
    {
        $url = "https://azuracast.casthost.net/api/station/27/playlist/" . $id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $playlist = json_decode(curl_exec($ch));
        $scheduleCount = count($playlist->schedule_items);
        if ($scheduleCount > 0) {
            $scheduleCountFinalId = $playlist->schedule_items[$scheduleCount - 1]->id;
        } else {
            $scheduleCountFinalId = 0;
        }

        return view('editSchedule', compact('playlist', 'scheduleCount', 'scheduleCountFinalId'));
    }

    public function UpdatePlaylistSchedule(Request $request)
    {
        $schedule = [];
        $referenceCounter = 0;
        if (isset($request->start_time)) {
            foreach ($request->start_time as $key => $startTime) {
                $reference = [];
                if (isset($request->id[$key])) {
                    $loop_once_reference = "loop_once" . $request->id[$key];
                    $days = [];

                    $forMonday = "monday" . $request->id[$key];
                    if (isset($request->$forMonday)) {
                        array_push($days, 1);
                    }
                    $forTuesday = "tuesday" . $request->id[$key];
                    if (isset($request->$forTuesday)) {
                        array_push($days, 2);
                    }
                    $forWednesday = "wednesday" . $request->id[$key];
                    if (isset($request->$forWednesday)) {
                        array_push($days, 3);
                    }
                    $forThursday = "thursday" . $request->id[$key];
                    if (isset($request->$forThursday)) {
                        array_push($days, 4);
                    }
                    $forFriday = "friday" . $request->id[$key];
                    if (isset($request->$forFriday)) {
                        array_push($days, 5);
                    }
                    $forSaturday = "saturday" . $request->id[$key];
                    if (isset($request->$forSaturday)) {
                        array_push($days, 6);
                    }
                    $forSunday = "sunday" . $request->id[$key];
                    if (isset($request->$forSunday)) {
                        array_push($days, 7);
                    }

                    $reference = [
                        "id" => $request->id[$key],
                        "start_time" => trim(str_replace(':', '', $startTime)),
                        "end_time" => trim(str_replace(':', '', $request->end_time[$key])),
                        'start_date' => $request->start_date[$key],
                        'end_date' => $request->end_date[$key],
                        'loop_once' => isset($request->$loop_once_reference) ? true : false,
                        'days' => $days
                    ];
                    array_push($schedule, $reference);
                } else {
                    if (isset($request->reference[$referenceCounter])) {
                        $loop_once_reference = "loop_once" . $request->reference[$referenceCounter];
                        $days = [];

                        $forMonday = "monday" . $request->reference[$referenceCounter];
                        if (isset($request->$forMonday)) {
                            array_push($days, 1);
                        }
                        $forTuesday = "tuesday" . $request->reference[$referenceCounter];
                        if (isset($request->$forTuesday)) {
                            array_push($days, 2);
                        }
                        $forWednesday = "wednesday" . $request->reference[$referenceCounter];
                        if (isset($request->$forWednesday)) {
                            array_push($days, 3);
                        }
                        $forThursday = "thursday" . $request->reference[$referenceCounter];
                        if (isset($request->$forThursday)) {
                            array_push($days, 4);
                        }
                        $forFriday = "friday" . $request->reference[$referenceCounter];
                        if (isset($request->$forFriday)) {
                            array_push($days, 5);
                        }
                        $forSaturday = "saturday" . $request->reference[$referenceCounter];
                        if (isset($request->$forSaturday)) {
                            array_push($days, 6);
                        }
                        $forSunday = "sunday" . $request->reference[$referenceCounter];
                        if (isset($request->$forSunday)) {
                            array_push($days, 7);
                        }

                        $reference = [
                            "start_time" => trim(str_replace(':', '', $startTime)),
                            "end_time" => trim(str_replace(':', '', $request->end_time[$key])),
                            'start_date' => $request->start_date[$key],
                            'end_date' => $request->end_date[$key],
                            'loop_once' => isset($request->$loop_once_reference) ? true : false,
                            'days' => $days
                        ];
                        array_push($schedule, $reference);
                    }
                    $referenceCounter++;
                }
            }
        }

        $data = [
            "id" => $request->playlist_id,
            "schedule_items" => $schedule
        ];

        $json_data = json_encode($data);
        $url = "https://azuracast.casthost.net/api/station/27/playlist/" . $request->playlist_id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return redirect('/playlists');
    }


    public function DeletePlaylist($id)
    {
        $url = "https://azuracast.casthost.net/api/station/27/playlist/" . $id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $response = json_decode(curl_exec($ch));
        return redirect('/playlists');
    }

    public function NowPlaying()
    {
        $api = Client::create(
            'https://azuracast.casthost.net',
            'af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1'
        );
        $nowPlaying = $api->stations();

        print_r($nowPlaying);
        die;
    }
}
