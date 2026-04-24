@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

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
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 60px;
        width: 150px; height: 150px;
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
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .5; transform: scale(0.85); }
    }
    .avatar-ring {
        width: 64px; height: 64px;
        border-radius: 20px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; flex-shrink: 0;
        box-shadow: 0 0 30px rgba(99,102,241,0.3);
        transform: rotate(-5deg);
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
    .stat-green::before  { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-indigo::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .stat-amber::before  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; margin-bottom: 14px;
    }
    .stat-green  .stat-icon { background: rgba(16,185,129,0.12); }
    .stat-indigo .stat-icon { background: rgba(99,102,241,0.12); }
    .stat-amber  .stat-icon { background: rgba(245,158,11,0.12); }

    .stat-label {
        font-size: 11px; font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .stat-green  .stat-label { color: #6ee7b7; }
    .stat-indigo .stat-label { color: #a5b4fc; }
    .stat-amber  .stat-label { color: #fcd34d; }

    .stat-value { font-size: 32px; font-weight: 900; color: #fff; letter-spacing: -1.5px; line-height: 1; margin-top: 4px; }
    .stat-sub   { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(148,163,184,0.4); margin-top: 8px; }

    /* CTA */
    .cta-card {
        border-radius: 24px;
        padding: 32px;
        position: relative; overflow: hidden;
        background: linear-gradient(135deg, #4338ca 0%, #6366f1 50%, #7c3aed 100%);
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 20px 40px rgba(67,56,202,0.3);
    }
    .cta-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: #4338ca;
        padding: 12px 28px; border-radius: 16px;
        font-size: 14px; font-weight: 900;
        text-transform: uppercase; letter-spacing: 0.5px;
        text-decoration: none;
        transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .cta-btn:hover { background: #eef2ff; transform: translateY(-2px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }

    /* Fade up animation */
    .fade-up { animation: fadeUp .5s ease both; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .delay-1 { animation-delay: .08s; }
    .delay-2 { animation-delay: .16s; }
    .delay-3 { animation-delay: .24s; }
    .delay-4 { animation-delay: .32s; }
</style>

{{-- Welcome --}}
<div class="welcome-card fade-up">
    <div class="relative z-10 flex items-center justify-between gap-4">
        <div>
            <div class="welcome-badge">
                <div class="welcome-dot"></div>
                <span>Peminjam Aktif</span>
            </div>
            <h1 class="text-xl font-extrabold text-white mb-1 tracking-tight">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-sm" style="color:rgba(165,180,252,0.7)">
                Selamat datang kembali di BOOKBROW Library System
            </p>
        </div>
        <div class="avatar-ring">👨‍🎓</div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-7">
    <div class="stat-card stat-green fade-up delay-1">
        <div class="stat-icon">📗</div>
        <div class="stat-label">Buku Tersedia</div>
        <div class="stat-value">{{ \App\Models\Buku::where('status', 'tersedia')->count() }}</div>
        <div class="stat-sub">Siap dipinjam</div>
    </div>
    <div class="stat-card stat-indigo fade-up delay-2">
        <div class="stat-icon">🔖</div>
        <div class="stat-label">Peminjaman Aktif</div>
        <div class="stat-value">
            {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'disetujui')->count() }}
        </div>
        <div class="stat-sub">Sedang dipinjam</div>
    </div>
    <div class="stat-card stat-amber fade-up delay-3">
        <div class="stat-icon">⏳</div>
        <div class="stat-label">Menunggu Persetujuan</div>
        <div class="stat-value">
            {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'pending')->count() }}
        </div>
        <div class="stat-sub">Dalam antrian</div>
    </div>
</div>

{{-- CTA --}}
<div class="cta-card fade-up delay-4">
    <div class="relative z-10 flex items-center justify-between gap-6">
        <div>
            <h2 class="text-lg font-extrabold text-white mb-2 tracking-tight">Katalog Buku Tersedia</h2>
            <p class="text-sm mb-5 leading-relaxed" style="color:rgba(199,210,254,0.8)">
                Temukan buku yang kamu butuhkan dan ajukan<br>peminjaman dengan mudah &amp; cepat.
            </p>
            <a href="{{ route('peminjam.peminjaman.index') }}" class="cta-btn">
                Lihat Katalog
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="text-6xl shrink-0" style="opacity:0.12">📚</div>
    </div>
</div>
@endsection