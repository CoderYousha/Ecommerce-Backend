<?php

namespace App\Services;

use App\Transformers\Notifications\ClientNotificationsResponse;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public function getNotifications($perPage)
    {
        $user = Auth::guard('user')->user();
        $notifications = $user->notifications()->paginate($perPage ?? 10);

        return success(ClientNotificationsResponse::format($notifications), 'Notifications inormation');
    }

    public function saveToken($request)
    {
        $user = Auth::guard('user')->user();
        $request->validate(['fcm_token' => 'required|string']);

        $user->update(['fcm_token' => $request->fcm_token], []);

        return response()->json(['message' => 'FCM Token saved successfully']);
    }

    private function createJwt($credentials)
    {
        $header = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $now = time();
        $payload = base64_encode(json_encode(['iss' => $credentials['client_email'], 'scope' => 'https://www.googleapis.com/auth/firebase.messaging', 'aud' => $credentials['token_uri'], 'iat' => $now, 'exp' => $now + 3600]));
        openssl_sign("$header.$payload", $signature, $credentials['private_key'], 'sha256');
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    private function getAccessToken($jwt)
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', ['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $jwt]);

        return $response->json()['access_token'];
    }

    public function sendNotification($token, $title, $body, $image, $link)
    {
        $message = ['message' => ['token' => $token, 'notification' => ['title' => $title, 'body' => $body, 'image' => $image], 'data' => ['link' => $link]]];
        $credentials = json_decode(file_get_contents(storage_path('app/firebase/service-account.json')), true);
        $jwt = $this->createJwt($credentials);
        $accessToken = $this->getAccessToken($jwt);
        $response = Http::withToken($accessToken)->post("https://fcm.googleapis.com/v1/projects/{$credentials['project_id']}/messages:send", $message);

        return $response->json();
    }
}
