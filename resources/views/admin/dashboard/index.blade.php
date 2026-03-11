@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon total"><i class="fas fa-road"></i></div>
        </div>
        <div class="stat-card-value">{{ $totalJalan }}</div>
        <div class="stat-card-label">Total Ruas Jalan</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon length"><i class="fas fa-ruler"></i></div>
        </div>
        <div class="stat-card-value">{{ number_format($totalPanjang, 1) }} km</div>
        <div class="stat-card-label">Total Panjang Jalan</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon baik"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-card-value">{{ $kondisiCount['Baik'] }}</div>
        <div class="stat-card-label">Kondisi Baik</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon sedang"><i class="fas fa-exclamation-circle"></i></div>
        </div>
        <div class="stat-card-value">{{ $kondisiCount['Sedang'] }}</div>
        <div class="stat-card-label">Kondisi Sedang</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon rusak-berat"><i class="fas fa-times-circle"></i></div>
        </div>
        <div class="stat-card-value">{{ $kondisiCount['Rusak Ringan'] + $kondisiCount['Rusak Berat'] }}</div>
        <div class="stat-card-label">Kondisi Rusak</div>
    </div>
</div>

<!-- Charts -->
<div class="charts-row">
    <div class="chart-card">
        <div class="chart-card-title">
            <i class="fas fa-chart-pie" style="color: var(--brand-500); margin-right: 8px"></i>
            Distribusi Kondisi Jalan
        </div>
        <div class="chart-container" style="height: 300px; position: relative;">
            <canvas id="chart-kondisi"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-card-title">
            <i class="fas fa-chart-bar" style="color: #0ba5ec; margin-right: 8px"></i>
            Jenis Perkerasan
        </div>
        <div class="chart-container" style="height: 300px; position: relative;">
            <canvas id="chart-perkerasan"></canvas>
        </div>
    </div>
</div>

<!-- Mini Map -->
<div class="chart-card">
    <div class="chart-card-title">
        <i class="fas fa-map" style="color: var(--brand-500); margin-right: 8px"></i>
        Overview Peta Jalan
    </div>
    <div class="mini-map-container">
        <div id="dashboard-map" style="height: 400px; border-radius: 8px;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async function() {
    // 1. Chart Kondisi
    const ctx1 = document.getElementById('chart-kondisi').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Sedang', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                data: [
                    {{ $kondisiCount['Baik'] }},
                    {{ $kondisiCount['Sedang'] }},
                    {{ $kondisiCount['Rusak Ringan'] }},
                    {{ $kondisiCount['Rusak Berat'] }}
                ],
                backgroundColor: ['#12b76a', '#f79009', '#fb6514', '#f04438'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Chart Perkerasan
    const perkerasanStats = @json($perkerasanCount);
    const pLabels = Object.keys(perkerasanStats);
    const pData = Object.values(perkerasanStats);
    const barColors = ['#465fff', '#0ba5ec', '#7a5af8', '#ee46bc', '#12b76a'];
    
    const ctx2 = document.getElementById('chart-perkerasan').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: pLabels,
            datasets: [{
                label: 'Jumlah Ruas',
                data: pData,
                backgroundColor: barColors.slice(0, pLabels.length),
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // 3. Mini Map Overview
    const map = L.map('dashboard-map').setView([-0.02, 109.34], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

    try {
        const response = await fetch('/api/roads');
        const roads = await response.json();
        
        function getKondisiColor(kondisi) {
            const colors = { 'Baik': '#22c55e', 'Sedang': '#eab308', 'Rusak Ringan': '#f97316', 'Rusak Berat': '#ef4444' };
            return colors[kondisi] || '#6366f1';
        }

        roads.forEach(road => {
            if (road.coordinates && road.coordinates.length > 0) {
                const startNode = road.coordinates[0];
                const markerPos = [parseFloat(startNode.latitude || startNode[0]), parseFloat(startNode.longitude || startNode[1])];
                
                const customIcon = L.divIcon({
                    className: 'custom-map-marker',
                    html: `<div class="marker-pin" style="background-color: ${getKondisiColor(road.kondisi)}; transform: scale(0.8);"><i class="fas fa-road"></i></div>`,
                    iconSize: [24, 34],
                    iconAnchor: [12, 34],
                    popupAnchor: [0, -28]
                });

                L.marker(markerPos, { icon: customIcon }).bindPopup(`<b>${road.nama}</b><br>${road.jenis_perkerasan}`).addTo(map);
            }
        });
    } catch(err) {
        console.error("Gagal memuat jalan untuk peta", err);
    }
});
</script>
@endpush
