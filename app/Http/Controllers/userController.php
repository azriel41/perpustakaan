<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\models;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $model;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new models();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = $this->model->user()->get();
        return view('backend_view.master.user.user_index', compact('data'));
    }
    public function create()
    {
        $previlege = $this->model->previleges()->get();
        return view('backend_view.master.user.user_create', compact('previlege'));
    }
    public function save(Request $req)
    {
        $validasi = $this->validate($req, [
            'name' => 'required',
            'email' => 'required',
            'password' => ['required', 'min:8'],
            'previleges' => 'required',
            'address' => 'required',
            'addressuniv' => 'required',
            'reg' => 'required',
            'tlp' => 'required',
            'username' => 'required',
        ]);

        $id = $this->model->user()->max('id') + 1;
        if ($req->previleges == '1') {
            $this->kodeadm();
        } else if ($req->previleges == '2') {
            $this->kodedsn();
        } else {
            $this->kodemhs();
        }
        if ($validasi == true) {
            $this->model->user()->create([
                'id' => $id,
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'previleges' => $req->previleges,
                'kode' => $kode,
                'address' => $req->address,
                'address_univ' => $req->addressuniv,
                'registration_kode' => $req->reg,
                'tlp' => $req->tlp,
                'username' => $req->username,
                'photo' => 'default.svg',
            ]);
            return Response()->json(['status' => 'sukses']);
        } else {
            return Response()->json(['status' => 'gagal']);
        }
    }
    public function edit(Request $req)
    {
        $data = $this->model->user()->where('id', $req->id)->first();
        $previlege = $this->model->previleges()->get();
        return view('backend_view.master.user.user_edit', compact('data', 'previlege'));
    }
    public function update(Request $req)
    {
        $validasi = $this->validate($req, [
            'name' => 'required',
            'email' => 'required',
            'previleges' => 'required',
            'kode' => 'required',
            'addressuniv' => 'required',
            'address' => 'required',
            'tlp' => 'required',
            'reg' => 'required',
            'username' => 'required',
        ]);

        if ($validasi == true) {
            $this->model->user()->where('id', $req->id)->update([
                'name' => $req->name,
                'email' => $req->email,
                'previleges' => $req->previleges,
                'kode' => $req->kode,
                'address_univ' => $req->addressuniv,
                'address' => $req->address,
                'tlp' => $req->tlp,
                'registration_kode' => $req->reg,
                'username' => $req->username,
            ]);
            return Response()->json(['status' => 'sukses']);
        } else {
            return Response()->json(['status' => 'gagal']);
        }
    }
    public function hapus(Request $req)
    {
        DB::table('users')->where('id', $req->id)->delete();
        return redirect()->back();
    }
    public function perpanjang(Request $req)
    {
        $users = DB::table('users')->where('id', $req->id);
        $userdate = $users->first()->updated_at;
        $newdate = date("Y-m-d H:i:s", strtotime("+4 years", strtotime($userdate)));
        $users->update(['updated_at' => $newdate]);
        return redirect()->back();
    }
    public function profile()
    {
        $data = $this->model->user()->get();
        return view('backend_view.master.user.profile.profile_index', compact('data'));
    }
    public function profileedit(Request $req)
    {
        $data = $this->model->user()->where('id', $req->id)->first();
        return view('backend_view.master.user.profile.profile_edit', compact('data'));
    }
    public function profileupdate(Request $req)
    {
        $validasi = $this->validate($req, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2000',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'tlp' => 'required',
            'reg' => 'required',
            'username' => 'required',
        ]);
        if ($req->hasFile('photo')) {
            $imagePath = $req->file('photo');
            $fileName =  $req->id . '.' . $imagePath->getClientOriginalExtension();
            $imagePath->move(public_path('storage/user'), $fileName);
        }
        if ($validasi == true) {
            $this->model->user()->where('id', $req->id)->update([
                'photo' => $fileName,
                'name' => $req->name,
                'email' => $req->email,
                'address' => $req->address,
                'tlp' => $req->tlp,
                'registration_kode' => $req->reg,
                'username' => $req->username,
            ]);
            return Response()->json(['status' => 'sukses']);
        }
    }
    public function profileprint()
    {
        $date = date("Y-m-d", strtotime("+4 years", strtotime(Auth::user()->updated_at)));
        if (Auth::user()->username == null) {
            return redirect()->route('profile_index')->with(['status' => 'Pastikan sudah mengisi semua data diri']);
        } else {
            $pdf = PDF::loadView('backend_view.master.user.profile.profile_print', ['date' => $date]);
            return $pdf->stream("ID Card " . Auth::user()->name . ".pdf", array("Attachment" => 0));
        }
    }
    public function kodemhs()
    {
        $count = DB::table('users')
            ->select(DB::raw('count(kode)'))
            ->where('kode', 'like', 'MHS%')
            ->first();
        $date = date("ym");
        $newcount = str_pad($count->count + 1, 5, '0', STR_PAD_LEFT);
        $kode = 'MHS/' . $date . "/" . $newcount;
        return $kode;
    }
    public function kodedsn()
    {
        $count = DB::table('users')
            ->select(DB::raw('count(kode)'))
            ->where('kode', 'like', 'DSN%')
            ->first();
        $date = date("ym");
        $newcount = str_pad($count->count + 1, 5, '0', STR_PAD_LEFT);
        $kode = 'DSN/' . $date . "/" . $newcount;
        return $kode;
    }
    public function kodeadm()
    {
        $count = DB::table('users')
            ->select(DB::raw('count(kode)'))
            ->where('kode', 'like', 'ADM%')
            ->first();
        $date = date("ym");
        $newcount = str_pad($count->count + 1, 5, '0', STR_PAD_LEFT);
        $kode = 'ADM/' . $date . "/" . $newcount;
        return $kode;
    }
}
