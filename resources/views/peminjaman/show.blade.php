@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Peminjaman #{{ $peminjaman->id }}</h2>

        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">
            Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered align-middle mb-0">
                <tbody>
                    <tr>
                        <th style="width: 30%;">Nama Anggota</th>
                        <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Judul Buku</th>
                        <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <td>
                            {{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>
                            {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status Peminjaman</th>
                        <td>
                            @if($peminjaman->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($peminjaman->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($peminjaman->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ $peminjaman->status ?? 'Belum ada status' }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status Pengembalian</th>
                        <td>
                            @if($peminjaman->status == 'ditolak')
                                -
                            @elseif($peminjaman->status_pengembalian === 'sudah dikembalikan')
                                <span class="badge bg-success">Sudah Dikembalikan</span>
                            @elseif($peminjaman->status == 'disetujui')
                                <span class="badge bg-warning text-dark">Belum Dikembalikan</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @if($peminjaman->status == 'ditolak')
                        <tr>
                            <th>Alasan Penolakan</th>
                            <td>{{ $peminjaman->alasan_penolakan ?? '-' }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Diproses Oleh</th>
                        <td>{{ $peminjaman->pemroses->name ?? '-' }}</td>
                    </tr>
                    @if($peminjaman->status_pengembalian === 'sudah dikembalikan')
                        <tr>
                            <th>Denda</th>
                            <td>Rp{{ number_format($peminjaman->denda ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection