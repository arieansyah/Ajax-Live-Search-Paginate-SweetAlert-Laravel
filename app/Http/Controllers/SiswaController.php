<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Response;
use Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::paginate(10);
        return view('index', compact('data'));
    }

    // public function findPage()
    // {
    //   return Siswa::paginate(10);
    // }
    //
    // public function pagenation()
    // {
    //   $data = $this->findPage();
    //   return view('index', compact('data'));
    // }
    //
    // public function siswaPagenation()
    // {
    //   $data = $this->findPage();
    //   return view('index', compact('data'))->render();
    // }


    public function lesSearch(Request $req)
    {
      if ($req->ajax()) {
        $guru = $this->data($req->search);
        $search = $req->search;
        $view = view('getList', compact('guru', 'search'))->render();
        return response($view);
      }
    }

    public function data($search)
    {
      return $data = Siswa::where('nama_siswa', 'like', '%'.$search.'%')
        ->orWhere('nisn', 'like', '%'.$search.'%')
        ->orderBy('id_siswa', 'asc')
        ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $cek = Siswa::where('nisn', $request->nisn)->count();
      if ($cek > 0) {
          echo json_encode(array('msg'=>'error'));
      }else {
        $siswa = new Siswa;
        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama;
        $siswa->save();
        echo json_encode(array('msg'=>'success'));
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Siswa::find($id);
        echo json_encode($edit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        $cek = Siswa::where('nisn', $request->nisn)->count();
        if ($request->nisn == $siswa->nisn && $cek <= 1) {
          $siswa->nisn = $request->nisn;
          $siswa->nama_siswa = $request->nama;
          $siswa->update();
          echo json_encode(array('msg'=>'success'));
        }
        else {
          echo json_encode(array('msg'=>'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Siswa::find($id);
        $delete->delete();
    }
}
