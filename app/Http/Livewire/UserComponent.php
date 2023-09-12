<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserComponent extends Component
{

    use WithPagination;
    public $data, $name, $email, $is_active, $password, $selected_id;
    public array $selectedRoles = [];
    public $per_page = 10;
    public $query = '';

    protected $listeners = [
        'rolesChanged',
    ];
    public function render()
    {
        $users = User::with('roles');

        if ($this->query) {
            $users->where(function($query) {
                $query->where('name','LIKE','%'. $this->query .'%')
                    ->orWhere('email','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.users.index', [
            'list' => $users->latest()->paginate($this->per_page),
            'roles' => Role::get()
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->is_active = null;
        $this->password = null;
        $this->selectedRoles = [];

        $this->dispatchBrowserEvent('clearSelect');
    }

    public function rolesChanged($roles)
    {
        if (!$roles) {
            return;
        }

        $this->selectedRoles = $roles;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
            'is_active' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active ?? 0,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User created successfully!']);
    }



    public function edit($id)
    {
        $this->hydrate();
        $record = User::with('roles')->findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->is_active = $record->is_active;
        $this->selectedRoles = optional($record->roles)->pluck('id')->toArray();

        $this->dispatchBrowserEvent('showPreviousRoles', ['roles' => $this->selectedRoles]);
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required|min:5',
            'email' => 'required|email',
            'is_active' => 'required'
        ]);
        if ($this->selected_id) {
            $record = User::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'email' => $this->email,
                'is_active' => $this->is_active ?? 0
            ]);

            if ($record->is_active == 1) {
                // $this->smsService
                // ->setNumber($record->phone)
                // ->setMessage("You are activated in auction.com")
                // ->send();

                    $url = "https://sms.solutionsclan.com/api/sms/send";
                    $data = [
                        "apiKey"=> "A000362a883636e-a000-4a09-9fd5-39594941d09d",
                        "contactNumbers"=> $record->phone,
                        "senderId"=> "8809612440713",
                        "textBody"=> "Hi ".$record->name." You are activated in auction.com"
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    $response = curl_exec($ch);
                    // echo "$response";
                    curl_close($ch);

            } elseif($record->is_active == 0){
                //   $this->smsService
                // ->setNumber($record->phone)
                // ->setMessage("You are deactivate in auction.com")
                // ->send();

                    $url = "https://sms.solutionsclan.com/api/sms/send";
                    $data = [
                        "apiKey"=> "A000362a883636e-a000-4a09-9fd5-39594941d09d",
                        "contactNumbers"=> $record->phone,
                        "senderId"=> "8809612440713",
                        "textBody"=> "Hi ".$record->name."You are deactivated from auction.com"
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    $response = curl_exec($ch);
                    // echo "$response";
                    curl_close($ch);
            }

            $record->syncRoles($this->selectedRoles);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = User::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User deleted successfully!']);
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function paginationView()
    {
        return 'admin.pagination';
    }
}
