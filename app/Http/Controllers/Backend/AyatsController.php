<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Ayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AyatsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       

        $ayat = Ayat::all();
            return view('backend.pages.ayats.index', compact('ayat'));   

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $users =DB::table('admins')
            ->join('model_has_roles', 'admins.id', '=', 'model_has_roles.model_id')
            ->select('admins.id', 'admins.name', 'admins.email', 'model_has_roles.role_id')
            ->where('model_has_roles.role_id', '4')
            ->get();
        return view('backend.pages.ayats.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any ayat !');
        }

        // Validation Data
        $request->validate([
            'surat_id' => 'required|max:50',
            'surat_name' => 'required|max:50',
            'ayat_arabic' => 'required|max:500',
            'ayat_english' => 'required|max:500',
        ]);

        // Create New ayat
        $ayat = new Ayat();
        $ayat->surat_id = $request->surat_id;
        $ayat->surat_name = $request->surat_name;
        $ayat->ayat_arabic = $request->ayat_arabic;
        $ayat->ayat_english = $request->ayat_english;
        $ayat->save();

        session()->flash('success', 'Ayat has been Added !!');
        return redirect()->route('admin.ayats.index');
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
    public function edit(int $id)
    {
        // if (is_null($this->user) || !$this->user->can('admin.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        // }

       // $ayat = Ayat::find($id);
        $ayat = DB::table('ayat')
        ->where('ayat_id', $id)
        ->get()
        ->first();
        $users =DB::table('admins')
            ->join('model_has_roles', 'admins.id', '=', 'model_has_roles.model_id')
            ->select('admins.id', 'admins.name', 'admins.email', 'model_has_roles.role_id')
            ->where('model_has_roles.role_id', '4')
            ->get();
       // $roles  = Role::all();
        return view('backend.pages.ayats.edit', compact('ayat','users'));
    }

    // public function view_barcode(int $id) {
    //         print_r($id);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // if (is_null($this->user) || !$this->user->can('ayat.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        // }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.


        // Create New Admin
        $ayat_array = [
            'surat_id' => $request->surat_id,
            'surat_name' => $request->surat_name,
            'ayat_arabic' => $request->ayat_arabic,
            'ayat_english' => $request->ayat_english,
        ];
        DB::table('ayat')
            ->where('ayat_id', $id)
            ->update($ayat_array);

        session()->flash('success', 'ayat has been updated !!');
        return back();
    }
}