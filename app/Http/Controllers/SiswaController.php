<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('cari')) {
            $data_siswa = Siswa::where('nama_depan', 'LIKE', '%' . $request->cari . '%')->get();
        } else {
            $data_siswa = Siswa::all();
        }
        return view('siswa.index', compact(['data_siswa']));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'nama_depan' => 'required|min:5',
            'nama_belakang' => 'required',
            'email' => 'required|email|unique:users',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'avatar' => 'mimes:jpg,png'
        ]);
        //insert ke table users
        $user = new User;
        $user->role = 'siswa';
        $user->name = $request->nama_depan;
        $user->email = $request->email;
        $user->password = bcrypt('12345678');
        $user->remember_token = str::random(60);
        $user->save();

        //Insert ke table Siswa
        $request->request->add(['user_id' => $user->id]);
        $siswa = Siswa::create($request->all());
        if ($request->hasFile('avatar')) {
            $request->file('avatar')->move('images/', $request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
        return redirect('/siswa')->with('sukses', 'Data berhasil diinput');
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $siswa = Siswa::find($id);
        $siswa->update($request->all());
        if ($request->hasFile('avatar')) {
            $request->file('avatar')->move('images/', $request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
        return redirect('/siswa')->with('sukses', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete($siswa);
        return redirect('/siswa')->with('sukses', 'Data berhasil dihapus');
    }

    public function profile($id)
    {
        $siswa = Siswa::find($id);
        $matapelajaran = Mapel::all();
        //menyiapkan data untuk chart
        //dd($mapel);
        $categories = [];
        $data = [];
        foreach($matapelajaran as $mp){
            if($siswa->mapel()->wherePivot('mapel_id', $mp->id)->first()){
                $categories[] = $mp->nama;
                $data[] = $siswa->mapel()->wherePivot('mapel_id', $mp->id)->first()->pivot->nilai;
            }
        }
        // dd($data);
        // dd(json_encode($categories));
        return view('siswa.profile', compact(['siswa','matapelajaran','categories', 'data']));
    }

    public function addnilai(Request $request, $idsiswa)
    {
        $siswa = Siswa::find($idsiswa);
        if($siswa->mapel()->where('mapel_id',$request->mapel)->exists()){
            return redirect('siswa/' .$idsiswa. '/profile')->with('error', 'Data mata pelajaran sudah ada.');
        }
        $siswa->mapel()->attach($request->mapel,['nilai' => $request->nilai]);
        return redirect('siswa/'.$idsiswa. '/profile')->with('sukses', 'Data nilai berhasil dimasukan!');
    }

    public function hapus($idsiswa,$idmapel)
    {
        $siswa = Siswa::find($idsiswa);
        $siswa->mapel()->detach($idmapel);
        return redirect()->back()->with('sukses', 'Data nilai berhasil dihapus');
    }
}
