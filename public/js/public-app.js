/**
 * public-app.js - Public Landing Page Logic (Breezed Template)
 * Handles: stats, map, table, filters, detail panel
 */

// ── State ──
var pubMap = null;
var pubRoadLayers = {};
var pubLayerGroup = null;
var pubTablePage = 1;
var PUB_PER_PAGE = 10;

// ── Init ──
document.addEventListener('DOMContentLoaded', async function () {
  await initData();
  renderPubStats();
  initPubMap();
  initPubOuterSearch();
});

// ── Statistics ──
function renderPubStats() {
  if (!document.getElementById('pub-stat-total')) return; // Guard for pages without stats section

  var stats = getStatistics();

  document.getElementById('pub-stat-total').textContent = stats.totalJalan;
  document.getElementById('pub-stat-panjang').textContent = stats.totalPanjang.toFixed(1) + ' km';
  document.getElementById('pub-stat-baik').textContent = stats.kondisiCount['Baik'] || 0;
  document.getElementById('pub-stat-baik-km').textContent = (stats.kondisiPanjang['Baik'] || 0).toFixed(1) + ' km';
  document.getElementById('pub-stat-sedang').textContent = stats.kondisiCount['Sedang'] || 0;
  document.getElementById('pub-stat-sedang-km').textContent = (stats.kondisiPanjang['Sedang'] || 0).toFixed(1) + ' km';
  document.getElementById('pub-stat-rusak-ringan').textContent = stats.kondisiCount['Rusak Ringan'] || 0;
  document.getElementById('pub-stat-rusak-ringan-km').textContent = (stats.kondisiPanjang['Rusak Ringan'] || 0).toFixed(1) + ' km';
  document.getElementById('pub-stat-rusak-berat').textContent = stats.kondisiCount['Rusak Berat'] || 0;
  document.getElementById('pub-stat-rusak-berat-km').textContent = (stats.kondisiPanjang['Rusak Berat'] || 0).toFixed(1) + ' km';
}

// ── Maps ──
function initPubMap() {
  if (!document.getElementById('pub-map')) return; // Guard for pages without map

  pubMap = L.map('pub-map', { zoomControl: true }).setView([-0.02, 109.34], 13);

  var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  });

  var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    maxZoom: 19,
    attribution: '&copy; Esri'
  });

  osmLayer.addTo(pubMap);

  L.control.layers(
    { 'Street Map': osmLayer, 'Satellite': satelliteLayer },
    null,
    { position: 'topright', collapsed: true }
  ).addTo(pubMap);

  renderPubRoads();

  setTimeout(function () { pubMap.invalidateSize(); }, 500);

  // Re-invalidate when map section scrolls into view
  var mapSection = document.getElementById('peta');
  if (window.IntersectionObserver) {
    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting && pubMap) {
          pubMap.invalidateSize();
        }
      });
    }, { threshold: 0.1 });
    obs.observe(mapSection);
  }
}

function renderPubRoads() {
  if (pubLayerGroup) pubMap.removeLayer(pubLayerGroup);
  pubRoadLayers = {};
  pubLayerGroup = L.layerGroup();

  var roads = getRoads();

  roads.forEach(function (road) {
    if (road.coordinates && road.coordinates.length > 0) {
      var markerPos = road.coordinates[0];
      var roadColor = getKondisiColor(road.kondisi);

      var customIcon = L.divIcon({
        className: 'custom-map-marker-simple',
        html: '<i class="fas fa-map-marker-alt" style="color: ' + roadColor + '; font-size: 32px; filter: drop-shadow(0px 3px 3px rgba(0,0,0,0.4));"></i>',
        iconSize: [30, 42],
        iconAnchor: [15, 42],
        popupAnchor: [0, -35]
      });

      var marker = L.marker(markerPos, { icon: customIcon });

      marker.bindTooltip(
        '<strong>' + road.nama + '</strong><br>' + road.kondisi + ' • ' + road.panjang + ' km',
        { direction: 'top', offset: [0, -35], className: 'road-tooltip' }
      );

      marker.on('click', function () {
        pubOpenDetail(road.id);
      });

      pubRoadLayers[road.id] = marker;
      pubLayerGroup.addLayer(marker);
    }
  });

  pubLayerGroup.addTo(pubMap);
}

function initPubOuterSearch() {
  var dataList = document.getElementById('pub-road-list');
  if (!dataList) return;

  var allRoads = getRoads();
  var html = '';
  
  // Sort roads alphabetically
  var sortedRoads = allRoads.slice().sort(function(a, b) {
    return (a.nama || '').localeCompare(b.nama || '');
  });
  
  sortedRoads.forEach(function(r) {
    html += '<option value="' + r.nama + '">' + (r.kecamatan || '') + '</option>';
  });
  
  dataList.innerHTML = html;
}

function pubGoToRoad(nama) {
  if (!nama) return;
  var searchStr = nama.trim().toLowerCase();
  var allRoads = getRoads();
  
  // Try exact case-insensitive match
  var road = allRoads.find(function(r) { 
    return (r.nama || '').toLowerCase() === searchStr; 
  });
  
  // If not found, try partial match
  if (!road) {
    road = allRoads.find(function(r) { 
      return (r.nama || '').toLowerCase().indexOf(searchStr) > -1; 
    });
  }

  if (road) {
    // Just zoom map to road marker, without opening the detail panel
    if (road.coordinates && road.coordinates.length > 0) {
      var markerPos = road.coordinates[0];
      pubMap.flyTo(markerPos, 16, { duration: 1.5 });
      
      // Highlight temporarily
      if (pubRoadLayers[road.id]) {
        var iconDiv = pubRoadLayers[road.id].getElement();
        if (iconDiv) {
          iconDiv.classList.add('marker-highlight-bounce');
          setTimeout(function () {
            iconDiv.classList.remove('marker-highlight-bounce');
          }, 3000);
        }
      }
    }
  } else {
    // If not found, reset map to center
    pubMap.setView([-0.02, 109.34], 13);
  }
}

// ── Detail Panel ──
function pubOpenDetail(roadId) {
  var road = getRoadById(roadId);
  if (!road) return;

  document.getElementById('pub-detail-nama').textContent = road.nama;
  document.getElementById('pub-detail-panjang').textContent = road.panjang + ' km';
  document.getElementById('pub-detail-lebar').textContent = road.lebar + ' m';
  document.getElementById('pub-detail-perkerasan').textContent = road.jenis_perkerasan;
  document.getElementById('pub-detail-kondisi-text').textContent = road.kondisi;
  document.getElementById('pub-detail-kecamatan').textContent = road.kecamatan;
  document.getElementById('pub-detail-kelurahan').textContent = road.kelurahan || '-';

  var badge = document.getElementById('pub-detail-kondisi');
  badge.textContent = road.kondisi;
  badge.className = 'kondisi-badge ' + getKondisiClass(road.kondisi);

  document.getElementById('pub-detail-overlay').classList.add('show');

  // Zoom map to road marker
  if (road.coordinates && road.coordinates.length > 0) {
    var markerPos = road.coordinates[0];
    pubMap.flyTo(markerPos, 16, { duration: 1.5 });

    // Highlight temporarily
    if (pubRoadLayers[roadId]) {
      var iconDiv = pubRoadLayers[roadId].getElement();
      if (iconDiv) {
        iconDiv.classList.add('marker-highlight-bounce');
        setTimeout(function () {
          iconDiv.classList.remove('marker-highlight-bounce');
        }, 3000);
      }
    }
  }
}

function pubCloseDetail() {
  document.getElementById('pub-detail-overlay').classList.remove('show');
}

// Close on overlay click
document.addEventListener('click', function (e) {
  var overlay = document.getElementById('pub-detail-overlay');
  if (e.target === overlay) {
    pubCloseDetail();
  }
});

// Close on Escape key
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') pubCloseDetail();
});


