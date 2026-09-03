@extends('layouts.user')

@section('title', 'Poin Saya')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <div class="display-1 text-warning">
            <i class="fas fa-coins"></i>
        </div>
        <h1 class="display-4 fw-bold text-success">{{ $poin }}</h1>
        <p class="text-secondary">Total Poin Anda</p>
        <a href="{{ route('user.transaksi.create') }}" class="btn btn-primary btn-lg mt-3">
            <i class="fas fa-exchange-alt me-2"></i> Tukar Poin
        </a>
        <a href="{{ route('user.setoran') }}" class="btn btn-outline-secondary btn-lg mt-3 ms-2">
            <i class="fas fa-recycle me-2"></i> Lihat Setoran
        </a>
    </div>
</div>
@endsection