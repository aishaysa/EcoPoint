@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <h1 class="h2"><i class="fas fa-user-circle text-success me-2"></i> Profil Saya</h1>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th width="150">Nama</th><td>{{ $user->name }}</td></tr>
                        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                        <tr><th>No HP</th><td>{{ $user->pelanggan->no_hp ?? '-' }}</td></tr>
                        <tr><th>Alamat</th><td>{{ $user->pelanggan->alamat ?? '-' }}</td></tr>
                        <tr><th>Poin</th><td><span class="fw-bold text-success">{{ $user->pelanggan->poin ?? 0 }}</span></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection