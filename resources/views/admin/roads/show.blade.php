@extends('admin.layouts.app')
@section('title', 'Detail Data Jalan - ' . $road->nama)

@section('content')
<div class="modal" style="width: 100%; max-width: 1200px; margin: 0 auto; box-shadow: none;">
    <div class="modal-body" style="padding: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Detail Jalan</h3>
            <a href="{{ route('admin.roads.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
            <!-- Informasi Teks -->
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #eaecf0;">
                <table style="width: 100%; text-align: left; border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Nama</td>
                            <td style="padding: 8px 0; font-weight: 500; border-bottom: 1px solid #eaecf0;">{{ $road->nama }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Panjang</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">{{ number_format($road->panjang, 1) }} km</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Lebar</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">{{ number_format($road->lebar, 1) }} m</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Kecamatan</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">{{ $road->kecamatan }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Kelurahan</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">{{ $road->kelurahan ? $road->kelurahan : '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Perkerasan</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">{{ $road->jenis_perkerasan }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Kondisi</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">
                                @php
                                    $badgeClass = '';
                                    if($road->kondisi == 'Baik') $badgeClass = 'baik';
                                    if($road->kondisi == 'Sedang') $badgeClass = 'sedang';
                                    if($road->kondisi == 'Rusak Ringan') $badgeClass = 'rusak-ringan';
                                    if($road->kondisi == 'Rusak Berat') $badgeClass = 'rusak-berat';
                                @endphp
                                <span class="kondisi-badge {{ $badgeClass }}">{{ $road->kondisi }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; font-weight: 600; color: #475467; border-bottom: 1px solid #eaecf0;">Tahun</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eaecf0;">{{ $road->tahun ? $road->tahun : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="margin-top: 20px; text-align: center;">
                    <a href="{{ route('admin.roads.edit', $road->id) }}" class="btn btn-primary" style="width: 100%; border-radius: 6px;">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                </div>
            </div>

            <!-- Area Peta Leaflet -->
            <div>
                <div id="show-map" style="height: 500px; width: 100%; border-radius: 8px; border: 1px solid #ccc;"></div>
            </div>
        </div>
    </div>
</div>

@php
    $roadCoords = is_array($road->coordinates) ? $road->coordinates : [];
@endphp
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roadCoordinates = @json($roadCoords);
        const map = L.map('show-map').setView([-0.02, 109.34], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            maxZoom: 19 
        }).addTo(map);

        if (roadCoordinates && roadCoordinates.length > 0) {
            let lastMarker = null;
            let bounds = new L.LatLngBounds();
            
            roadCoordinates.forEach(ll => {
                const marker = L.marker([ll[0], ll[1]]);
                marker.addTo(map);
                marker.bindPopup("<b>{{ $road->nama }}</b><br>Kondisi: {{ $road->kondisi }}").openPopup();
                bounds.extend([ll[0], ll[1]]);
                lastMarker = marker;
            });
            
            // Zoom to the location automatically
            if (roadCoordinates.length > 1) {
                map.fitBounds(bounds, { padding: [20, 20] });
            } else if (lastMarker) {
                map.flyTo([roadCoordinates[0][0], roadCoordinates[0][1]], 16, { duration: 1 });
            }
        } else {
            // Default center if no coords
            L.popup()
                .setLatLng([-0.02, 109.34])
                .setContent("Belum ada koordinat poin untuk jalan ini.")
                .openOn(map);
        }

        setTimeout(() => map.invalidateSize(), 300);
    });
</script>
@endpush
