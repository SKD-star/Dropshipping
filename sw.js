/**
 * Lumina Atelier Service Worker - Ultra-Resilient Navigation Cache
 */
const CACHE_NAME = 'lumina-v2';

self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.map((k) => caches.delete(k))
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  // Never intercept or block page navigation requests to prevent ERR_FAILED
  if (event.request.mode === 'navigate') {
    return;
  }
  
  event.respondWith(
    fetch(event.request).catch(() => {
      return caches.match(event.request);
    })
  );
});
