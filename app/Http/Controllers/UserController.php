<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:edit users', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:create users', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:delete users', ['only' => ['destroy']]);
    //     $this->middleware('permission:show users', ['only' => ['index']]);
    // }

    private $dir = 'dashboard.user.';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view($this->dir . 'index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view($this->dir . 'create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'Successfully created');
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
        $user = User::with('roles')->find($id);
        $roles = Role::all();
        return view($this->dir . 'edit', compact('roles', 'user'));
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
        $request->validate($this->rules(true));

        $user = User::find($id);
        $user->name = $request->name;
        if($user->email != $request->email) {
            $user->email = $request->email;
        }
        if($request->password) {
            $user->password = \Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles([$request->role]);

        return redirect()->route('user.index')->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')->with('success', 'Successfully deleted');
    }

    private function rules($edit = false) {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                !$edit ? 'unique:users,email' : ''
            ],
            'password' => !$edit ? 'required' : '',
            'role' => 'required',
        ];
    }
}
