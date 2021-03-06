<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends UserRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);
        // $currentUser->can();

        if ($currentUser->can('checkAdmin', User::class)) {
            $users = User::select('users.*')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.id', '<>', Auth::user()->id)
                ->whereIn('roles.name', ['admin', 'manager'])
                ->latest('users.created_at')->get();

            $usersWithTrashed = User::onlyTrashed()
                ->select('users.*')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->whereIn('roles.name', ['admin', 'manager'])
                ->latest('users.created_at')->get();

            return view('admin.user.index', [
                'users' => $users,
                'usersWithTrashed' => $usersWithTrashed,
            ]);
        } else {
            return redirect()->route('admin.errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('checkAdmin', User::class)) {
            $roles = Role::whereNotIn('roles.name', ['teacher', 'user'])
                ->latest()->get();
            return view('admin.user.create', [
                'roles' => $roles
            ]);
        } else {
            return redirect()->route('admin.errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('checkAdmin', User::class)) {

            $data = $request->all();
            $data['password'] = Hash::make($request->input('password'));

            // if ($this->createModel($data)) {
            if ($this->createModelByEloquent($data)) {
                return response()->json(['mess' => 'Th??m b???n ghi th??nh c??ng', 200]);
            } else {
                return response()->json(['mess' => 'Th??m b???n ghi l???i'], 502);
            }
        } else {
            return response()->json(['mess' => 'Th??m b???n ghi l???i'], 403);
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
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('checkAdmin', User::class)) {
            $user = DB::table('users')
                ->select(['users.name', 'users.identity_code', 'users.email', 'users.created_at', 'roles.name as role'])
                ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.id', '=', $id)
                ->get()->first();

            if (empty($user)) {
                return response()->json(['mess' => 'Ba??n ghi kh??ng t????n ta??i'], 404);
            } else {
                return response()->json(['user' => $user], 200);
            }
        } else {
            return response()->json(['mess' => 'Th??m b???n ghi l???i'], 403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('checkAdmin', User::class)) {
            $user = User::findOrFail($id);

            $roles = Role::whereNotIn('roles.name', ['teacher', 'user'])
                ->latest()->get();
            return view('admin.user.edit', [
                'user' => $user,
                'roles' => $roles,
            ]);
        } else {
            return redirect()->route('admin.errors.403');
        }
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
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('checkAdmin', User::class)) {

            $data = $request->all();

            if (!empty($request->input('password'))) {
                $data['password'] = Hash::make($request->input('password'));
            }

            if ($this->updateModel($id, $data)) {
                return response()->json(['mess' => 'S???a b???n ghi th??nh c??ng', 200]);
            } else {
                return response()->json(['mess' => 'S???a b???n ghi l???i'], 502);
            }
        } else {
            return response()->json(['mess' => 'S???a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
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
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('forceDelete', User::class)) {

            if ($this->deleteModel($id)) {
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('forceDelete', User::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('restore', User::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Kh??i ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Kh??i ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'Kh??i ph???c b???n ghi l???i'], 403);
        }
    }
}
