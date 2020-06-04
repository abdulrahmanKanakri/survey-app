<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:edit roles', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:create roles', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    //     $this->middleware('permission:show roles', ['only' => ['index']]);
    // }

    private $dir = 'dashboard.role.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view($this->dir . 'index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $booksPermissions = Permission::where('name', 'LIKE', '%books%')->get();
        $videosPermissions = Permission::where('name', 'LIKE', '%videos%')->get();
        $articlesPermissions = Permission::where('name', 'LIKE', '%articles%')->get();
        $categoriesPermissions = Permission::where('name', 'LIKE', '%categories%')->get();
        $newsPermissions = Permission::where('name', 'LIKE', '%news%')->get();
        $rolesPermissions = Permission::where('name', 'LIKE', '%roles%')->get();
        $usersPermissions = Permission::where('name', 'LIKE', '%users%')->get();
        $settingsSecPermissions = Permission::where('name', 'LIKE', '%settings%')
                                        ->orWhere('name', 'LIKE', '%sections%')->get();

        $contactsBioPermissions = Permission::where('name', 'LIKE', '%biography%')
                                        ->orWhere('name', 'LIKE', '%contacts%')->get();

        return view($this->dir . 'create', compact(
            'permissions',
            'booksPermissions',
            'videosPermissions',
            'articlesPermissions',
            'categoriesPermissions',
            'newsPermissions',
            'rolesPermissions',
            'usersPermissions',
            'settingsSecPermissions',
            'contactsBioPermissions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('role.index')->with('success', 'Successfully created');
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
        $role = Role::with('permissions')->find($id);    
        $booksPermissions = Permission::where('name', 'LIKE', '%books%')->get();
        $videosPermissions = Permission::where('name', 'LIKE', '%videos%')->get();
        $articlesPermissions = Permission::where('name', 'LIKE', '%articles%')->get();
        $categoriesPermissions = Permission::where('name', 'LIKE', '%categories%')->get();
        $newsPermissions = Permission::where('name', 'LIKE', '%news%')->get();
        $rolesPermissions = Permission::where('name', 'LIKE', '%roles%')->get();
        $usersPermissions = Permission::where('name', 'LIKE', '%users%')->get();
        $settingsSecPermissions = Permission::where('name', 'LIKE', '%settings%')
                                        ->orWhere('name', 'LIKE', '%sections%')->get();

        $contactsBioPermissions = Permission::where('name', 'LIKE', '%biography%')
                                        ->orWhere('name', 'LIKE', '%contacts%')->get();

        return view($this->dir . 'edit', compact(
            'role',
            'permissions',
            'booksPermissions',
            'videosPermissions',
            'articlesPermissions',
            'categoriesPermissions',
            'newsPermissions',
            'rolesPermissions',
            'usersPermissions',
            'settingsSecPermissions',
            'contactsBioPermissions'
        ));
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
        $role = Role::find($id);
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        return redirect()->route('role.index')->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('role.index')->with('success', 'Successfully deleted');
    }
}
