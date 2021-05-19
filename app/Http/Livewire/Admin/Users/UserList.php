<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

use WithPagination;

class UserList extends Component
{
    // Using $state instead of creating multiple properties
    public $state = [];

    public $user;

    public $userIdBeingRemoved = null;

    protected $paginationTheme = 'bootstrap';

    
    // this will help to toggle the modal of create and edit form
	public $showEditModal = false;

    public function addNew()
	{
        // this will reset the inputs in the modal
        $this->reset();

		$this->showEditModal = false;

        // To fire the event using livewire.. event name is show-form. this will display maodal
		$this->dispatchBrowserEvent('show-form');
	}

    public function createUser()
	{

       
        
		$validatedData = Validator::make($this->state, [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required',
		])->validate();
        

		$validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        // to hide form
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User added successfully!']);

	}

    public function edit(User $user)
	{
        $this->reset();

        $this->showEditModal = true;
        // dd($this->showEditModal);
        
		$this->user = $user;

        // this will grab the partical user data and spit it out to the form
		$this->state = $user->toArray();

        // Dispatching the browser event to show form
		$this->dispatchBrowserEvent('show-form');
	}

    public function updateUser() {

        $validatedData = Validator::make($this->state, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$this->user->id,
			'password' => 'sometimes|confirmed',
		])->validate();

        if(!empty($validatedData['password'])) {
			$validatedData['password'] = bcrypt($validatedData['password']);
		}

		$this->user->update($validatedData);

		$this->dispatchBrowserEvent('hide-form', ['message' => 'User updated successfully!']);
    }

    public function confirmUserRemoval($userId)
	{
        // dd($userId);
        // Saving the userId to a public property
		$this->userIdBeingRemoved = $userId;

        // dispatching d Browser Event for delete modal
		$this->dispatchBrowserEvent('show-delete-modal');
	}

    public function deleteUser()
	{
        $user = User::findOrFail($this->userIdBeingRemoved);

		$user->delete();

		$this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User deleted successfully!']);
	}


    public function render()
    {
        $users = User::latest()->paginate();
        return view('livewire.admin.users.user-list', [
            'users' => $users,
        ]);
    }
}
