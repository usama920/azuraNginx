<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings;
use App\Models\Token;
use App\Models\User;
use AzuraCast\Api\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


use function Laravel\Prompts\password;

class ApiController extends Controller
{
    public function CreateRadioHost(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'name' => 'required',
                'order_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            Token::where(['id' => 1])->update([
                'test' => $th->getMessage()
            ]);
            return response()->json(['status' => 'error', 'message' => $request->post()]);
        }

        $order_exists = User::where(['order_id' => $request->order_id])->first();
        if ($order_exists) {
            $this->UnsuspendRadioHost($request);
        }

        $password = Str::random(11);
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->email;
        $user->email = $request->email;
        $user->order_id = $request->order_id;
        $user->password = Hash::make($password);
        $user->save();

        $stationName = $request->name;

        $data = [
            "name" => "AzuraTest Radio",
            "short_name" => "azuratest_radioo",
            "is_enabled" => true,
            "frontend_type" => "icecast",
            "frontend_config" => [
                "string"
            ],
            "backend_type" => "liquidsoap",
            "backend_config" => [
                "string"
            ],
            "description" => "A sample radio station.",
            "url" => "https://azuracast.casthost.net/",
            "genre" => "Various",
            "radio_base_dir" => "/var/azuracast/stations/azuratest_radioo",
            "enable_requests" => true,
            "request_delay" => 5,
            "request_threshold" => 15,
            "disconnect_deactivate_streamer" => 0,
            "enable_streamers" => false,
            "is_streamer_live" => false,
            "enable_public_page" => true,
            "enable_on_demand" => true,
            "enable_on_demand_download" => true,
            "enable_hls" => true,
            "api_history_items" => 5,
            "timezone" => "UTC",
            "branding_config" => [
                "string"
            ]
        ];

        $url = "https://azuracast.casthost.net/api/admin/stations";

        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));

        foreach ($response as $station) {
            if ($station->name == $request->name) {
                $stationName .= Str::random(4);
            }
        }

        foreach ($response as $station) {
            if ($station->name == $request->name) {
                $stationName .= Str::random(4);
            }
        }

        $json_data = json_encode($data);
        $url = "https://azuracast.casthost.net/api/admin/stations";
        $ch = curl_init();
        $authorization = "Authorization: Bearer af4571e92bf86f25:a674a91ef59dfdd699d98eae1f658af1";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        print_r($response);
        curl_close($ch);

        $basic_settings = BasicSettings::first();
        $data = ['logo' => $basic_settings->site_logo, 'site_name' => $basic_settings->site_title, 'name' => $request->name, 'user_email' => $request->email, 'password' => $password, 'site_title' => $basic_settings->site_title];
        $user['site_title'] = $basic_settings->site_title;
        $user['to'] = $request->email;
        $mail_username = env('MAIL_USERNAME');

        try {
            Mail::send('mails.add_user', $data, function ($message) use ($user, $mail_username) {
                $message->from($mail_username, $user['site_title']);
                $message->sender($mail_username, $user['site_title']);
                $message->to($user['to']);
                $message->subject('Radio Host Registration');
                $message->priority(3);
            });
        } catch (Exception $e) {
            Token::where(['id' => 1])->update([
                'test' => $e->getMessage()
            ]);
        }
    }

    public function SuspendRadioApp(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Please provide all fields."]);
        }

        try {
            $client = new Client();
            $client
                ->setEndpoint('https://appadmin.casthost.net/v1')
                ->setProject('64d7d6158c3fc789f63b')
                ->setKey('d791eced90c356acc6604c8e6d0e1ab3705cf5695e92709a36bcc33e2eb13b2e69ff1279d2a4fd06c6633b0446ec1a56454820a55410c94c880add90d0879e4598faf8e299dea44c600c168da65ee492383213a558a0c3650311789fe0d753cd79c31ab052a96edfe276c33da92277d9c8e992c4aaf71caf8d73733c627990f2');
            $databases = new Databases($client);
            $q = new Query();

            $result = $databases->listDocuments(
                '64d7d639a50f2c715b30',
                '64f6a639ee167ad11670',
                [
                    $q->equal('orderId', intval($request->order_id))
                ],
            );

            if ($result['total'] > 0) {
                $document_id = $result['documents'][0]['$id'];
                $result = $databases->updateDocument(
                    '64d7d639a50f2c715b30',
                    '64f6a639ee167ad11670',
                    $document_id,
                    [
                        'suspend' => 1
                    ]
                );
            }
            return response()->json(['status' => 'success', 'message' => 'App successfully suspended.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function UnsuspendRadioHost(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Please provide all fields."]);
        }

        try {
            $client = new Client();
            $client
                ->setEndpoint('https://appadmin.casthost.net/v1')
                ->setProject('64d7d6158c3fc789f63b')
                ->setKey('d791eced90c356acc6604c8e6d0e1ab3705cf5695e92709a36bcc33e2eb13b2e69ff1279d2a4fd06c6633b0446ec1a56454820a55410c94c880add90d0879e4598faf8e299dea44c600c168da65ee492383213a558a0c3650311789fe0d753cd79c31ab052a96edfe276c33da92277d9c8e992c4aaf71caf8d73733c627990f2');
            $databases = new Databases($client);
            $q = new Query();

            $result = $databases->listDocuments(
                '64d7d639a50f2c715b30',
                '64f6a639ee167ad11670',
                [
                    $q->equal('orderId', intval($request->order_id))
                ],
            );

            if ($result['total'] > 0) {
                $document_id = $result['documents'][0]['$id'];
                $result = $databases->updateDocument(
                    '64d7d639a50f2c715b30',
                    '64f6a639ee167ad11670',
                    $document_id,
                    [
                        'suspend' => 0
                    ]
                );
            }
            return response()->json(['status' => 'success', 'message' => 'App successfully unsuspended.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function DeleteRadioApp(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => "Please provide all fields."]);
        }

        try {
            $client = new Client();
            $client
                ->setEndpoint('https://appadmin.casthost.net/v1')
                ->setProject('64d7d6158c3fc789f63b')
                ->setKey('d791eced90c356acc6604c8e6d0e1ab3705cf5695e92709a36bcc33e2eb13b2e69ff1279d2a4fd06c6633b0446ec1a56454820a55410c94c880add90d0879e4598faf8e299dea44c600c168da65ee492383213a558a0c3650311789fe0d753cd79c31ab052a96edfe276c33da92277d9c8e992c4aaf71caf8d73733c627990f2');
            $databases = new Databases($client);
            $q = new Query();

            $result = $databases->listDocuments(
                '64d7d639a50f2c715b30',
                '64f6a639ee167ad11670',
                [
                    $q->equal('orderId', intval($request->order_id))
                ],
            );

            if ($result['total'] > 0) {
                $document_id = $result['documents'][0]['$id'];
                $result = $databases->deleteDocument(
                    '64d7d639a50f2c715b30',
                    '64f6a639ee167ad11670',
                    $document_id
                );
            }
            return response()->json(['status' => 'success', 'message' => 'App successfully deleted.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
