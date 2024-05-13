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
                    <h1 class="m-0">Data Orang Tua</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Orang Tua</li>
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
                    <!-- Tombol untuk menambah data orang tua -->
                    <a href="{{ route('admin.orangtua.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Orang Tua</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="orangtua">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ayah</th>
                                        <th>Nama Ibu</th>
                                        <th>Pekerjaan Ayah</th>
                                        <th>Pekerjaan Ibu</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Hubungan</th>
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
<div class="modal fade" id="modal-hapus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah kamu yakin ingin hapus data orang tua ini? </p>
            </div>
            <div class="modal-footer justify-content-between">
                <form id="deleteForm" method="POST">
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

@endsection

@section('script')
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready(function(){
        $('#orangtua').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                url:"{{ route('admin.orangtua.index') }}",
                data: function (d) {
                    // Tambahan data dapat dimasukkan di sini jika diperlukan
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama_ayah', name: 'nama_ayah' },
                { data: 'nama_ibu', name: 'nama_ibu' },
                { data: 'pekerjaan_ayah', name: 'pekerjaan_ayah' },
                { data: 'pekerjaan_ibu', name: 'pekerjaan_ibu' },
                { data: 'email', name: 'email' },
                { data: 'no_telepon', name: 'no_telepon' },
                { data: 'hubungan', name: 'hubungan' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            // Set nomor urutan
            createdRow: function (row, data, index) {
                var pageInfo = $('#orangtua').DataTable().page.info(); // Informasi halaman DataTables
                var pageNumber = pageInfo.page; // Nomor halaman saat ini
                var pageSize = pageInfo.length; // Jumlah baris per halaman
                $('td', row).eq(0).html(pageNumber * pageSize + index + 1);
            }
        });

        // Mengatur ID data yang akan dihapus
        var deleteId;
        $('#modal-hapus').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            deleteId = button.data('id');
        });

        // Submit form untuk menghapus data
        $('#deleteForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.orangtua.delete', 'id_orangtua') }}".replace('id_orangtua', deleteId),
                type: 'DELETE',
                data: $(this).serialize(),
                success: function(data){
                    // Refresh halaman setelah penghapusan data
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
