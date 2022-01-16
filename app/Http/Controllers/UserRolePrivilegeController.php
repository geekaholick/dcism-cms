<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;
use App\Models\PrivilegeLevelInfo;
use App\Models\UserPrivileges;

class UserRolePrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::join('roles','users.role_id', '=','roles.role_id')
                    ->select('user_id','last_name','first_name','type')
                    ->orderBy('last_name','ASC')
                    ->get();
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
     * @param  int  $id
     * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id ,$id2)
    {
        //
        $newPrivilege = new UserPrivileges;
        $newPrivilege->user_id = $id;
        $newPrivilege->privilege_id = $id2;
        $newPrivilege->save();

        return $newPrivilege;
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
        $user = User::join('roles','users.role_id', '=','roles.role_id')
                    ->select('user_id','last_name','first_name','type')
                    ->where('user_id','=',$id)
                    ->orderBy('last_name','ASC')
                    ->get();
        $array = [
            'user' => $user,
            'id'   => $id
        ];

        return $array;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show2($id)
    {
        $userPrivilege = UserPrivileges::join('privilege_level_infos','user_privileges.privilege_id','=','privilege_level_infos.privilege_id')
                                        ->where('user_id','=',$id)
                                        ->get();
        
        // $privilegeID = array();
        
        // foreach($userPrivilege as $x){
        //     $privilegeID[]=$x->privilege_id;
        // }

        // $privilegeInfo = PrivilegeLevelInfo::whereNotIn('privilege_id', $privilegeID)
        //                                     ->select('privilege_id','permission')
        //                                     ->get();

        $array = [
            'userPrivilege' => $userPrivilege,
            'id'   => $id
        ];
        
        return $array;

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id2)
    {
        //
        $currentRole = User::find($id2);
        $currentRole->role_id = $id;
        $currentRole->save();
        return "finish";


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $existingPrivilege = UserPrivileges::find($id);

        if( $existingPrivilege ) {
            $existingPrivilege->delete();
            return "Deleted";
        }
        return "Role not found";
    }
}
