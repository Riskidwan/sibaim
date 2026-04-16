/**
 * SIBAIM WebGIS Public Application Logic
 * Featuring Multi-Theme Base Layers and Live Data Integration
 */

let pubMap;
let roadLayer;
let allRoads = [];

document.addEventListener('DOMContentLoaded', function() {
    initPubMap();
    fetchRoadData();
});

function initPubMap() {
    // 1. Initial Map Setup
    pubMap = L.map('pub-map').setView([-6.8893, 109.3813], 12); // Center to Pemalang

    // 2. Define Base Layers (Themes)
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    });

    const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: 'Google Streets'
    });

    const googleSatellite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: 'Google Satellite'
    });

    const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: 'Google Hybrid'
    });

    const googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: 'Google Terrain'
    });

    const esriWorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EBP, and the GIS User Community'
    });

    const esriWorldStreet = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
    });

    const cartoVoyager = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &copy; CARTO',
        subdomains: 'abcd',
        maxZoom: 20
    });

    const cartoDark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &copy; CARTO',
        subdomains: 'abcd',
        maxZoom: 20
    });

    const stadiaSmooth = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
        maxZoom: 20,
        attribution: '&copy; Stadia Maps, &copy; OpenStreetMap'
    });

    // 3. Add Default Layer
    osm.addTo(pubMap);

    // 4. Layer Control
    const baseMaps = {
        "OpenStreetMap": osm,
        "Google Streets": googleStreets,
        "Google Satellite": googleSatellite,
        "Google Hybrid": googleHybrid,
        "Google Terrain": googleTerrain,
        "Esri Imagery": esriWorldImagery,
        "Esri Streets": esriWorldStreet,
        "CartoDB Voyager": cartoVoyager,
        "CartoDB Dark": cartoDark,
        "Stadia Smooth": stadiaSmooth
    };

    const layerControl = L.control.layers(baseMaps, null, { collapsed: true }).addTo(pubMap);
    const layerContainer = layerControl.getContainer();
    
    // 1. Matikan SEMUA event hover bawaan Leaflet (mouseover, mouseenter, pointerover)
    ['mouseover', 'mouseenter', 'pointerover', 'mouseout', 'mouseleave', 'pointerout'].forEach(evt => {
        L.DomEvent.off(layerContainer, evt);
        // Tambahkan penghenti event pasif jika perlu
        L.DomEvent.on(layerContainer, evt, L.DomEvent.stop);
    });
    
    // 2. Klik ikon untuk Toggle (Buka/Tutup)
    const toggleButton = layerContainer.querySelector('.leaflet-control-layers-toggle');
    L.DomEvent.on(toggleButton, 'click', function(e) {
        L.DomEvent.stop(e);
        const isExpanded = layerContainer.classList.contains('leaflet-control-layers-expanded');
        if (isExpanded) {
            layerControl.collapse();
        } else {
            layerControl.expand();
        }
    });

    // 3. Klik luar untuk tutup otomatis
    L.DomEvent.on(document, 'click', function(e) {
        if (!layerContainer.contains(e.target)) {
            layerControl.collapse();
        }
    });
    
    // 4. Tutup otomatis setelah pilih tema
    pubMap.on('baselayerchange', function() {
        layerControl.collapse();
    });

    // Initial scale
    L.control.scale().addTo(pubMap);
}

async function fetchRoadData() {
    try {
        const response = await fetch('/api/roads');
        const data = await response.json();
        allRoads = data;
        renderRoads(data);
        populateSearchList(data);
    } catch (error) {
        console.error('Error fetching road data:', error);
    }
}

function renderRoads(roads) {
    if (roadLayer) pubMap.removeLayer(roadLayer);
    
    roadLayer = L.featureGroup();

    roads.forEach(road => {
        const rawCoords = road.coordinates;

        if (rawCoords && rawCoords.length > 0) {
            // Robust coordinate handling: ensures we have [[lat, lng], ...]
            let coords = Array.isArray(rawCoords[0]) ? rawCoords : [rawCoords];
            
            const color = getKondisiColor(road.kondisi);
            const icon = getKondisiIcon(road.kondisi);
            let layer;

            if (coords.length === 1) {
                // Point Marker
                const iconHtml = `
                    <div class="custom-map-marker">
                        <div class="marker-pin" style="background: ${color}">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div class="marker-pulse"></div>
                    </div>
                `;
                
                const customIcon = L.divIcon({
                    html: iconHtml,
                    className: '',
                    iconSize: [30, 42],
                    iconAnchor: [15, 42]
                });

                layer = L.marker([coords[0][0], coords[0][1]], {
                    icon: customIcon
                });
            } else {
                // Line / Polyline
                layer = L.polyline(coords, {
                    color: color,
                    weight: 5,
                    opacity: 0.8
                });
            }

            layer.on('click', () => {
                pubShowDetail(road);
            });

            layer.addTo(roadLayer);
        }
    });

    roadLayer.addTo(pubMap);
}

function getKondisiIcon(kondisi) {
    switch(kondisi) {
        case 'Baik': return 'fa-check';
        case 'Sedang': return 'fa-info';
        case 'Rusak Ringan': return 'fa-exclamation';
        case 'Rusak Berat': return 'fa-exclamation-triangle';
        default: return 'fa-road';
    }
}

function getKondisiColor(kondisi) {
    switch(kondisi) {
        case 'Baik': return '#22c55e';
        case 'Sedang': return '#eab308';
        case 'Rusak Ringan': return '#f97316';
        case 'Rusak Berat': return '#ef4444';
        default: return '#64748b';
    }
}

function populateSearchList(roads) {
    const list = document.getElementById('pub-road-list');
    if (!list) return;
    list.innerHTML = '';
    roads.forEach(road => {
        const opt = document.createElement('option');
        opt.value = road.nama;
        list.appendChild(opt);
    });
}

function pubGoToRoad(name) {
    if (!name) return;
    
    // Case-insensitive search
    const road = allRoads.find(r => r.nama.toLowerCase() === name.toLowerCase());
    
    if (road) {
        const rawCoords = road.coordinates;
        if (rawCoords && rawCoords.length > 0) {
            // Robust check
            const targetPos = Array.isArray(rawCoords[0]) ? rawCoords[0] : rawCoords;
            pubMap.flyTo([targetPos[0], targetPos[1]], 16);
            pubShowDetail(road);
        }
    }
}

// Add event listener for better search experience (datalist selection)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pub-road-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            pubGoToRoad(this.value);
        });
    }
});

function pubShowDetail(road) {
    document.getElementById('pub-detail-nama').innerText = road.nama;
    document.getElementById('pub-detail-panjang').innerText = road.panjang + ' km';
    document.getElementById('pub-detail-lebar').innerText = road.lebar + ' m';
    document.getElementById('pub-detail-perkerasan').innerText = road.jenis_perkerasan || '-';
    document.getElementById('pub-detail-kecamatan').innerText = road.kecamatan || '-';
    document.getElementById('pub-detail-kelurahan').innerText = road.kelurahan || '-';
    
    const badge = document.getElementById('pub-detail-kondisi');
    badge.innerText = road.kondisi;
    badge.className = 'kondisi-badge ' + road.kondisi.toLowerCase().replace(' ', '-');
    
    document.getElementById('pub-detail-overlay').classList.add('active');
}

function pubCloseDetail() {
    document.getElementById('pub-detail-overlay').classList.remove('active');
}

// Global expose
window.pubGoToRoad = pubGoToRoad;
window.pubCloseDetail = pubCloseDetail;
window.pubShowDetail = pubShowDetail;
