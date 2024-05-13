<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Mahasiswa::with('jurusan', 'angkatan');

            // Filter data berdasarkan pencarian
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $searchValue = $request->input('search')['value'];
                $data->where(function ($query) use ($searchValue) {
                    $query->where('nim', 'like', '%' . $searchValue . '%')
                        ->orWhere('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('email', 'like', '%' . $searchValue . '%');
                });
            }

            $data = $data->latest()->get();

            return DataTables::of($data)
                ->addColumn('DT_RowIndex', function ($data) {
                    // Menggunakan DT_RowIndex untuk nomor berurutan
                    return '';
                })
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset('storage/photo-user/' . $data->image) . '"  alt="" width="150">';
                })
                ->addColumn('nim', function ($data) {
                    return $data->nim;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('jurusan', function ($data) {
                    return $data->jurusan->nama_jurusan;
                })
                ->addColumn('angkatan', function ($data) {
                    return $data->angkatan->tahun_angkatan;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('admin.mahasiswa.edit', ['id' => $data->id]) . '" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                    <a class="btn btn-danger delete-btn" data-id="' . $data->id . '" data-toggle="modal" data-target="#modal-hapus' . $data->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        // Inisialisasi variabel $data jika bukan permintaan Ajax
        $data = Mahasiswa::latest()->get();
        return view('admin.index', compact('data', 'request'));
    }







    public function create()
    {
        // Ambil semua data jurusan dari tabel jurusan
        $jurusans = Jurusan::all();
        $angkatans = Angkatan::all();
        return view('admin.create', compact('jurusans', 'angkatans'));
    }

    public function store(Request $request)
    {
        // Validasi data dari request
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048', // Make photo field nullable and allow certain file types and sizes
            'nim' => 'required',
            'name' => 'required',
            'jurusan_id' => 'required',
            'angkatan_id' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email',
        ]);

        // Jika validasi gagal, kembali ke halaman form tambah dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil file foto dari request jika ada
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . $photo->getClientOriginalName();
            $path = 'photo-user/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($photo));
        } else {
            // Jika tidak ada file foto diunggah, set nama file foto ke null
            $filename = null;
        }

        // Simpan data ke database
        $data = [
            'nim' => $request->nim,
            'name' => $request->name,
            'jurusan_id' => $request->jurusan_id,
            'angkatan_id' => $request->angkatan_id,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'image' => $filename, // Gunakan $filename yang sudah ditentukan sebelumnya
        ];

        Mahasiswa::create($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Data berhasil disimpan!');
    }



    public function edit(Request $request, $id)
    {
        // Temukan data mahasiswa berdasarkan ID
        $data = Mahasiswa::find($id);

        // Ambil semua data jurusan dan angkatan dari tabel
        $jurusans = Jurusan::all();
        $angkatans = Angkatan::all();

        // Kirim data ke tampilan
        return view('admin.edit', compact('data', 'jurusans', 'angkatans'));
    }

    public function update(Request $request, $id)
    {
        // Temukan data mahasiswa berdasarkan ID
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Validasi data dari request
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048', // Make photo field nullable for update
            'nim' => 'required', // Remove unique rule for nim field
            'name' => 'required',
            'jurusan_id' => 'required',
            'angkatan_id' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email', // Remove unique rule for email field
        ]);


        // Jika validasi gagal, kembali ke halaman form edit dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data mahasiswa
        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;
        $mahasiswa->jurusan_id = $request->jurusan_id;
        $mahasiswa->angkatan_id = $request->angkatan_id;
        $mahasiswa->no_telepon = $request->no_telepon;
        $mahasiswa->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Data berhasil diperbarui!');
    }


    public function delete(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        if ($mahasiswa) {
            $mahasiswa->delete();
        }
        return redirect()->route('admin.index');
    }
}
