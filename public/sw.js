self.addEventListener('push', function (event) {
    const data = event.data ? event.data.json() : {};
    
    const options = {
        body: data.body || 'Новое уведомление',
        icon: data.icon || '/images/logo.png',
        badge: '/images/badge.png',
        data: data.url || '/'
    };

    event.waitUntil(
        self.registration.showNotification(data.title || 'Заголовок', options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data)
    );
});