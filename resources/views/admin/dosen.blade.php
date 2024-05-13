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
                    <h1 class="m-0">Dosen</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Dosen</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Data Dosen/h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="index">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIDN</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be inserted by DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                <p>Apakah kamu yakin ingin hapus data dosen <b>{{ $item->nama }}</b></p>
            </div>
            <div class="modal-footer justify-content-between">
                <form action="{{ route('admin.dosen.delete',['id'=>$item->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
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
                url:"{{ route('admin.dosen.index') }}",
                data: function (d) {
                    // Additional data can be added here if needed
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nidn', name: 'nidn' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'no_telepon', name: 'no_telepon' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            createdRow: function (row, data, index) {
                var pageInfo = $('#index').DataTable().page.info();
                var pageNumber = pageInfo.page;
                var pageSize = pageInfo.length;
                $('td', row).eq(0).html(pageNumber * pageSize + index + 1);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var deleteId;
        
        $('.delete-btn').click(function() {
            deleteId = $(this).data('id');
        });
        
        $('#deleteButton').click(function() {
            $.ajax({
                url: '/admin/dosen/' + deleteId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
