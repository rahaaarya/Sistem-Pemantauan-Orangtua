<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Orangtua;
use Yajra\DataTables\DataTables;

class OrangtuaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Orangtua::latest()->get();

            return DataTables::of($data)
                ->addColumn('DT_RowIndex', function ($data) {
                    // Menggunakan DT_RowIndex untuk nomor berurutan
                    return '';
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('admin.orangtua.edit', ['id_orangtua' => $data->id_orangtua]) . '" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                    <button class="btn btn-danger delete-btn" data-id="' . $data->id_orangtua . '" data-toggle="modal" data-target="#modal-hapus"><i class="fas fa-trash-alt"></i> Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Inisialisasi variabel $data jika bukan permintaan Ajax
        $data = Orangtua::latest()->get();
        return view('admin.orangtua', compact('data'));
    }

    public function create()
    {
        // Tampilkan halaman tambah data orang tua
        return view('admin.create_orangtua');
    }

    public function store(Request $request)
    {
        // Validasi data dari request
        $validator = Validator::make($request->all(), [
            // Sesuaikan dengan aturan validasi yang dibutuhkan
        ]);

        // Jika validasi gagal, kembali ke halaman form tambah dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database
        Orangtua::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.orangtua.index')->with('success', 'Data berhasil disimpan!');
    }
    public function edit($id_orangtua)
    {
        // Temukan data orang tua berdasarkan ID
        $orangtua = Orangtua::findOrFail($id_orangtua);

        // Tampilkan halaman edit data orang tua
        return view('admin.edit_orangtua', compact('orangtua'));
    }

    public function update(Request $request, $id_orangtua)
    {
        // Temukan data orang tua berdasarkan ID
        $id_orangtua = Orangtua::findOrFail($id_orangtua);

        // Validasi data dari request
        $validator = Validator::make($request->all(), [
            // Sesuaikan dengan aturan validasi yang dibutuhkan
        ]);

        // Jika validasi gagal, kembali ke halaman form edit dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data orang tua
        $id_orangtua->update($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.orangtua.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id_orangtua)
    {
        // Temukan data orang tua berdasarkan ID
        $id_orangtua = Orangtua::findOrFail($id_orangtua);

        // Hapus data orang tua
        $id_orangtua->delete();

        // Redirect kembali ke halaman index
        return redirect()->route('admin.orangtua.index')->with('success', 'Data berhasil dihapus!');
    }
}
