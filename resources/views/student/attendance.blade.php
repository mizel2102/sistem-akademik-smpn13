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
                <p class="text-slate-700">4. Pastikan Anda berada dalam radius {{ config('app.school_max_distance_meters', 100) }} meter dari lokasi sekolah.</p>
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
                    <p class="mt-1 text-xs text-red-700" x-text="locationError || `Anda berada sejauh ${distance} meter dari sekolah. Batas maksimal adalah ${maxDistance} meter.`"></p>
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
                <label class="mb-2 block text-sm font-semibold text-slate-900">Foto Absensi (Smart Capture Kamera)</label>
                
                <input type="hidden" name="selfie_base64" x-model="selfieBase64">

                <!-- Camera Container -->
                <div class="relative overflow-hidden rounded-3xl border-2 border-slate-200 bg-slate-900 text-center shadow-inner">
                    <!-- Live Camera Feed -->
                    <div x-show="cameraActive && !captured" class="relative">
                        <video x-ref="video" autoplay playsinline class="h-64 w-full object-cover transform -scale-x-100 rounded-3xl"></video>
                        
                        <!-- Camera Live Badge -->
                        <div class="absolute top-3 left-3 flex items-center gap-2 rounded-full bg-black/60 px-3 py-1 text-xs font-semibold text-white backdrop-blur-md">
                            <div class="h-2 w-2 rounded-full bg-red-500 animate-ping"></div>
                            Kamera Berjalan (Live)
                        </div>
                    </div>

                    <!-- Snapshot Preview -->
                    <div x-show="captured" class="relative" x-cloak>
                        <img :src="selfiePreview" class="h-64 w-full object-cover rounded-3xl" alt="Hasil Foto Absensi">
                        <div class="absolute top-3 left-3 rounded-full bg-emerald-600/90 px-3 py-1 text-xs font-semibold text-white backdrop-blur-md">
                            ✓ Foto Berhasil Dijepret
                        </div>
                    </div>

                    <!-- Camera Placeholder (Before Start) -->
                    <div x-show="!cameraActive && !captured" class="flex flex-col items-center justify-center py-12 px-4 text-white">
                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-white backdrop-blur-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-white">Smart Capture Kamera Live</p>
                        <p class="mt-1 text-xs text-slate-300">Klik tombol di bawah untuk mengaktifkan kamera depan.</p>
                        <button type="button" @click="startCamera" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white shadow-lg transition hover:bg-blue-700">
                            Aktifkan Kamera
                        </button>
                    </div>
                </div>

                <!-- Hidden Canvas for Snapshot Capture -->
                <canvas x-ref="canvas" class="hidden"></canvas>

                <!-- Camera Controls Buttons -->
                <div class="mt-3 flex items-center justify-center gap-3">
                    <template x-if="cameraActive && !captured">
                        <button type="button" @click="takeSnapshot" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-xs font-bold text-white shadow-md transition hover:bg-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Jepret Foto
                        </button>
                    </template>

                    <template x-if="captured">
                        <button type="button" @click="retakePhoto" class="inline-flex items-center gap-2 rounded-xl bg-slate-700 px-5 py-2.5 text-xs font-semibold text-white shadow-md transition hover:bg-slate-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Foto Ulang
                        </button>
                    </template>
                </div>

                @error('selfie') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                @error('selfie_base64') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <button type="submit" :disabled="!isWithinRange || loadingLocation || !captured" :class="{'opacity-50 cursor-not-allowed': !isWithinRange || loadingLocation || !captured}" class="w-full rounded-2xl bg-navy px-6 py-3.5 text-sm font-bold text-white transition hover:bg-opacity-90 shadow-lg">
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
            maxDistance: parseInt("{{ config('app.school_max_distance_meters', 100) }}"),
            loadingLocation: true,
            locationError: '',
            isLate: false,
            entryTime: "{{ config('app.school_entry_time', '06:45') }}",
            lateTolerance: parseInt("{{ config('app.school_late_tolerance_minutes', 15) }}"),
            cameraActive: false,
            captured: false,
            selfieBase64: '',
            selfiePreview: '',
            mediaStream: null,

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

            async startCamera() {
                try {
                    this.mediaStream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }
                    });
                    if (this.$refs.video) {
                        this.$refs.video.srcObject = this.mediaStream;
                    }
                    this.cameraActive = true;
                } catch (err) {
                    alert('Gagal mengakses kamera: ' + err.message + '. Pastikan izin akses kamera telah diberikan di browser.');
                }
            },

            takeSnapshot() {
                const video = this.$refs.video;
                const canvas = this.$refs.canvas;
                if (!video || !canvas) return;

                canvas.width = video.videoWidth || 640;
                canvas.height = video.videoHeight || 480;
                const ctx = canvas.getContext('2d');

                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                this.selfiePreview = canvas.toDataURL('image/jpeg', 0.85);
                this.selfieBase64 = this.selfiePreview;
                this.captured = true;

                this.stopCamera();
            },

            retakePhoto() {
                this.captured = false;
                this.selfiePreview = '';
                this.selfieBase64 = '';
                this.startCamera();
            },

            stopCamera() {
                if (this.mediaStream) {
                    this.mediaStream.getTracks().forEach(track => track.stop());
                    this.mediaStream = null;
                }
                this.cameraActive = false;
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
                            
                            if (this.distance <= this.maxDistance) {
                                this.isWithinRange = true;
                                this.locationError = '';
                            } else {
                                this.isWithinRange = false;
                                this.locationError = `Anda berada di luar area sekolah. Jarak Anda: ${this.distance} meter. Maksimal: ${this.maxDistance} meter.`;
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
