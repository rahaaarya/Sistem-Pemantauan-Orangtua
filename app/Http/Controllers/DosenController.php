<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Dosen::latest()->get();

            return DataTables::of($data)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '';
                })
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset('storage/photo-dosen/' . $data->image) . '" alt="" width="150">';
                })
                ->addColumn('nidn', function ($data) {
                    return $data->nidn;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('no_telepon', function ($data) {
                    return $data->no_telepon;
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('admin.dosen.edit', ['id' => $data->id]) . '" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                    <a class="btn btn-danger delete-btn" data-id="' . $data->id . '" data-toggle="modal" data-target="#modal-hapus' . $data->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        $data = Dosen::latest()->get();
        return view('admin.dosen', compact('data', 'request'));
    }

    public function create()
    {
        return view('admin.create_dosen');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'nidn' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . $photo->getClientOriginalName();
            $path = 'photo-dosen/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($photo));
        } else {
            $filename = null;
        }

        $data = [
            'image' => $filename,
            'nidn' => $request->nidn,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ];

        Dosen::create($data);

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = Dosen::find($id);
        return view('admin.edit_dosen', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'nidn' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . $photo->getClientOriginalName();
            $path = 'photo-dosen/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($photo));
        } else {
            $filename = $dosen->image;
        }

        $dosen->update([
            'image' => $filename,
            'nidn' => $request->nidn,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function delete($id)
    {
        $dosen = Dosen::findOrFail($id);
        if ($dosen) {
            $dosen->delete();
        }
        return redirect()->route('admin.dosen.index');
    }
}
