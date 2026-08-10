<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TestPushMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PushController extends Controller
{
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();
        $isSubscribed = $user->pushSubscriptions()->count() > 0;

        return response()->json(['subscribed' => $isSubscribed]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->json()->all();
        
        if ($user->pushSubscriptions()->count() > 0) {
            foreach ($user->pushSubscriptions as $subscription) {
                $user->deletePushSubscription($subscription->endpoint);
            }
            return response()->json(['subscribed' => false, 'message' => 'Вы отписались от уведомлений']);
        } 
        
        if (isset($data['endpoint'])) {
            $user->updatePushSubscription(
                $data['endpoint'],
                $data['key'] ?? null,
                $data['token'] ?? null,
                $data['encoding'] ?? 'aes128gcm'
            );
            return response()->json(['subscribed' => true, 'message' => 'Вы подписались на уведомления']);
        }

        return response()->json(['error' => 'Нет данных подписки'], 422);
    }

    public function send(): Response
    {
        $users = User::whereHas('pushSubscriptions')->get();

        if ($users->isEmpty()) {
            return response('Никто не подписан');
        }

        foreach ($users as $user) {
            $user->notify(new TestPushMessage());
        }
     
        return response('Уведомления всем подписавшимся отправлены!');
    }
}
