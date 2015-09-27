<?php

namespace App\Http\Controllers\Admin;

use App\Models\Register;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Repositories\Admin\UsersRepository;

class UserController extends Controller
{
    protected $repo;

    public function __construct(UsersRepository $usersdRepository){
        $this->repo = $usersdRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Users
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        if ($status == 'enabled'){
        }
        $users = $this->repo->getUsersOfOrganization($this->user, $status);
//        return $users;
        return view('admin.users.index', compact('users'))->with('error','something');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        return 'edit user';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateTableActions(Request $request)
    {
        $hash = $request->get('user-hash');
        if($request->get('action')== 'delete'){
           $user = User::where('hash', $hash)->first();
           $user_toregister = Register::where('hash', $hash)->first();

            if ($user){
                if ($user->delete()){
                    flash()->success('Συγχαρητήρια', 'ο χρήστης διεγράφη με επιτυχία');
                }else{
                    flash()->error('Προσοχή!', 'ο χρήστης ΔΕΝ διεγράφει');
                }
            }elseif($user_toregister){
                if ($user_toregister->delete()){
                    flash()->success('Συγχαρητήρια', 'ο χρήστης διεγράφη με επιτυχία');
                }else{
                    flash()->error('Προσοχή!', 'ο χρήστης ΔΕΝ διεγράφει');
                }
            }
        }
        return 'true';
    }
}
