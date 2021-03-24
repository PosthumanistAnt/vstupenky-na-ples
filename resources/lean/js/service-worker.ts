/**
 * @type {ServiceWorkerGlobalScope}
 */
const sw: any = self;

const offline: string = `You're currently offline. Please check your internet connection and <a href="javascript:window.location.reload()">refresh the page</a>.`;

sw.addEventListener('install', (_: any) => {
    console.debug('[ServiceWorker] Install');

    sw.skipWaiting();
});

sw.addEventListener('activate', (_: any) => {
    console.debug('[ServiceWorker] Activate');

    sw.clients.claim();
});

sw.addEventListener('fetch', (event: any) => {
    console.debug('[ServiceWorker] Fetch');
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(async () => {
                return new Response(offline, {
                    headers: { 'Content-Type': 'text/html' }
                });
            })
        );
    }
});
