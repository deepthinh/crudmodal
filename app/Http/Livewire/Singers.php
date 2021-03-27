<?php

namespace App\Http\Livewire;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class Singers extends Component
{
    use WithPagination;
    protected $usersdet;
    public $user,$name, $email, $user_id, $password;
    public $updateMode = false;
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $perPage = '10';
    public $search = '';
    public $usertype_id = 0;
    /*public $usertypes = '';*/

    


    public function render()
    {

        $this->fetchSinger();
        $usertypes = DB::table('usertypes')->get();
        return view('livewire.singerslist',['usersdet' => $this->usersdet, 'usertypes' => $usertypes]);
    }

    public function fetchSinger()
    {
        $usersdet = User::join('usertypes','usertypes.id','users.usertypes_id')->select('users.id','users.name','users.email','usertypes.name as usertype')->search($this->search)->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPage);
        $this->usersdet = $usersdet;
    }

    public function sortBy($field){
        if($this->sortDirection == 'asc')
            $this->sortDirection = 'desc';
        else
            $this->sortDirection = 'asc';

        return $this->sortBy = $field;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->usertype_id = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'usertype_id' => 'required'
        ]);

        User::Create([

            'name' => $this->name,

            'email' => $this->email,
            'password' => Hash::make($this->password),
            'usertype_id' => $this->usertype_id

        ]);

        /*User::create($validatedDate);*/

        session()->flash('message', 'Users Created Successfully.');

        $this->resetInputFields();

        $this->updateMode = false;// Close model to using to jquery

    }

    public function create(){
        $this->usertypes = DB::table('usertypes')->get();
        $this->resetInputFields();
        $this->updateMode = true;
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $user = User::where('id',$id)->first();
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->usertype_id = $user->usertypes_id;
        
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'usertype_id' => 'required'
        ]);

        if ($this->user_id) {
            


            User::updateOrCreate(['id' => $this->user_id], [

            'name' => $this->name,

            'email' => $this->email,
            'password' => Hash::make($this->password),
            'usertypes_id' => $this->usertype_id

        ]);

/*$user = User::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);*/
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->resetInputFields();

        }
    }

    public function delete($id)
    {
        if($id){
            User::where('id',$id)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
    }

    
}