@extends('admin.layouts.app')
@section('title', 'Tambah Data Jalan')

@section('content')
<div class="modal" style="width: 100%; max-width: 1200px; margin: 0 auto; box-shadow: none;">
    <div class="modal-body" style="padding: 0;">
        <form action="{{ route('admin.roads.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="nama">Nama Jalan <span style="color: #ef4444">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-input @error('nama') error @enderror" value="{{ old('nama') }}" required />
                    @error('nama') <span style="color:red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="panjang">Panjang (km) <span style="color: #ef4444">*</span></label>
                    <input type="number" id="panjang" name="panjang" class="form-input" step="0.1" min="0" value="{{ old('panjang') }}" required />
                </div>
                <div class="form-group">
                    <label for="lebar">Lebar (m) <span style="color: #ef4444">*</span></label>
                    <input type="number" id="lebar" name="lebar" class="form-input" step="0.1" min="0" value="{{ old('lebar') }}" required />
                </div>
                <div class="form-group">
                    <label for="jenis_perkerasan">Jenis Perkerasan</label>
                    <select id="jenis_perkerasan" name="jenis_perkerasan" class="form-select">
                        <option value="Aspal" {{ old('jenis_perkerasan') == 'Aspal' ? 'selected' : '' }}>Aspal</option>
                        <option value="Beton" {{ old('jenis_perkerasan') == 'Beton' ? 'selected' : '' }}>Beton</option>
                        <option value="Tanah" {{ old('jenis_perkerasan') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                        <option value="Kerikil" {{ old('jenis_perkerasan') == 'Kerikil' ? 'selected' : '' }}>Kerikil</option>
                        <option value="Paving" {{ old('jenis_perkerasan') == 'Paving' ? 'selected' : '' }}>Paving</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi Jalan</label>
                    <select id="kondisi" name="kondisi" class="form-select">
                        <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Sedang" {{ old('kondisi') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan <span style="color: #ef4444">*</span></label>
                    <input type="text" id="kecamatan" name="kecamatan" class="form-input" value="{{ old('kecamatan') }}" required />
                </div>
                <div class="form-group">
                    <label for="kelurahan">Kelurahan</label>
                    <input type="text" id="kelurahan" name="kelurahan" class="form-input" value="{{ old('kelurahan') }}" />
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Pembangunan</label>
                    <input type="number" id="tahun" name="tahun" class="form-input" value="{{ old('tahun', date('Y')) }}" min="1900" max="2099" />
                </div>
                
                <div class="form-group">
                    <label for="latitude">Latitude (Garis Lintang)</label>
                    <input type="text" id="latitude" class="form-input" placeholder="Contoh: -0.02" />
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude (Garis Bujur)</label>
                    <input type="text" id="longitude" class="form-input" placeholder="Contoh: 109.34" />
                </div>
                
                <!-- Hidden input for coordinate json array -->
                <input type="hidden" id="coordinates_json" name="coordinates_json" value="{{ old('coordinates_json', '[]') }}">

                <div class="form-group full-width">
                    <label>Gambar Titik di Peta <span style="color: #ef4444">*</span></label>
                    <div class="form-hint" style="margin-bottom: 8px;">
                        Gunakan tombol marker <i class="fas fa-map-marker-alt"></i> di sebelah kiri peta untuk menaruh titik koordinat jalan.
                    </div>
                    <div id="modal-map" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ccc;"></div>
                    @error('coordinates_json') <span style="color:red; font-size: 0.8rem;">Titik koordinat wajib diset di peta.</span> @enderror
                </div>
            </div>
            
            <div style="margin-top:20px; text-align:right;">
                <a href="{{ route('admin.roads.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" style="margin-left: 10px;"><i class="fas fa-save"></i> Simpan Jalan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let modalMap;
    let drawnItems;
    
    document.addEventListener('DOMContentLoaded', function() {
        modalMap = L.map('modal-map').setView([-0.02, 109.34], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(modalMap);

        drawnItems = new L.FeatureGroup();
        modalMap.addLayer(drawnItems);

        const drawControl = new L.Control.Draw({
            edit: { featureGroup: drawnItems, remove: true },
            draw: {
                polygon: false, rectangle: false, circle: false,
                circlemarker: false, polyline: false,
                marker: true // Start with point markers for roads per the current structure requirements
            }
        });
        modalMap.addControl(drawControl);

        // Recover old data in case of validation failure
        const existingData = document.getElementById('coordinates_json').value;
        if(existingData && existingData !== '[]') {
            const coords = JSON.parse(existingData);
            coords.forEach(ll => {
                const marker = L.marker([ll.lat || ll[0], ll.lng || ll[1]]);
                drawnItems.addLayer(marker);
            });
        }

        modalMap.on(L.Draw.Event.CREATED, function (e) {
            drawnItems.clearLayers(); // Currently replacing the entire layer so it's a single marker for simplicity based on JS SPA setup
            drawnItems.addLayer(e.layer);
            updateCoordinatesInput();
        });

        modalMap.on(L.Draw.Event.DELETED, function () {
            updateCoordinatesInput();
        });
        
        modalMap.on(L.Draw.Event.EDITED, function () {
            updateCoordinatesInput();
        });

        function updateCoordinatesInput() {
            const coords = [];
            let currentLat = '';
            let currentLng = '';
            
            drawnItems.eachLayer(function(layer) {
                if(layer.getLatLng) { // marker
                    currentLat = layer.getLatLng().lat;
                    currentLng = layer.getLatLng().lng;
                    coords.push([currentLat, currentLng]);
                } else if(layer.getLatLngs) { // polyline
                    const lls = layer.getLatLngs();
                    if (lls.length > 0) {
                        currentLat = lls[0].lat;
                        currentLng = lls[0].lng;
                    }
                    lls.forEach(l => coords.push([l.lat, l.lng]));
                }
            });
            
            document.getElementById('coordinates_json').value = JSON.stringify(coords);
            document.getElementById('latitude').value = currentLat;
            document.getElementById('longitude').value = currentLng;
        }

        // Sinkronisasi input teks manual ke peta
        function syncManualInputToMap() {
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                drawnItems.clearLayers();
                const marker = L.marker([lat, lng]);
                drawnItems.addLayer(marker);
                modalMap.flyTo([lat, lng], 16, { duration: 0.5 });
                
                // Update hidden json
                const coords = [[lat, lng]];
                document.getElementById('coordinates_json').value = JSON.stringify(coords);
            }
        }

        document.getElementById('latitude').addEventListener('input', syncManualInputToMap);
        document.getElementById('longitude').addEventListener('input', syncManualInputToMap);

        setTimeout(() => modalMap.invalidateSize(), 300);
    });
</script>
@endpush
