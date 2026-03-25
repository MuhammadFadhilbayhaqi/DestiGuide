@extends('layouts.mitra-layout')

@section('title', 'Kelola Wisata')

@section('content')
<div class="container">
    <div class="mitra-page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-gear me-2" style="color:var(--mitra-primary);"></i>Kelola Wisata</h1>
                <p class="page-subtitle">Lihat dan edit semua wisata yang Anda kelola</p>
            </div>
            <a href="{{ route('viewWisata') }}" class="btn-mitra">
                <i class="bi bi-plus-lg"></i> Tambah Wisata
            </a>
        </div>
    </div>

    <div class="mitra-table-wrapper mb-5">
        <table id="myTable" class="table" style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Wisata</th>
                    <th>Jumlah Tiket</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('getaWisata') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'jumlahTiket', name: 'jumlahTiket' },
                {
                    data: null,
                    render: function (data) {
                        return '<a href="' + "{{ route('editWisata', '') }}" + '/' + data.id + '" class="btn-mitra btn-mitra-sm" style="display:inline-flex;text-decoration:none;font-size:0.8rem;padding:0.35rem 0.75rem;"><i class="bi bi-pencil-square me-1"></i> Edit</a>';
                    },
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: "Belum ada wisata terdaftar",
                zeroRecords: "Tidak ditemukan data yang cocok"
            }
        });

        // Handle delete button click
        $('#myTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('updateWisata') }}' + '/' + id + '/delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        console.error('Error:', data);
                    }
                });
            }
        });
    });
</script>
@endpush
