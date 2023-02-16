<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class LanguagesController extends Controller
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

        $language = Language::all();
            return view('backend.pages.languages.index', compact('language'));   

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
        return view('backend.pages.languages.create', compact('users'));
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

        if($request->hasFile('language_file')) {
            $language_file_name = $request->file('language_file');
            $language_name = time().'.'.$language_file_name->getClientOriginalExtension();
            $destinationPath = public_path('/images/language_file');
            
            $language_file_name->move($destinationPath, $language_name);
            $language_file = $language_name;
        }

        // Validation Data
        $request->validate([
            'language_name' => 'required|max:50',
        ]);

        // Create New Language
        $language = new Language();
        $language->language_name = $request->language_name;
        $language->language_file = $language_file;
        $language->save();

        session()->flash('success', 'Language has been Added !!');
        return redirect()->route('admin.languages.index');
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

        $language = Language::find($id);
        $users =DB::table('admins')
            ->join('model_has_roles', 'admins.id', '=', 'model_has_roles.model_id')
            ->select('admins.id', 'admins.name', 'admins.email', 'model_has_roles.role_id')
            ->where('model_has_roles.role_id', '4')
            ->get();
       // $roles  = Role::all();
        return view('backend.pages.languages.edit', compact('language','users'));
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
        $admin = Language::find($id);

        if($request->hasFile('language_file')) {
            $language_file_name = $request->file('language_file');
            $language_name = time().'.'.$language_file_name->getClientOriginalExtension();
            $destinationPath = public_path('/images/language_file');
            
            $language_file_name->move($destinationPath, $language_name);
            $language_file = $language_name;
        }

        // Validation Data
        $request->validate([
            'language_name' => 'required|max:50',
        ]);

        $admin->language_name = $request->language_name;
        $admin->language_file = $language_file;
        $admin->save();

        session()->flash('success', 'Language has been updated !!');
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
        // if (is_null($this->user) || !$this->user->can('language.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any admin !');
        // }

        $admin = Language::find($id);
        if (!is_null($admin)) {
            $admin->delete();
        }

        session()->flash('success', 'Language has been deleted !!');
        return back();
    }
}