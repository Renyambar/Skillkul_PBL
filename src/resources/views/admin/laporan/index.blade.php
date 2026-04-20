@extends('layouts.admin')
@section('title', 'Admin - Laporan Masuk')
@section('content')
@php
    $statusConfig = [
        'pending'      => ['label' => 'Menunggu', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'ditinjau'     => ['label' => 'Ditinjau', 'bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
        'diselesaikan' => ['label' => 'Selesai',  'bg' => 'bg-green-100',  'text' => 'text-green-700'],
        'ditolak'      => ['label' => 'Ditolak',  'bg' => 'bg-red-100',    'text' => 'text-red-700'],
    ];
    $kategoriConfig = [
        'penipuan'              => ['label' => 'Penipuan',             'bg' => 'bg-red-100',    'text' => 'text-red-700'],
        'tidak_selesai'         => ['label' => 'Tidak Diselesaikan',   'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
        'kualitas_buruk'        => ['label' => 'Kualitas Buruk',       'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'perilaku_tidak_pantas' => ['label' => 'Perilaku Tdk Pantas', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
        'lainnya'               => ['label' => 'Lainnya',              'bg' => 'bg-gray-100',   'text' => 'text-gray-600'],
    ];
    // Dummy data untuk demo UI
    $reports = [
        (object)[
            'id' => 'RPT-001', 'pelapor' => 'Andi Surya', 'pelapor_avatar' => 'https://i.pravatar.cc/150?img=5',
            'terlapor' => 'Budi Santoso', 'terlapor_avatar' => 'https://i.pravatar.cc/150?img=12',
            'order_id' => 'ORD-2403', 'kategori' => 'tidak_selesai',
            'deskripsi' => 'Freelancer tidak menyelesaikan desain poster sesuai deadline yang disepakati.',
            'status' => 'pending', 'tanggal' => '20 Apr 2026',
        ],
        (object)[
            'id' => 'RPT-002', 'pelapor' => 'Sari Dewi', 'pelapor_avatar' => 'https://i.pravatar.cc/150?img=47',
            'terlapor' => 'Alex Chandra', 'terlapor_avatar' => 'https://i.pravatar.cc/150?img=33',
            'order_id' => 'ORD-2401', 'kategori' => 'kualitas_buruk',
            'deskripsi' => 'Hasil landing page jauh dari ekspektasi dan tidak sesuai brief awal.',
            'status' => 'ditinjau', 'tanggal' => '18 Apr 2026',
        ],
        (object)[
            'id' => 'RPT-003', 'pelapor' => 'Reza Maulana', 'pelapor_avatar' => 'https://i.pravatar.cc/150?img=14',
            'terlapor' => 'Siti Aisyah', 'terlapor_avatar' => 'https://i.pravatar.cc/150?img=47',
            'order_id' => 'ORD-2404', 'kategori' => 'penipuan',
            'deskripsi' => 'Freelancer meminta pembayaran di luar platform dan menghilang setelah dibayar.',
            'status' => 'pending', 'tanggal' => '17 Apr 2026',
        ],
        (object)[
            'id' => 'RPT-004', 'pelapor' => 'Maya Indah', 'pelapor_avatar' => 'https://i.pravatar.cc/150?img=23',
            'terlapor' => 'Eko Prasetyo', 'terlapor_avatar' => 'https://i.pravatar.cc/150?img=8',
            'order_id' => null, 'kategori' => 'perilaku_tidak_pantas',
            'deskripsi' => 'Freelancer bersikap tidak sopan dan menggunakan bahasa yang tidak pantas di chat.',
            'status' => 'diselesaikan', 'tanggal' => '15 Apr 2026',
        ],
        (object)[
            'id' => 'RPT-005', 'pelapor' => 'Farhan Rizki', 'pelapor_avatar' => 'https://i.pravatar.cc/150?img=15',
            'terlapor' => 'Nina Kartika', 'terlapor_avatar' => 'https://i.pravatar.cc/150?img=41',
            'order_id' => 'ORD-2399', 'kategori' => 'lainnya',
            'deskripsi' => 'Terjadi miskomunikasi terkait revisi, namun sudah dapat diselesaikan sendiri.',
            'status' => 'ditolak', 'tanggal' => '12 Apr 2026',
        ],
    ];
    $pendingCount = count(array_filter((array)$reports, fn($r) => $r->status === 'pending'));
@endphp

<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Laporan Masuk</h1>
            <p class="text-sm text-gray-500 mt-1">Tinjau dan tangani laporan yang dikirimkan oleh klien.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($pendingCount > 0)
                <span class="bg-red-100 text-red-700 text-xs font-bold px-4 py-2 rounded-lg">
                    🚨 {{ $pendingCount }} Laporan Menunggu
                </span>
            @endif
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-4 py-2 rounded-lg">
                Total: {{ count($reports) }} Laporan
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-yellow-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-yellow-600 mb-1">Menunggu</p>
            <p class="text-3xl font-extrabold text-yellow-600">2</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-blue-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-blue-600 mb-1">Ditinjau</p>
            <p class="text-3xl font-extrabold text-blue-600">1</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-green-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-green-600 mb-1">Diselesaikan</p>
            <p class="text-3xl font-extrabold text-green-600">1</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-gray-500 mb-1">Ditolak</p>
            <p class="text-3xl font-extrabold text-gray-500">1</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <button id="filter-semua" onclick="filterReport('semua')" class="filter-btn px-4 py-2 text-xs font-bold rounded-lg bg-brand-primary text-white transition-all">Semua</button>
        <button id="filter-pending" onclick="filterReport('pending')" class="filter-btn px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Menunggu</button>
        <button id="filter-ditinjau" onclick="filterReport('ditinjau')" class="filter-btn px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Ditinjau</button>
        <button id="filter-diselesaikan" onclick="filterReport('diselesaikan')" class="filter-btn px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Diselesaikan</button>
        <button id="filter-ditolak" onclick="filterReport('ditolak')" class="filter-btn px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Ditolak</button>
    </div>

    {{-- Reports Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" id="reports-table">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Terlapor</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($reports as $report)
                    @php
                        $st = $statusConfig[$report->status];
                        $kt = $kategoriConfig[$report->kategori];
                    @endphp
                    <tr class="report-row hover:bg-gray-50/50 transition-colors {{ $report->status === 'diselesaikan' || $report->status === 'ditolak' ? 'opacity-60' : '' }}"
                        data-status="{{ $report->status }}">
                        <td class="px-6 py-5 font-mono text-xs text-gray-500">{{ $report->id }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <img src="{{ $report->pelapor_avatar }}" class="w-7 h-7 rounded-full">
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">{{ $report->pelapor }}</p>
                                    <p class="text-[10px] text-gray-400">Klien</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <img src="{{ $report->terlapor_avatar }}" class="w-7 h-7 rounded-full">
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">{{ $report->terlapor }}</p>
                                    <p class="text-[10px] text-gray-400">Freelancer</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="{{ $kt['bg'] }} {{ $kt['text'] }} text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider whitespace-nowrap">
                                {{ $kt['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 max-w-xs">
                            <p class="text-xs text-gray-600 line-clamp-2">{{ $report->deskripsi }}</p>
                            @if($report->order_id)
                                <p class="text-[10px] text-gray-400 mt-1 font-mono">Pesanan: #{{ $report->order_id }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <span class="{{ $st['bg'] }} {{ $st['text'] }} text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider whitespace-nowrap">
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-xs text-gray-500 whitespace-nowrap">{{ $report->tanggal }}</td>
                        <td class="px-6 py-5 text-right">
                            @if($report->status === 'pending')
                                <div class="flex justify-end gap-2">
                                    <button onclick="updateStatus('{{ $report->id }}', 'ditinjau')" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors whitespace-nowrap">
                                        Tinjau
                                    </button>
                                    <button onclick="updateStatus('{{ $report->id }}', 'ditolak')" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors whitespace-nowrap">
                                        Tolak
                                    </button>
                                </div>
                            @elseif($report->status === 'ditinjau')
                                <button onclick="updateStatus('{{ $report->id }}', 'diselesaikan')" class="bg-green-50 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-100 transition-colors whitespace-nowrap">
                                    ✓ Selesaikan
                                </button>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Laporan --}}
<div id="report-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-extrabold text-brand-dark">Update Status Laporan</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">✕</button>
        </div>
        <p class="text-sm text-gray-600 mb-4" id="modal-message">Apakah Anda yakin ingin mengubah status laporan ini?</p>
        <div class="mb-4">
            <label class="block text-xs font-bold text-gray-700 mb-2">Catatan Admin (opsional)</label>
            <textarea id="admin-notes" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-brand-primary transition-colors resize-none" placeholder="Tambahkan catatan untuk pelapor..."></textarea>
        </div>
        <div class="flex gap-3">
            <button onclick="closeModal()" class="flex-1 border border-gray-200 text-gray-600 py-3 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">Batal</button>
            <button id="modal-confirm" class="flex-1 bg-brand-primary text-white py-3 rounded-xl text-sm font-bold hover:bg-brand-dark transition-colors">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
function filterReport(status) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-brand-primary', 'text-white');
        btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
    });
    const activeBtn = document.getElementById('filter-' + status);
    if (activeBtn) {
        activeBtn.classList.add('bg-brand-primary', 'text-white');
        activeBtn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
    }
    document.querySelectorAll('.report-row').forEach(row => {
        if (status === 'semua' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

let currentReportId = null;
let currentNewStatus = null;

function updateStatus(reportId, newStatus) {
    currentReportId = reportId;
    currentNewStatus = newStatus;
    const labels = { ditinjau: 'Ditinjau', diselesaikan: 'Diselesaikan', ditolak: 'Ditolak' };
    document.getElementById('modal-message').textContent =
        `Ubah status laporan ${reportId} menjadi "${labels[newStatus]}"?`;
    document.getElementById('report-modal').classList.remove('hidden');
    document.getElementById('report-modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('report-modal').classList.add('hidden');
    document.getElementById('report-modal').classList.remove('flex');
    document.getElementById('admin-notes').value = '';
}

document.getElementById('modal-confirm').addEventListener('click', function() {
    // Simulasi update (nanti diganti dengan AJAX/form submit)
    alert(`Laporan ${currentReportId} berhasil diperbarui ke status: ${currentNewStatus}`);
    closeModal();
    location.reload();
});
</script>
@endsection
