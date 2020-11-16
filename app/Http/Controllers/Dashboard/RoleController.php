<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Requests\RoleRequest;
use App\Repositories\Role\IRoleRepository;

class RoleController extends Controller
{
    private $dir = 'dashboard.role.';
    private $route = 'dashboard.role.';
    private $roleRepo;

    public function __construct(IRoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissions();
    }
    
    private function permissions() {
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepo->getRoles();
        $roles->shift(); // remove the first item which is the admin Role
        return view($this->dir . 'index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->roleRepo->getPermissions();
        return view($this->dir . 'create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->roleRepo->create($request->all());
        return redirect()->route($this->route . 'index')->with('status', [
            'type' => 'success', 
            'msg' => 'Successfully created'
        ]);
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
        $role = $this->roleRepo->getRoleById($id);
        $permissions = $this->roleRepo->getPermissions();
        return view($this->dir . 'edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $this->roleRepo->update($request->all(), $id);
        return redirect()->route($this->route . 'index')->with('status', [
            'type' => 'success', 
            'msg' => 'Successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->roleRepo->delete($id);
        return redirect()->route($this->route . 'index')->with('status', [
            'type' => 'success', 
            'msg' => 'Successfully deleted'
        ]);
    }
}
