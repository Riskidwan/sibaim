/**
 * data.js - Mock Data & localStorage Handler
 * Provides sample road data and CRUD operations
 */

const STORAGE_KEY = "gis_roads_data";
const AUTH_KEY = "gis_auth";

// ── API Data Handler (Replaces Mock Data) ──
let apiRoads = [];

async function initData() {
  try {
    const response = await fetch('/api/roads');
    const data = await response.json();
    apiRoads = data.map(road => {
      // Ensure numerical types for coords
      if (road.coordinates) {
        road.coordinates = road.coordinates.map(c => [parseFloat(c.latitude || c[0]), parseFloat(c.longitude || c[1])]);
      } else {
        road.coordinates = [];
      }
      return road;
    });
  } catch (error) {
    console.error('Failed to load roads from API:', error);
  }
}

function getRoads() {
  return apiRoads;
}

function getRoadById(id) {
  const roads = getRoads();
  return roads.find((r) => parseInt(r.id) === parseInt(id));
}

async function addRoad(roadData) {
  try {
    const response = await fetch('/api/roads', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(roadData)
    });
    if (!response.ok) throw new Error('Network response was not ok');
    await initData(); // Refresh local array
    return true;
  } catch (error) {
    console.error('Failed to add road:', error);
    return false;
  }
}

async function updateRoad(id, updatedData) {
  try {
    const response = await fetch('/api/roads/' + id, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(updatedData)
    });
    if (!response.ok) throw new Error('Network response was not ok');
    await initData(); // Refresh local array
    return true;
  } catch (error) {
    console.error('Failed to update road:', error);
    return false;
  }
}

async function deleteRoad(id) {
  try {
    const response = await fetch('/api/roads/' + id, {
      method: 'DELETE'
    });
    if (!response.ok) throw new Error('Network response was not ok');
    await initData(); // Refresh local array
    return true;
  } catch (error) {
    console.error('Failed to delete road:', error);
    return false;
  }
}
function resetToDefault() { }

// ── Filter ──
function filterRoads({ kondisi, kecamatan, jenis_perkerasan, search } = {}) {
  let roads = getRoads();

  if (kondisi && kondisi !== "Semua") {
    roads = roads.filter((r) => r.kondisi === kondisi);
  }
  if (kecamatan && kecamatan !== "Semua") {
    roads = roads.filter((r) => r.kecamatan === kecamatan);
  }
  if (jenis_perkerasan && jenis_perkerasan !== "Semua") {
    roads = roads.filter((r) => r.jenis_perkerasan === jenis_perkerasan);
  }
  if (search) {
    const q = search.toLowerCase();
    roads = roads.filter((r) => r.nama.toLowerCase().includes(q));
  }

  return roads;
}

// ── Statistics ──
function getStatistics() {
  const roads = getRoads();
  const totalJalan = roads.length;
  const totalPanjang = roads.reduce((sum, r) => sum + r.panjang, 0);

  const kondisiCount = {
    Baik: 0,
    Sedang: 0,
    "Rusak Ringan": 0,
    "Rusak Berat": 0,
  };
  const kondisiPanjang = {
    Baik: 0,
    Sedang: 0,
    "Rusak Ringan": 0,
    "Rusak Berat": 0,
  };
  const perkerasanCount = {};
  const kecamatanCount = {};

  roads.forEach((r) => {
    kondisiCount[r.kondisi] = (kondisiCount[r.kondisi] || 0) + 1;
    kondisiPanjang[r.kondisi] = (kondisiPanjang[r.kondisi] || 0) + r.panjang;
    perkerasanCount[r.jenis_perkerasan] =
      (perkerasanCount[r.jenis_perkerasan] || 0) + 1;
    kecamatanCount[r.kecamatan] = (kecamatanCount[r.kecamatan] || 0) + 1;
  });

  return {
    totalJalan,
    totalPanjang,
    kondisiCount,
    kondisiPanjang,
    perkerasanCount,
    kecamatanCount,
  };
}

// ── Unique Values ──
function getUniqueKecamatan() {
  const roads = getRoads();
  return [...new Set(roads.map((r) => r.kecamatan))].sort();
}

function getUniquePerkerasan() {
  const roads = getRoads();
  return [...new Set(roads.map((r) => r.jenis_perkerasan))].sort();
}

// ── Kondisi Color Mapping ──
function getKondisiColor(kondisi) {
  const colors = {
    Baik: "#22c55e",
    Sedang: "#eab308",
    "Rusak Ringan": "#f97316",
    "Rusak Berat": "#ef4444",
  };
  return colors[kondisi] || "#6366f1";
}

function getKondisiClass(kondisi) {
  const classes = {
    Baik: "baik",
    Sedang: "sedang",
    "Rusak Ringan": "rusak-ringan",
    "Rusak Berat": "rusak-berat",
  };
  return classes[kondisi] || "";
}

// ── Auth ──
function login(username, role) {
  const auth = { username, role, loggedIn: true };
  localStorage.setItem(AUTH_KEY, JSON.stringify(auth));
  return auth;
}

function getAuth() {
  const data = localStorage.getItem(AUTH_KEY);
  return data ? JSON.parse(data) : null;
}

function logout() {
  localStorage.removeItem(AUTH_KEY);
}

function isAdmin() {
  // Hardcoded to true for Admin Dashboard visibility
  return true;
}
