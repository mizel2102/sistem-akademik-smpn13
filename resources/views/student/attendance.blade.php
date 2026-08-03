@extends('layouts.app')

@section('page-title', 'Absensi Hari Ini')
@section('breadcrumb', 'Siswa › Absensi Hari Ini')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-navy">Absensi Hari Ini</h1>
        <p class="mt-2 text-slate-600">Catat kehadiran Anda untuk kelas hari ini.</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-blue-50 p-5 text-sm text-slate-700">
        <div class="flex items-start gap-3">
            <div class="mt-1 flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="space-y-1">
                <p class="font-semibold text-blue-900">Ketentuan Waktu & Lokasi Absensi:</p>
                <p class="text-slate-700">1. Jam Masuk Sekolah: <span class="font-bold text-navy">{{ config('app.school_entry_time', '06:45') }} WIB</span>.</p>
                <p class="text-slate-700">2. Batas Toleransi Keterlambatan: <span class="font-bold text-navy">15 Menit</span> (Maksimal jam <span class="font-bold text-emerald-700">07:00 WIB</span>).</p>
                <p class="text-slate-700">3. Absensi yang dilakukan setelah jam <span class="font-bold text-red-600">07:00 WIB</span> akan otomatis dicatat sebagai <span class="font-bold text-amber-700">TERLAMBAT</span>.</p>
                <p class="text-slate-700">4. Pastikan Anda berada dalam radius 20 meter dari lokasi sekolah.</p>
            </div>
        </div>
    </div>

    <div class="mx-auto w-full max-w-lg rounded-2xl bg-white p-6 shadow-sm mb-20" x-data="attendanceForm()">
        <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
            <h2 class="text-xl font-bold text-navy">Form Absensi</h2>
            
            <div class="flex items-center gap-2">
                <!-- Status Waktu Badge -->
                <div class="flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold"
                     :class="isLate ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'" x-cloak>
                    <div class="h-2 w-2 rounded-full" :class="isLate ? 'bg-amber-500' : 'bg-emerald-500'"></div>
                    <span x-text="isLate ? 'Terlambat (> 07:00)' : 'Tepat Waktu (≤ 07:00)'"></span>
                </div>

                <!-- Status Lokasi Badge -->
                <div class="flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold"
                     :class="{'bg-yellow-100 text-yellow-700': loadingLocation, 'bg-red-100 text-red-700': !loadingLocation && !isWithinRange, 'bg-emerald-100 text-emerald-700': !loadingLocation && isWithinRange}">
                    <svg x-show="loadingLocation" class="h-3 w-3 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <div x-show="!loadingLocation && !isWithinRange" class="h-2 w-2 rounded-full bg-red-500" x-cloak></div>
                    <div x-show="!loadingLocation && isWithinRange" class="h-2 w-2 rounded-full bg-emerald-500" x-cloak></div>
                    <span x-text="loadingLocation ? 'Melacak...' : (isWithinRange ? 'Lokasi Sesuai' : 'Luar Area')"></span>
                </div>
            </div>
        </div>

        <!-- Alert Lokasi Tidak Valid -->
        <div x-show="!loadingLocation && !isWithinRange" x-cloak class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mt-0.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-red-800">Gagal Memverifikasi Lokasi</h3>
                    <p class="mt-1 text-xs text-red-700" x-text="locationError || `Anda berada sejauh ${distance} meter dari sekolah. Batas maksimal adalah 20 meter.`"></p>
                    <button type="button" @click="getLocation" class="mt-3 inline-flex items-center gap-1 rounded-lg bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" /></svg>
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('student.attendance.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <input type="hidden" name="latitude" x-model="latitude">
            <input type="hidden" name="longitude" x-model="longitude">
            <input type="hidden" name="distance" x-model="distance">
            <input type="hidden" name="status" x-model="status">
            <input type="hidden" name="attendance_time" x-model="attendance_time">

            <div>
                <label for="academic_class_id" class="mb-2 block text-sm font-semibold text-slate-900">Pilih Kelas</label>
                <select
                    id="academic_class_id"
                    name="academic_class_id"
                    class="w-full rounded-2xl border-2 border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 transition focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20 @error('academic_class_id') border-red-500 @enderror"
                >
                    <option value="">Pilih kelas...</option>
                    @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}" {{ old('academic_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
                @error('academic_class_id')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
                @error('latitude') <p class="mt-2 text-sm text-red-500">Error Lokasi: {{ $message }}</p> @enderror
                @error('distance') <p class="mt-2 text-sm text-red-500">Error Jarak: {{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-900" for="selfie">Foto Selfie</label>
                <label for="selfie" class="group relative flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center transition hover:border-navy hover:bg-slate-100">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-navy text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553 2.276A2 2 0 0 1 21 14.118V18a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3.882a2 2 0 0 1 1.447-1.842L9 10m6 0V5a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Unggah foto selfie</p>
                        <p class="mt-1 text-xs text-slate-500">Klik atau tarik file di sini. Format gambar saja.</p>
                    </div>
                </label>
                <input
                    type="file"
                    id="selfie"
                    name="selfie"
                    accept="image/*"
                    capture="user"
                    class="sr-only"
                >
                @error('selfie')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" :disabled="!isWithinRange || loadingLocation" :class="{'opacity-50 cursor-not-allowed': !isWithinRange || loadingLocation}" class="w-full rounded-2xl bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-opacity-90">
                Kirim Absensi
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('attendanceForm', () => ({
            latitude: '',
            longitude: '',
            distance: '',
            status: 'present',
            attendance_time: '',
            schoolLat: parseFloat("{{ config('app.school_latitude', '-0.0360278') }}"),
            schoolLng: parseFloat("{{ config('app.school_longitude', '109.3568889') }}"),
            loadingLocation: true,
            locationError: '',
            isLate: false,
            entryTime: "{{ config('app.school_entry_time', '06:45') }}",
            lateTolerance: parseInt("{{ config('app.school_late_tolerance_minutes', 15) }}"),

            init() {
                // Set to current local time in Y-m-d H:i:s format for database
                const now = new Date();
                this.attendance_time = now.getFullYear() + '-' + 
                                       String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                       String(now.getDate()).padStart(2, '0') + ' ' + 
                                       String(now.getHours()).padStart(2, '0') + ':' + 
                                       String(now.getMinutes()).padStart(2, '0') + ':' + 
                                       String(now.getSeconds()).padStart(2, '0');

                // Check late cutoff (06:45 + 15m = 07:00:00 WIB)
                const cutoff = new Date(now);
                const [entryHour, entryMinute] = this.entryTime.split(':').map(Number);
                cutoff.setHours(entryHour, entryMinute + this.lateTolerance, 0, 0);

                if (now > cutoff) {
                    this.isLate = true;
                    this.status = 'late';
                } else {
                    this.isLate = false;
                    this.status = 'present';
                }

                this.getLocation();
            },

            getLocation() {
                this.loadingLocation = true;
                this.locationError = '';
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.latitude = position.coords.latitude;
                            this.longitude = position.coords.longitude;
                            
                            this.distance = Math.round(this.calculateDistance(this.latitude, this.longitude, this.schoolLat, this.schoolLng));
                            
                            this.loadingLocation = false;
                            
                            if (this.distance <= 20) {
                                this.isWithinRange = true;
                                this.locationError = '';
                            } else {
                                this.isWithinRange = false;
                                this.locationError = `Anda berada di luar area sekolah. Jarak Anda: ${this.distance} meter. Maksimal: 20 meter.`;
                            }
                        },
                        (error) => {
                            this.loadingLocation = false;
                            this.isWithinRange = false;
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    this.locationError = "Izin lokasi ditolak. Silakan izinkan akses lokasi di browser Anda.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    this.locationError = "Informasi lokasi tidak tersedia saat ini.";
                                    break;
                                case error.TIMEOUT:
                                    this.locationError = "Waktu permintaan lokasi habis.";
                                    break;
                                default:
                                    this.locationError = "Terjadi kesalahan tidak dikenal saat mengambil lokasi.";
                                    break;
                            }
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                } else {
                    this.loadingLocation = false;
                    this.locationError = 'Browser Anda tidak mendukung fitur lokasi GPS.';
                }
            },

            calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371e3; // radius bumi dalam meter
                const phi1 = lat1 * Math.PI/180;
                const phi2 = lat2 * Math.PI/180;
                const deltaPhi = (lat2-lat1) * Math.PI/180;
                const deltaLambda = (lon2-lon1) * Math.PI/180;

                const a = Math.sin(deltaPhi/2) * Math.sin(deltaPhi/2) +
                        Math.cos(phi1) * Math.cos(phi2) *
                        Math.sin(deltaLambda/2) * Math.sin(deltaLambda/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

                return R * c;
            }
        }))
    })
</script>
@endpush
