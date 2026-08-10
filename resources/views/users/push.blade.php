@extends('layouts.main')
@section('body')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center">
        <h2 class="mb-4">Управление уведомлениями</h2>
        
        <button id="push-toggle-btn" class="btn btn-outline-primary btn-lg px-5 py-3" disabled>
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span class="btn-text">Загрузка...</span>
        </button>
        
        <p id="status-message" class="mt-3 text-muted"></p>
    </div>
</div>

<meta name="vapid-public-key" content="{{ env('VAPID_PUBLIC_KEY') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('push-toggle-btn');
    const btnText = btn.querySelector('.btn-text');
    const spinner = btn.querySelector('.spinner-border');
    const statusMsg = document.getElementById('status-message');
    
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        btnText.textContent = 'Браузер не поддерживает уведомления';
        btn.disabled = true;
        return;
    }

    fetch('/push/status', {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        updateButtonState(data.subscribed);
    });

    btn.addEventListener('click', async () => {
        setLoading(true);
        
        const registration = await navigator.serviceWorker.register('/sw.js');
        const subscription = await registration.pushManager.getSubscription();
        const isCurrentlySubscribed = !!subscription;

        if (isCurrentlySubscribed) {
            await subscription.unsubscribe();
            
            await fetch('/push/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ endpoint: subscription.endpoint })
            });
            
            updateButtonState(false);
            statusMsg.textContent = 'Вы успешно отписались от уведомлений.';
        } else {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                alert('Разрешение на уведомления не получено');
                setLoading(false);
                return;
            }

            const newSubscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    document.querySelector('meta[name="vapid-public-key"]').content
                ),
            });

            const { endpoint, keys: { p256dh, auth } } = newSubscription.toJSON();
            const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];

            await fetch('/push/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    endpoint,
                    key: p256dh,
                    token: auth,
                    encoding: contentEncoding
                })
            });

            updateButtonState(true);
            statusMsg.textContent = 'Вы успешно подписались на уведомления!';
        }
        setLoading(false);
    });

    function updateButtonState(isSubscribed) {
        if (isSubscribed) {
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-danger');
            btnText.textContent = 'Отписаться от уведомлений';
        } else {
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-outline-primary');
            btnText.textContent = 'Подписаться на уведомления';
        }
        btn.disabled = false;
    }

    function setLoading(isLoading) {
        btn.disabled = isLoading;
        spinner.classList.toggle('d-none', !isLoading);
        if(isLoading) btnText.textContent = 'Обработка...';
        else updateButtonState(btn.classList.contains('btn-danger'));
    }

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = atob(base64);
        return Uint8Array.from([...rawData].map((c) => c.charCodeAt(0)));
    }
});
</script>
@endsection