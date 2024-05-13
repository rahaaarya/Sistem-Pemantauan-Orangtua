@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mahasiswa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Responsive Hover Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="index">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Angkatan</th>
                                        <th>No Telepon</th>
                                        <th>Email</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimasukkan oleh DataTables -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
@foreach($data as $item)
<div class="modal fade" id="modal-hapus{{ $item->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah kamu yakin ingin hapus data mahasiswa <b>{{ $item->name }}</b></p>
            </div>
            <div class="modal-footer justify-content-between">
                <form action="{{ route('admin.mahasiswa.delete',['id'=>$item->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endforeach

@endsection

@section('script')
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready(function(){
        $('#index').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                url:"{{ route('admin.index') }}",
                data: function (d) {
                    // Tambahan data dapat dimasukkan di sini jika diperlukan
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nim', name: 'nim' },
                { data: 'name', name: 'name' },
                { data: 'jurusan', name: 'jurusan' },
                { data: 'angkatan', name: 'angkatan' },
                { data: 'no_telepon', name: 'no_telepon' },
                { data: 'email', name: 'email' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            // Set nomor urutan
            createdRow: function (row, data, index) {
                var pageInfo = $('#index').DataTable().page.info(); // Informasi halaman DataTables
                var pageNumber = pageInfo.page; // Nomor halaman saat ini
                var pageSize = pageInfo.length; // Jumlah baris per halaman
                $('td', row).eq(0).html(pageNumber * pageSize + index + 1); // Hitung nomor urutan
            }
        });
    });
</script>

<!-- Tidak diperlukan jika tidak menggunakan DataTables -->
<script>
    $(document).ready(function() {
        var deleteId;
        
        $('.delete-btn').click(function() {
            deleteId = $(this).data('id');
        });
        
        $('#deleteButton').click(function() {
            $.ajax({
                url: '/admin/mahasiswa/' + deleteId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    // Redirect or reload the page
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
