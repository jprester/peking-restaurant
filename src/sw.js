/**
 * Service Worker for Peking Restaurant
 * Provides basic PWA functionality and caching
 */

const CACHE_NAME = 'peking-restaurant-v1';
const STATIC_CACHE_NAME = 'peking-static-v1';

// Files to cache immediately
const STATIC_ASSETS = [
  '/',
  '/css/modern.css',
  '/js/modern/app.js',
  '/js/peking-modern.js',
  '/img/logo.png',
  '/img/slide1.jpg',
  '/img/slide2.jpg',
  '/img/slide3.jpg',
  '/offline.html',
];

// Runtime cache patterns
const RUNTIME_CACHE = {
  images: {
    pattern: /\.(?:png|jpg|jpeg|svg|gif|webp|avif)$/,
    strategy: 'CacheFirst',
    maxEntries: 50,
    maxAgeSeconds: 30 * 24 * 60 * 60, // 30 days
  },
  styles: {
    pattern: /\.css$/,
    strategy: 'StaleWhileRevalidate',
    maxEntries: 10,
    maxAgeSeconds: 7 * 24 * 60 * 60, // 7 days
  },
  scripts: {
    pattern: /\.js$/,
    strategy: 'StaleWhileRevalidate',
    maxEntries: 10,
    maxAgeSeconds: 7 * 24 * 60 * 60, // 7 days
  },
  pages: {
    pattern: /\.(?:html|php)$/,
    strategy: 'NetworkFirst',
    maxEntries: 20,
    maxAgeSeconds: 24 * 60 * 60, // 1 day
  },
};

// Install event - cache static assets
self.addEventListener('install', (event) => {
  console.log('Service Worker installing...');

  event.waitUntil(
    caches
      .open(STATIC_CACHE_NAME)
      .then((cache) => {
        console.log('Caching static assets...');
        return cache.addAll(STATIC_ASSETS);
      })
      .then(() => {
        console.log('Static assets cached successfully');
        return self.skipWaiting();
      })
      .catch((error) => {
        console.error('Failed to cache static assets:', error);
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
  console.log('Service Worker activating...');

  event.waitUntil(
    caches
      .keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheName !== CACHE_NAME && cacheName !== STATIC_CACHE_NAME) {
              console.log('Deleting old cache:', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => {
        console.log('Old caches cleaned up');
        return self.clients.claim();
      })
  );
});

// Fetch event - serve from cache or network
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip non-HTTP requests
  if (!url.protocol.startsWith('http')) {
    return;
  }

  // Skip admin pages from caching
  if (url.pathname.includes('/admin/')) {
    return;
  }

  event.respondWith(handleRequest(request));
});

// Handle different types of requests
async function handleRequest(request) {
  const url = new URL(request.url);
  const pathname = url.pathname;

  try {
    // Check if it's a navigation request (page)
    if (request.mode === 'navigate') {
      return await handlePageRequest(request);
    }

    // Handle static assets
    if (isStaticAsset(pathname)) {
      return await handleStaticAsset(request);
    }

    // Handle runtime cached resources
    const cacheStrategy = getRuntimeCacheStrategy(pathname);
    if (cacheStrategy) {
      return await applyCacheStrategy(request, cacheStrategy);
    }

    // Default: try network first
    return await fetch(request);
  } catch (error) {
    console.error('Request failed:', error);
    return await handleFallback(request);
  }
}

// Handle page requests with network-first strategy
async function handlePageRequest(request) {
  try {
    // Try network first
    const networkResponse = await fetch(request);

    // Cache successful responses
    if (networkResponse.ok) {
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, networkResponse.clone());
    }

    return networkResponse;
  } catch (error) {
    // Network failed, try cache
    const cachedResponse = await caches.match(request);

    if (cachedResponse) {
      return cachedResponse;
    }

    // Show offline page
    return (
      (await caches.match('/offline.html')) ||
      new Response('Offline - Please check your connection', {
        status: 503,
        statusText: 'Service Unavailable',
      })
    );
  }
}

// Handle static assets with cache-first strategy
async function handleStaticAsset(request) {
  const cachedResponse = await caches.match(request);

  if (cachedResponse) {
    return cachedResponse;
  }

  try {
    const networkResponse = await fetch(request);

    if (networkResponse.ok) {
      const cache = await caches.open(STATIC_CACHE_NAME);
      cache.put(request, networkResponse.clone());
    }

    return networkResponse;
  } catch (error) {
    console.error('Failed to fetch static asset:', error);
    throw error;
  }
}

// Apply cache strategy based on resource type
async function applyCacheStrategy(request, strategy) {
  const cache = await caches.open(CACHE_NAME);

  switch (strategy.strategy) {
    case 'CacheFirst':
      return await cacheFirst(request, cache);

    case 'NetworkFirst':
      return await networkFirst(request, cache);

    case 'StaleWhileRevalidate':
      return await staleWhileRevalidate(request, cache);

    default:
      return await fetch(request);
  }
}

// Cache-first strategy
async function cacheFirst(request, cache) {
  const cachedResponse = await cache.match(request);

  if (cachedResponse) {
    return cachedResponse;
  }

  const networkResponse = await fetch(request);

  if (networkResponse.ok) {
    cache.put(request, networkResponse.clone());
  }

  return networkResponse;
}

// Network-first strategy
async function networkFirst(request, cache) {
  try {
    const networkResponse = await fetch(request);

    if (networkResponse.ok) {
      cache.put(request, networkResponse.clone());
    }

    return networkResponse;
  } catch (error) {
    const cachedResponse = await cache.match(request);

    if (cachedResponse) {
      return cachedResponse;
    }

    throw error;
  }
}

// Stale-while-revalidate strategy
async function staleWhileRevalidate(request, cache) {
  const cachedResponse = cache.match(request);

  const fetchPromise = fetch(request)
    .then((networkResponse) => {
      if (networkResponse.ok) {
        cache.put(request, networkResponse.clone());
      }
      return networkResponse;
    })
    .catch(() => {
      // Silent fail for background fetch
    });

  return (await cachedResponse) || fetchPromise;
}

// Handle fallback responses
async function handleFallback(request) {
  const url = new URL(request.url);

  // For navigation requests, show offline page
  if (request.mode === 'navigate') {
    return (
      (await caches.match('/offline.html')) ||
      new Response('Offline', { status: 503 })
    );
  }

  // For images, show placeholder
  if (request.destination === 'image') {
    return new Response('', {
      status: 200,
      headers: { 'Content-Type': 'image/svg+xml' },
    });
  }

  // Default fallback
  return new Response('Resource not available offline', {
    status: 503,
    statusText: 'Service Unavailable',
  });
}

// Utility functions
function isStaticAsset(pathname) {
  return STATIC_ASSETS.some(
    (asset) => pathname === asset || pathname.endsWith(asset)
  );
}

function getRuntimeCacheStrategy(pathname) {
  for (const [name, config] of Object.entries(RUNTIME_CACHE)) {
    if (config.pattern.test(pathname)) {
      return config;
    }
  }
  return null;
}

// Background sync for offline actions
self.addEventListener('sync', (event) => {
  if (event.tag === 'contact-form') {
    event.waitUntil(syncContactForm());
  }
});

// Sync contact form submissions
async function syncContactForm() {
  try {
    // Get pending form submissions from IndexedDB
    // This would be implemented with the actual form handling
    console.log('Syncing contact form submissions...');
  } catch (error) {
    console.error('Failed to sync contact form:', error);
  }
}

// Push notification handling
self.addEventListener('push', (event) => {
  if (!event.data) return;

  const data = event.data.json();

  const options = {
    body: data.body,
    icon: '/img/icon-192.png',
    badge: '/img/badge.png',
    actions: [
      {
        action: 'view',
        title: 'Pogledaj',
        icon: '/img/view-icon.png',
      },
      {
        action: 'dismiss',
        title: 'Odbaci',
        icon: '/img/dismiss-icon.png',
      },
    ],
    data: data.url,
  };

  event.waitUntil(self.registration.showNotification(data.title, options));
});

// Handle notification clicks
self.addEventListener('notificationclick', (event) => {
  event.notification.close();

  if (event.action === 'view') {
    event.waitUntil(clients.openWindow(event.notification.data));
  }
});

console.log('Service Worker loaded successfully');
