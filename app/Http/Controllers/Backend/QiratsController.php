<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Qirat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class QiratsController extends Controller
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

        $qirat = Qirat::all();
            return view('backend.pages.qirats.index', compact('qirat'));   

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
        return view('backend.pages.qirats.create', compact('users'));
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
            abort(403, 'Sorry !! You are Unauthorized to create any language !');
        }

         // Validation Data
         $request->validate([
            'qari_name' => 'required|max:50',
            'qari_audio' => 'required|max:50',
        ]);

        // Create New Language
        $qirat = new Surat();
        $qirat->qari_name = $request->qari_name;
        $qirat->qari_audio = $request->qari_audio;
        $qirat->save();

        session()->flash('success', 'Qirat has been Added !!');
        return redirect()->route('admin.qirats.index');
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
       // $qirat = Qirat::find($id);
       $qirat = DB::table('qirat')
       ->where('qari_id', $id)
       ->get()
       ->first();
    $users =DB::table('admins')
       ->join('model_has_roles', 'admins.id', '=', 'model_has_roles.model_id')
       ->select('admins.id', 'admins.name', 'admins.email', 'model_has_roles.role_id')
       ->where('model_has_roles.role_id', '4')
       ->get();
   return view('backend.pages.qirats.edit', compact('qirat','users'));
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
        // if (is_null($this->user) || !$this->user->can('language.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        // }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.


        // Create New Admin
        $qirat_array = [
            'qari_name' => $request->qari_name,
            'qari_audio' => $request->qari_audio
        ];
        DB::table('qirat')
            ->where('qari_id', $id)
            ->update($qirat_array);
        
        session()->flash('success', 'Qirat has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

    }
}