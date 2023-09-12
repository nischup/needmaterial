<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class CompanyComponent extends Component
{
    use WithPagination;

    public $data, $name, $selected_id;
    public array $selectedRoles = [];
    public $per_page = 10;
    public $query = '';

    protected $listeners = [
        'rolesChanged',
    ];

    public function render()
    {
        $company_list = new Company();
        // dd($company_list);
        if ($this->query) {
            $company_list->where(function($query) {
                $query->where('name','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.company.index', [
            'list' => $company_list->orderBy('id', 'desc')->paginate($this->per_page),
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
            'name' => 'required',
    
        ]);

        $company = Company::create([
            'name' => $this->name,
        ]);

        // $Company->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Company created successfully!']);
    }
    
    public function edit($id)
    {
        $this->hydrate();
        $record = Company::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        // $this->selectedRoles = optional($record->roles)->pluck('id')->toArray();

        // $this->dispatchBrowserEvent('showPreviousRoles', ['roles' => $this->selectedRoles]);
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required',
        ]);
        if ($this->selected_id) {
            $record = Company::find($this->selected_id);
            $record->update([
                'name' => $this->name,
            ]);

            // $record->syncRoles($this->selectedRoles);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Company updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Company::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Company deleted successfully!']);
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
