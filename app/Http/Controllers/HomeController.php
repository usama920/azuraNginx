<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AzuraCast\Api\Client;


class HomeController extends Controller
{
    public function Dashboard()
    {
        $station_id = 27;
        $url = "https://azuracast.casthost.net/api/nowplaying/" . $station_id;
        $stream_url = "https://azuracast.casthost.net/api/station/" . $station_id . "/stereo-tool-configuration";
        $schedule_url = "https://azuracast.casthost.net/api/station/" . $station_id . "/schedule";
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $schedule_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $schedule_response = json_decode(curl_exec($ch));
        curl_close($ch);

        // $ch = curl_init();
        // $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        // curl_setopt($ch, CURLOPT_URL, $stream_url);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $stream_response = json_decode(curl_exec($ch));
        // curl_close($ch);

        // prx($stream_response);
        return view('dashboard', compact('response', 'schedule_response'));
    }

    public function EditProfile()
    {
        // $api = Client::create(
        //     'https://azuracast.casthost.net',
        //     'af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1'
        // );
        // $station = $api->station(27)->get();
        // prx($station);

        $station_id = 27;
        $url = "https://azuracast.casthost.net/api/station/" . $station_id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        // prx($response);
        return view('editProfile', compact('response'));
    }


    public function NowPlaying()
    {
        $station_id = 27;
        $url = "https://azuracast.casthost.net/api/nowplaying/" . $station_id;
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        prx($response);


        // $api = Client::create(
        //     'https://azuracast.casthost.net',
        //     'af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1'
        // );
        // $nowPlaying = $api->station(27)->nowPlaying();
        // $ev = collect($nowPlaying)->toArray();
        // $nowPlaying->getProperty()
        // return [
        //     'id' => $nowPlaying->get('customer')
        // ];
    }
}
