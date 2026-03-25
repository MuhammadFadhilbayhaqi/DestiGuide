@extends('layouts.wisatawan-layout')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mt-4 mb-5">
    <div class="wst-section-header">
        <h2><i class="bi bi-clock-history me-2" style="color:var(--wst-primary);"></i>Riwayat Transaksi</h2>
        <p>Daftar semua pemesanan tiket wisata Anda</p>
    </div>

    @if(count($transactions) > 0)
    <div class="wst-panel">
        <div class="wst-table-wrapper">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Wisata</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Handphone</th>
                        <th>Email</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($transaction->wisata)
                                <strong>{{ $transaction->wisata->nama }}</strong>
                            @else
                                <span style="color:var(--wst-text-light);">-</span>
                            @endif
                        </td>
                        <td>{{ $transaction->tanggal }}</td>
                        <td>{{ $transaction->nama_lengkap }}</td>
                        <td>{{ $transaction->nomor_handphone }}</td>
                        <td>{{ $transaction->email }}</td>
                        <td>
                            <span class="badge" style="background:var(--wst-primary-light);color:var(--wst-primary-dark);font-size:0.8rem;">
                                {{ $transaction->metode_pembayaran }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="wst-panel">
        <div class="wst-empty-state">
            <div class="empty-icon"><i class="bi bi-receipt"></i></div>
            <h3>Belum ada transaksi</h3>
            <p style="margin-bottom:1.5rem;">Anda belum pernah memesan tiket wisata.</p>
            <a href="{{ route('dashboard') }}" class="btn-wst">
                <i class="bi bi-compass"></i> Jelajahi Wisata
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
