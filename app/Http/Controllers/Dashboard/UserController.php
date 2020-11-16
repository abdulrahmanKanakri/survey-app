<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Requests\UserRequest;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\User\IUserRepository;

class UserController extends Controller
{
    private $dir = 'dashboard.user.';
    private $route = 'dashboard.user.';
    private $userRepo;
    private $roleRepo;
    
    public function __construct(
        IUserRepository $userRepo, 
        IRoleRepository $roleRepo
    ) {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->permissions();
    }
    
    private function permissions() {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepo->getUsers(10);
        return view($this->dir . 'index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = User::ROLES;
        return view($this->dir . 'create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->userRepo->create($request->all());
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
        $user = $this->userRepo->getUserById($id);
        $roles = User::ROLES;
        return view($this->dir . 'edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $this->userRepo->update($request->all(), $id);
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
        $this->userRepo->delete($id);
        return redirect()->route($this->route . 'index')->with('status', [
            'type' => 'success', 
            'msg' => 'Successfully deleted'
        ]);
    }
}
