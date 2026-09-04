/**
 * NovaDrop Atelier Service Worker - Ultra-Resilient Navigation Cache & Fast-Path PWA Engine
 */
const CACHE_NAME = 'novadrop-v3';
const STATIC_ASSET_EXTS = /\.(css|js|woff|woff2|ttf|otf|png|jpg|jpeg|svg|webp|ico|gif)(\?.*)?$/i;

self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k))
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  // 1. Never intercept or interfere with non-GET (POST, PUT, DELETE) requests (e.g. checkout, Buy Now API)
  if (event.request.method !== 'GET') {
    return;
  }

  // 2. Never intercept or block page navigation requests to prevent ERR_FAILED
  if (event.request.mode === 'navigate') {
    return;
  }

  // 3. Cache-first with network fallback for static assets (fonts, styles, icons, images)
  const url = event.request.url;
  if (STATIC_ASSET_EXTS.test(url) || url.includes('fonts.googleapis.com') || url.includes('fonts.gstatic.com')) {
    event.respondWith(
      caches.match(event.request).then((cached) => {
        if (cached) {
          // Stale-while-revalidate in background
          fetch(event.request).then((networkRes) => {
            if (networkRes && networkRes.status === 200) {
              caches.open(CACHE_NAME).then((cache) => cache.put(event.request, networkRes));
            }
          }).catch(() => {});
          return cached;
        }
        return fetch(event.request).then((networkRes) => {
          if (networkRes && networkRes.status === 200) {
            const copy = networkRes.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy));
          }
          return networkRes;
        }).catch(() => caches.match(event.request));
      })
    );
    return;
  }

  // Default network-first for remaining GET requests
  event.respondWith(
    fetch(event.request).catch(() => {
      return caches.match(event.request);
    })
  );
});
