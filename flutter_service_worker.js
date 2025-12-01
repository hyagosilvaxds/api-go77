'use strict';
const MANIFEST = 'flutter-app-manifest';
const TEMP = 'flutter-temp-cache';
const CACHE_NAME = 'flutter-app-cache';

const RESOURCES = {"flutter_bootstrap.js": "7c563deb88a064674edda71a6d0e247f",
"version.json": "ada9eb1899459fa0507c4a7f7bcabe78",
"favicon.ico": "68698bec0dd958d12a20d7bd62732813",
"index.html": "74afbd423f61c35fec670f327af450d4",
"/": "74afbd423f61c35fec670f327af450d4",
"main.dart.js": "8511681adc612234f297420234b8e816",
"flutter.js": "83d881c1dbb6d6bcd6b42e274605b69c",
"favicon.png": "5dcef449791fa27946b3d35ad8803796",
"icons/favicon-16x16.png": "bd713dbed471e9f07553f8cf236f9004",
"icons/favicon.ico": "68698bec0dd958d12a20d7bd62732813",
"icons/apple-icon.png": "06da1e8a9e3238b9712e0f844ce6b8ab",
"icons/apple-icon-144x144.png": "e852aeb86cae043d4e452e803893ba75",
"icons/android-icon-192x192.png": "bb68e0bb143ba86df8d1f9fc5291dd07",
"icons/apple-icon-precomposed.png": "06da1e8a9e3238b9712e0f844ce6b8ab",
"icons/apple-icon-114x114.png": "dec6a553a1c2c65462a281cd5448d833",
"icons/ms-icon-310x310.png": "037959b0c8172c0949bf21df6593d597",
"icons/Icon-192.png": "ac9a721a12bbc803b44f645561ecb1e1",
"icons/Icon-maskable-192.png": "c457ef57daa1d16f64b27b786ec2ea3c",
"icons/ms-icon-144x144.png": "e852aeb86cae043d4e452e803893ba75",
"icons/apple-icon-57x57.png": "206a61f1ed9198963c42dacc85f3f638",
"icons/apple-icon-152x152.png": "687a66d51f1f1279c2dcaa22c5282c13",
"icons/ms-icon-150x150.png": "b1789e0be52155c921577fa04ec6a735",
"icons/android-icon-72x72.png": "07d6cb6b830208c624d3f747d673796a",
"icons/android-icon-96x96.png": "11fc8afe6771273c854e9465e6b3d9ee",
"icons/android-icon-36x36.png": "410ffa1acf09a137f3a0e94048f68b29",
"icons/apple-icon-180x180.png": "07ab4277c372cd7ac93f5bfba14f6212",
"icons/favicon-96x96.png": "935d422e6d7dfb999bbf550b9f5f5875",
"icons/manifest.json": "b58fcfa7628c9205cb11a1b2c3e8f99a",
"icons/android-icon-48x48.png": "4ed17e6cc3b7c35bdaf1655b0432159b",
"icons/apple-icon-76x76.png": "876a716f1e4f0daa41310da9b566d3b6",
"icons/apple-icon-60x60.png": "50775bc89d664fac37c2998271fe2c4c",
"icons/Icon-maskable-512.png": "301a7604d45b3e739efc881eb04896ea",
"icons/browserconfig.xml": "653d077300a12f09a69caeea7a8947f8",
"icons/android-icon-144x144.png": "3bcc41a4111cdc3baea14569c20a38db",
"icons/apple-icon-72x72.png": "07d6cb6b830208c624d3f747d673796a",
"icons/apple-icon-120x120.png": "5c46f5d70c4a3c35bd170dcedbd799bb",
"icons/Icon-512.png": "96e752610906ba2a93c65f8abe1645f1",
"icons/favicon-32x32.png": "19fd883e0238ea5d638e19eddacde4b5",
"icons/ms-icon-70x70.png": "57cd47d3b8a895915cb6e497fdf38abe",
"manifest.json": "ce2d8698485fa309624c83688bb60f58",
"assets/images/logo03.png": "eb14eb20d842dbd293604995eafe5562",
"assets/images/discover.png": "62ea19837dd4902e0ae26249afe36f94",
"assets/images/rupay.png": "a10fbeeae8d386ee3623e6160133b8a8",
"assets/images/pin.png": "23284d0eb076c97c43e03be5a8d4fdb3",
"assets/images/chip.png": "5728d5ac34dbb1feac78ebfded493d69",
"assets/images/location2.png": "a0df437a6b903622b8fa5e1570082b87",
"assets/images/ticket.png": "3e0dff2a9e6d47463394f3bee4285d12",
"assets/images/visa.png": "f6301ad368219611958eff9bb815abfe",
"assets/images/hipercard.png": "921660ec64a89da50a7c82e89d56bac9",
"assets/images/img.png": "44758ced3ddf6c28d3d7baf146f81be1",
"assets/images/elo.png": "ffd639816704b9f20b73815590c67791",
"assets/images/Design_sem_nome__8_-removebg-preview.png": "db2cdb4209ff81c35c67a2c9317ad267",
"assets/images/undraw1.png": "111df80efc290d1319414919b1fcedb4",
"assets/images/location.png": "fea59910f61e811b0bdab6a6a102c9e5",
"assets/images/vazio.png": "0a002f60490ad47cec3a77455e145d10",
"assets/images/Frame.png": "3e0dff2a9e6d47463394f3bee4285d12",
"assets/images/GO77_Logo1.png": "159ce6a45f1475b78379e3a9548154cb",
"assets/images/GO77.png": "544641faab97d53c1faebb9f25b87a3c",
"assets/images/amex.png": "f75cabd609ccde52dfc6eef7b515c547",
"assets/images/GO77_Logo.png": "56d06a731216cb364c50411383f91a66",
"assets/images/mastercard.png": "7e386dc6c169e7164bd6f88bffb733c7",
"assets/images/unionpay.png": "87176915b4abdb3fcc138d23e4c8a58a",
"assets/images/notifica.png": "f418f105f42ee2182efd5e1011a861ba",
"assets/images/Maps.png": "e1a71f7f94b91f9be7317ca2eaca91d5",
"assets/images/bg.png": "d03ec45fe1bed7e84a71e169608aa464",
"assets/images/exemplo1.jpg": "f380028e3833ac7225d46c998d9efb74",
"assets/AssetManifest.json": "a999ea19a128fa8f2d1349788b4f2624",
"assets/NOTICES": "8132448ba958412e7a750fbf0d589bb2",
"assets/FontManifest.json": "9f15bb5f4c65524a814aeb812a3b55cd",
"assets/AssetManifest.bin.json": "c94f28314a28240a0407b801c2393155",
"assets/packages/cupertino_icons/assets/CupertinoIcons.ttf": "33b7d9392238c04c131b6ce224e13711",
"assets/packages/flutter_credit_card/icons/discover.png": "62ea19837dd4902e0ae26249afe36f94",
"assets/packages/flutter_credit_card/icons/rupay.png": "a10fbeeae8d386ee3623e6160133b8a8",
"assets/packages/flutter_credit_card/icons/chip.png": "5728d5ac34dbb1feac78ebfded493d69",
"assets/packages/flutter_credit_card/icons/visa.png": "f6301ad368219611958eff9bb815abfe",
"assets/packages/flutter_credit_card/icons/hipercard.png": "921660ec64a89da50a7c82e89d56bac9",
"assets/packages/flutter_credit_card/icons/elo.png": "ffd639816704b9f20b73815590c67791",
"assets/packages/flutter_credit_card/icons/amex.png": "f75cabd609ccde52dfc6eef7b515c547",
"assets/packages/flutter_credit_card/icons/mastercard.png": "7e386dc6c169e7164bd6f88bffb733c7",
"assets/packages/flutter_credit_card/icons/unionpay.png": "87176915b4abdb3fcc138d23e4c8a58a",
"assets/packages/flutter_credit_card/font/halter.ttf": "4e081134892cd40793ffe67fdc3bed4e",
"assets/packages/flutter_image_compress_web/assets/pica.min.js": "6208ed6419908c4b04382adc8a3053a2",
"assets/packages/fluttertoast/assets/toastify.js": "56e2c9cedd97f10e7e5f1cebd85d53e3",
"assets/packages/fluttertoast/assets/toastify.css": "a85675050054f179444bc5ad70ffc635",
"assets/packages/dash_chat_2/assets/placeholder.png": "ce1fece6c831b69b75c6c25a60b5b0f3",
"assets/packages/dash_chat_2/assets/profile_placeholder.png": "77f5794e2eb49f7989b8f85e92cfa4e0",
"assets/packages/u_credit_card/fonts/OCR-A-regular.ttf": "426fbbd15636b132aafe10f83c816e3f",
"assets/packages/u_credit_card/assets/images/discover.png": "b66abb29035e7fa885cb565c4aedfb30",
"assets/packages/u_credit_card/assets/images/visa_logo.png": "8ce71663ec640331057e5b42cacc1994",
"assets/packages/u_credit_card/assets/images/chip.png": "c7c92244ce8c689f6ac515b9569bb09f",
"assets/packages/u_credit_card/assets/images/nfc.png": "d0e0c4bc69cb7005c10ce684f0603468",
"assets/packages/u_credit_card/assets/images/master_card.png": "fe807bce353d0bc60f09a60409236255",
"assets/packages/u_credit_card/assets/images/amex.png": "78a87e922e4af6db197310737ef9b9fe",
"assets/shaders/ink_sparkle.frag": "ecc85a2e95f5e9f53123dcaf8cb9b6ce",
"assets/AssetManifest.bin": "a2d08f592aa0a8d9f549708dc733d4f2",
"assets/icon/Search.svg": "ba1937162a44e2e7c2252b396995cdd1",
"assets/icon/house.svg": "190e75a8bc1693e50157bccd720e52d6",
"assets/icon/Logout.svg": "dfa262112a4cea3039be30338c3a0b4d",
"assets/icon/ticket.svg": "4fc234fbfcf2b3f32fd93e92d831663d",
"assets/icon/recursapayment.json": "e42e19cc57430470f5870aa4b6e38d3b",
"assets/icon/pix.png": "a8c4237e16d6c0419d9815f83763cc14",
"assets/icon/chatweb.svg": "6122a8b4efade24f401a49a06300e161",
"assets/icon/Group.png": "fff1daf25c0f6b73d32203cec65c0e91",
"assets/icon/Group%2520(2).png": "6e02303802b8748e2f8dffc7215f682a",
"assets/icon/ticketweb.svg": "75884f027564c93ba58141554d66ae21",
"assets/icon/search-status.svg": "267403f7706dcadb584593ceaa831ada",
"assets/icon/qr-code.svg": "d73c2382998bdb403c8e1bf7607bbe69",
"assets/icon/DangerTriangle.svg": "8b18cbf0aab30668d8212258383a3dcd",
"assets/icon/categoryweb.svg": "ce203c22937b5e3814c042e84e6fa4b1",
"assets/icon/pix.svg": "8a81c3f7ab345d95751f41124455d4b7",
"assets/icon/mage_edit.svg": "332b6286baeb562520b0b9d387acb525",
"assets/icon/uploadfull.svg": "6c6d6b748e117dfef6c10fbc6a3cdd13",
"assets/icon/googlemaps.svg": "b247a54413ed6f054609096965e921f8",
"assets/icon/filtter.svg": "ddb6d7a622391351120f584da8bb2672",
"assets/icon/Category.svg": "4816f069ef04a82ecf4bb810c2d00b18",
"assets/icon/plus.svg": "dd7ac9a684db6e7faf7ad48fec70ce72",
"assets/icon/camerafull.svg": "d139e596f9201e6dd10ad14bed9d3321",
"assets/icon/mapgoogle.png": "c9deec6d528849687102260e75bec195",
"assets/icon/mapsdetail.png": "ee8e3478b1518ff7b87767e4666ab3cb",
"assets/icon/Image%25202.svg": "4d32152ae7b449d524624c6291c0663b",
"assets/icon/users.png": "7383fe432ac0ab0d2dc8383a0645dbda",
"assets/icon/userweb.svg": "1a3b54c498b5d7ee47faae01a7e40491",
"assets/icon/anuncio.svg": "966dedbba44ba0dfe2609b4439ef67be",
"assets/icon/whatsapp-linei.svg": "e7e89c099287a4b659372c061a92f5ac",
"assets/icon/chat.svg": "6949b9ca0905cb989f1847d3e5bc3edb",
"assets/icon/notification.svg": "da0dbfc7e443ac6c9e58834315617f74",
"assets/icon/Send.svg": "12c3fdde34dc5676f42abfbf260a0d03",
"assets/icon/facebook.svg": "f70ee8651ac8bc0ff12268c0bb555d11",
"assets/icon/explore.svg": "2afafe292f360237f0789930e5bf8f3a",
"assets/icon/Wi-Fi.svg": "e338e45e628060f9febfb298aefe3b2d",
"assets/icon/MapsAnuncio.png": "529109f98ceea20c8b21e7e728344093",
"assets/icon/google.svg": "1651d8b87f0961b52b759a8169341659",
"assets/icon/confirmpayment.json": "32c949b61701a664ac33c628563c9967",
"assets/icon/perfil.svg": "1c389327b23bf1414ad2247212a7805e",
"assets/icon/Delete.svg": "4d27df92884a15faa16a0ae6ceec4167",
"assets/icon/Group%2520(1).png": "39855b5187718aea84bb459648306a03",
"assets/icon/searchupload.svg": "4ff2c8a3fc95d1eb5ab4d2de57b7cf0a",
"assets/icon/filter.svg": "ddb6d7a622391351120f584da8bb2672",
"assets/icon/loginweb.svg": "20ab340866cdba1ba9049d27e42ead08",
"assets/icon/mapapple.png": "7afad19b0360e7e9ea8f8e8320878a9b",
"assets/icon/applemap.svg": "0968d7c7ba641bc01223063686d8b19f",
"assets/icon/edit-outline.svg": "463fa302dbc7362fa36621902cf14cef",
"assets/icon/beach.svg": "e2d696b2b4f49b1f43bb7a979b33b557",
"assets/icon/loadingpayment.json": "178cc3e523aa0381d49422c01fb15c6b",
"assets/icon/Heart.svg": "af83644da18b8809447c7dd356cb2140",
"assets/fonts/Montserrat-Bold.ttf": "1f023b349af1d79a72740f4cc881a310",
"assets/fonts/Montserrat-Regular.ttf": "3fe868a1a9930b59d94d2c1d79461e3c",
"assets/fonts/MaterialIcons-Regular.otf": "97fb238db8ca2641e5c7bdd0eed3ca21",
"assets/fonts/Montserrat-Italic.ttf": "761177c558bb3a0084aa85704315b990",
"canvaskit/skwasm.js": "ea559890a088fe28b4ddf70e17e60052",
"canvaskit/skwasm.js.symbols": "e72c79950c8a8483d826a7f0560573a1",
"canvaskit/canvaskit.js.symbols": "bdcd3835edf8586b6d6edfce8749fb77",
"canvaskit/skwasm.wasm": "39dd80367a4e71582d234948adc521c0",
"canvaskit/chromium/canvaskit.js.symbols": "b61b5f4673c9698029fa0a746a9ad581",
"canvaskit/chromium/canvaskit.js": "8191e843020c832c9cf8852a4b909d4c",
"canvaskit/chromium/canvaskit.wasm": "f504de372e31c8031018a9ec0a9ef5f0",
"canvaskit/canvaskit.js": "728b2d477d9b8c14593d4f9b82b484f3",
"canvaskit/canvaskit.wasm": "7a3f4ae7d65fc1de6a6e7ddd3224bc93"};
// The application shell files that are downloaded before a service worker can
// start.
const CORE = ["main.dart.js",
"index.html",
"flutter_bootstrap.js",
"assets/AssetManifest.bin.json",
"assets/FontManifest.json"];

// During install, the TEMP cache is populated with the application shell files.
self.addEventListener("install", (event) => {
  self.skipWaiting();
  return event.waitUntil(
    caches.open(TEMP).then((cache) => {
      return cache.addAll(
        CORE.map((value) => new Request(value, {'cache': 'reload'})));
    })
  );
});
// During activate, the cache is populated with the temp files downloaded in
// install. If this service worker is upgrading from one with a saved
// MANIFEST, then use this to retain unchanged resource files.
self.addEventListener("activate", function(event) {
  return event.waitUntil(async function() {
    try {
      var contentCache = await caches.open(CACHE_NAME);
      var tempCache = await caches.open(TEMP);
      var manifestCache = await caches.open(MANIFEST);
      var manifest = await manifestCache.match('manifest');
      // When there is no prior manifest, clear the entire cache.
      if (!manifest) {
        await caches.delete(CACHE_NAME);
        contentCache = await caches.open(CACHE_NAME);
        for (var request of await tempCache.keys()) {
          var response = await tempCache.match(request);
          await contentCache.put(request, response);
        }
        await caches.delete(TEMP);
        // Save the manifest to make future upgrades efficient.
        await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
        // Claim client to enable caching on first launch
        self.clients.claim();
        return;
      }
      var oldManifest = await manifest.json();
      var origin = self.location.origin;
      for (var request of await contentCache.keys()) {
        var key = request.url.substring(origin.length + 1);
        if (key == "") {
          key = "/";
        }
        // If a resource from the old manifest is not in the new cache, or if
        // the MD5 sum has changed, delete it. Otherwise the resource is left
        // in the cache and can be reused by the new service worker.
        if (!RESOURCES[key] || RESOURCES[key] != oldManifest[key]) {
          await contentCache.delete(request);
        }
      }
      // Populate the cache with the app shell TEMP files, potentially overwriting
      // cache files preserved above.
      for (var request of await tempCache.keys()) {
        var response = await tempCache.match(request);
        await contentCache.put(request, response);
      }
      await caches.delete(TEMP);
      // Save the manifest to make future upgrades efficient.
      await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
      // Claim client to enable caching on first launch
      self.clients.claim();
      return;
    } catch (err) {
      // On an unhandled exception the state of the cache cannot be guaranteed.
      console.error('Failed to upgrade service worker: ' + err);
      await caches.delete(CACHE_NAME);
      await caches.delete(TEMP);
      await caches.delete(MANIFEST);
    }
  }());
});
// The fetch handler redirects requests for RESOURCE files to the service
// worker cache.
self.addEventListener("fetch", (event) => {
  if (event.request.method !== 'GET') {
    return;
  }
  var origin = self.location.origin;
  var key = event.request.url.substring(origin.length + 1);
  // Redirect URLs to the index.html
  if (key.indexOf('?v=') != -1) {
    key = key.split('?v=')[0];
  }
  if (event.request.url == origin || event.request.url.startsWith(origin + '/#') || key == '') {
    key = '/';
  }
  // If the URL is not the RESOURCE list then return to signal that the
  // browser should take over.
  if (!RESOURCES[key]) {
    return;
  }
  // If the URL is the index.html, perform an online-first request.
  if (key == '/') {
    return onlineFirst(event);
  }
  event.respondWith(caches.open(CACHE_NAME)
    .then((cache) =>  {
      return cache.match(event.request).then((response) => {
        // Either respond with the cached resource, or perform a fetch and
        // lazily populate the cache only if the resource was successfully fetched.
        return response || fetch(event.request).then((response) => {
          if (response && Boolean(response.ok)) {
            cache.put(event.request, response.clone());
          }
          return response;
        });
      })
    })
  );
});
self.addEventListener('message', (event) => {
  // SkipWaiting can be used to immediately activate a waiting service worker.
  // This will also require a page refresh triggered by the main worker.
  if (event.data === 'skipWaiting') {
    self.skipWaiting();
    return;
  }
  if (event.data === 'downloadOffline') {
    downloadOffline();
    return;
  }
});
// Download offline will check the RESOURCES for all files not in the cache
// and populate them.
async function downloadOffline() {
  var resources = [];
  var contentCache = await caches.open(CACHE_NAME);
  var currentContent = {};
  for (var request of await contentCache.keys()) {
    var key = request.url.substring(origin.length + 1);
    if (key == "") {
      key = "/";
    }
    currentContent[key] = true;
  }
  for (var resourceKey of Object.keys(RESOURCES)) {
    if (!currentContent[resourceKey]) {
      resources.push(resourceKey);
    }
  }
  return contentCache.addAll(resources);
}
// Attempt to download the resource online before falling back to
// the offline cache.
function onlineFirst(event) {
  return event.respondWith(
    fetch(event.request).then((response) => {
      return caches.open(CACHE_NAME).then((cache) => {
        cache.put(event.request, response.clone());
        return response;
      });
    }).catch((error) => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request).then((response) => {
          if (response != null) {
            return response;
          }
          throw error;
        });
      });
    })
  );
}
