<?php

namespace App\Http\Livewire;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;

class Stafflist extends Component
{
	use WithPagination;
	protected $staff;
	public $sortBy = 'created_at';
	public $sortDirection = 'desc';
	public $perPage = '10';
	public $search = '';

	public $editModal = false;
	public $deleteModal = false;

	public $editingStaff;
	public $deletingStaffId;

	public $users, $name, $email, $user_id;

    public $updateMode = false;



    public function render()
    {
    	$this->fetchStaff();

        return view('livewire.stafflist',['item' => $this->staff]);
    }

    public function fetchStaff()
    {
    	$staff = User::query()->search($this->search)->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPage);
    	$this->staff = $staff;
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

    public function editStaff($staff)
    {
    	$this->editingStaff = $staff;
    	$this->editModal = true;
    }

    public function createStaff()
    {
    	$this->editModal = true;
    }

    public function saveStaff()
    {
    	$validated = $this->validate([
    		'editingStaff.name' => 'required',
    		'editingStaff.email' => 'required',
    	]);

    	if(!empty($this->editingStaff['id'])) {
    		$staff = User::find($this->editingStaff['id']);
    		$staff->update($validated['editingStaff']);
    	}
    	else{
    		User::Create($validated['editingStaff']);
    	}

    	$this->fetchStaff();
    	$this->closeModal();
    }

    public function closeModal(){
    	$this->editModal = $this->deleteModal = false;
    }

    public function confirmDelete($staffid)
    {
    	$this->deleteModal = true;
    	$this->deletingStaffId = $staffid;
    }

    public function deleteProduct()
    {
    	if(!empty($this->deletingStaffId))
    	{
    		User::destroy($this->deletingStaffId);
    	}

    	$this->deletingStaffId = null;

    	$this->fetchStaff();
    	$this->closeModal();

    }



    private function resetInputFields(){

        $this->name = '';

        $this->email = '';

    }


    public function store()

    {

        $validatedDate = $this->validate([

            'name' => 'required',

            'email' => 'required|email',

        ]);


        User::create($validatedDate);


        session()->flash('message', 'Users Created Successfully.');


        $this->resetInputFields();


        $this->emit('userStore'); // Close model to using to jquery


    }


    public function edit($id)

    {

        $this->updateMode = true;

        $user = User::where('id',$id)->first();

        $this->user_id = $id;

        $this->name = $user->name;

        $this->email = $user->email;

        

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

        ]);


        if ($this->user_id) {

            $user = User::find($this->user_id);

            $user->update([

                'name' => $this->name,

                'email' => $this->email,

            ]);

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
