@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    .welcome-card {
        position: relative;
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 32px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15,23,42,0.6);
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
    }
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -50px; left: 80px;
        width: 160px; height: 160px;
        background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(99,102,241,0.15);
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 20px;
        padding: 4px 12px;
        margin-bottom: 10px;
    }
    .welcome-badge span {
        font-size: 11px;
        color: #a5b4fc;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .welcome-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #6366f1;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(0.8)}
    }
    .avatar-ring {
        width: 64px; height: 64px;
        border-radius: 20px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; flex-shrink: 0;
        box-shadow: 0 0 30px rgba(99,102,241,0.3);
        transform: rotate(-5deg);
    }

    /* Section label */
    .section-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: rgba(148,163,184,0.5);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.05);
    }

    /* Stat cards */
    .stat-card {
        border-radius: 24px;
        padding: 24px;
        border: 1px solid rgba(255,255,255,0.08);
        background: rgba(30,41,59,0.4);
        backdrop-filter: blur(12px);
        position: relative;
        overflow: hidden;
        transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover { transform: translateY(-5px); border-color: rgba(99,102,241,0.4); background: rgba(30,41,59,0.6); }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        border-radius: 16px 16px 0 0;
    }
    .sc-slate::before  { background: linear-gradient(90deg,#64748b,#94a3b8); }
    .sc-green::before  { background: linear-gradient(90deg,#10b981,#34d399); }
    .sc-amber::before  { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
    .sc-red::before    { background: linear-gradient(90deg,#ef4444,#f87171); }
    .sc-indigo::before { background: linear-gradient(90deg,#6366f1,#818cf8); }
    .sc-blue::before   { background: linear-gradient(90deg,#3b82f6,#60a5fa); }
    .sc-purple::before { background: linear-gradient(90deg,#8b5cf6,#a78bfa); }
    .sc-teal::before   { background: linear-gradient(90deg,#14b8a6,#2dd4bf); }

    .stat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; margin-bottom: 14px;
    }
    .sc-slate  .stat-icon { background: rgba(100,116,139,0.12); }
    .sc-green  .stat-icon { background: rgba(16,185,129,0.12); }
    .sc-amber  .stat-icon { background: rgba(245,158,11,0.12); }
    .sc-red    .stat-icon { background: rgba(239,68,68,0.12); }
    .sc-indigo .stat-icon { background: rgba(99,102,241,0.12); }
    .sc-blue   .stat-icon { background: rgba(59,130,246,0.12); }
    .sc-purple .stat-icon { background: rgba(139,92,246,0.12); }
    .sc-teal   .stat-icon { background: rgba(20,184,166,0.12); }

    .stat-label { font-size: 11px; font-weight: 500; letter-spacing: 0.4px; margin-bottom: 5px; }
    .sc-slate  .stat-label { color: #94a3b8; }
    .sc-green  .stat-label { color: #6ee7b7; }
    .sc-amber  .stat-label { color: #fcd34d; }
    .sc-red    .stat-label { color: #fca5a5; }
    .sc-indigo .stat-label { color: #a5b4fc; }
    .sc-blue   .stat-label { color: #93c5fd; }
    .sc-purple .stat-label { color: #c4b5fd; }
    .sc-teal   .stat-label { color: #99f6e4; }

    .stat-value { font-size: 32px; font-weight: 900; color: #fff; letter-spacing: -1.5px; line-height: 1; margin-top: 4px; }
    .stat-sub   { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(148,163,184,0.4); margin-top: 8px; }

    /* Quick action cards */
    .action-card {
        border-radius: 24px;
        padding: 32px;
        border: 1px solid rgba(255,255,255,0.07);
        text-decoration: none;
        display: block;
        position: relative;
        overflow: hidden;
        transition: all .4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .action-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,0.4); border-color: rgba(255,255,255,0.2); }
    .ac-slate  { background: linear-gradient(135deg, rgba(30,41,59,0.8), rgba(15,23,42,0.9)); }
    .ac-indigo { background: linear-gradient(135deg, rgba(79,70,229,0.8), rgba(67,56,202,0.9)); }
    .ac-label  { font-size: 18px; font-weight: 900; color: #fff; margin-bottom: 8px; tracking-tight }
    .ac-sub    { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.6; }

    /* Fade up */
    .fade-up { animation: fadeUp .5s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    .d1{animation-delay:.05s} .d2{animation-delay:.10s} .d3{animation-delay:.15s} .d4{animation-delay:.20s}
    .d5{animation-delay:.25s} .d6{animation-delay:.30s} .d7{animation-delay:.35s} .d8{animation-delay:.40s}
</style>

{{-- Welcome --}}
<div class="welcome-card fade-up">
    <div class="relative z-10 flex items-center justify-between gap-4">
        <div>
            <div class="welcome-badge">
                <div class="welcome-dot"></div>
                <span>Administrator</span>
            </div>
            <h1 class="text-xl font-extrabold text-white mb-1 tracking-tight">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-sm" style="color:rgba(165,180,252,0.65)">
                Pantau dan kelola sistem perpustakaan dari sini
            </p>
        </div>
        <div class="avatar-ring">👑</div>
    </div>
</div>

{{-- Statistik Buku --}}
<p class="section-label fade-up d1">📚 Statistik Buku</p>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="stat-card sc-slate fade-up d1">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Total Buku</div>
        <div class="stat-value">{{ \App\Models\Buku::count() }}</div>
        <div class="stat-sub">Seluruh koleksi</div>
    </div>
    <div class="stat-card sc-green fade-up d2">
        <div class="stat-icon">✅</div>
        <div class="stat-label">Tersedia</div>
        <div class="stat-value">{{ \App\Models\Buku::where('status','tersedia')->count() }}</div>
        <div class="stat-sub">Siap dipinjam</div>
    </div>
    <div class="stat-card sc-amber fade-up d3">
        <div class="stat-icon">🔖</div>
        <div class="stat-label">Dipinjam</div>
        <div class="stat-value">{{ \App\Models\Buku::where('status','dipinjam')->count() }}</div>
        <div class="stat-sub">Sedang keluar</div>
    </div>
    <div class="stat-card sc-red fade-up d4">
        <div class="stat-icon">⚠️</div>
        <div class="stat-label">Rusak</div>
        <div class="stat-value">{{ \App\Models\Buku::where('status','rusak')->count() }}</div>
        <div class="stat-sub">Perlu perhatian</div>
    </div>
</div>

{{-- Statistik User --}}
<p class="section-label fade-up d2">👥 Pengguna</p>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="stat-card sc-purple fade-up d3">
        <div class="stat-icon">👮</div>
        <div class="stat-label">Petugas</div>
        <div class="stat-value">{{ \App\Models\User::where('role','petugas')->count() }}</div>
        <div class="stat-sub">Staf aktif</div>
    </div>
    <div class="stat-card sc-teal fade-up d4">
        <div class="stat-icon">👨‍🎓</div>
        <div class="stat-label">Peminjam</div>
        <div class="stat-value">{{ \App\Models\User::where('role','peminjam')->count() }}</div>
        <div class="stat-sub">Anggota terdaftar</div>
    </div>
    <div class="stat-card sc-indigo fade-up d5">
        <div class="stat-icon">👥</div>
        <div class="stat-label">Total User</div>
        <div class="stat-value">{{ \App\Models\User::where('role','!=','admin')->count() }}</div>
        <div class="stat-sub">Semua pengguna</div>
    </div>
</div>

{{-- Statistik Peminjaman --}}
<p class="section-label fade-up d3">📋 Peminjaman</p>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="stat-card sc-slate fade-up d4">
        <div class="stat-icon">📋</div>
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ \App\Models\Peminjaman::count() }}</div>
        <div class="stat-sub">Semua transaksi</div>
    </div>
    <div class="stat-card sc-amber fade-up d5">
        <div class="stat-icon">⏳</div>
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ \App\Models\Peminjaman::where('status','pending')->count() }}</div>
        <div class="stat-sub">Menunggu acc</div>
    </div>
    <div class="stat-card sc-blue fade-up d6">
        <div class="stat-icon">🔓</div>
        <div class="stat-label">Dipinjam</div>
        <div class="stat-value">{{ \App\Models\Peminjaman::where('status','disetujui')->count() }}</div>
        <div class="stat-sub">Sedang aktif</div>
    </div>
    <div class="stat-card sc-green fade-up d7">
        <div class="stat-icon">🎉</div>
        <div class="stat-label">Selesai</div>
        <div class="stat-value">{{ \App\Models\Peminjaman::where('status','selesai')->count() }}</div>
        <div class="stat-sub">Sudah kembali</div>
    </div>
</div>

{{-- Quick Actions --}}
<p class="section-label fade-up d6">⚡ Aksi Cepat</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 fade-up d8">
    <a href="{{ route('admin.buku.index') }}" class="action-card ac-slate">
        <div class="relative z-10">
            <div class="text-2xl mb-3">📚</div>
            <div class="ac-label">Kelola Buku</div>
            <div class="ac-sub">Tambah, edit, dan hapus koleksi buku</div>
        </div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="action-card ac-indigo">
        <div class="relative z-10">
            <div class="text-2xl mb-3">👥</div>
            <div class="ac-label">Kelola User</div>
            <div class="ac-sub">Manajemen pengguna sistem</div>
        </div>
    </a>
</div>

@endsection