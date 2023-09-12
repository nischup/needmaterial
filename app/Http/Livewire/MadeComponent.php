<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MadeIn;
use Livewire\WithPagination;

class MadeComponent extends Component
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
        $madein_list = new MadeIn();
        // dd($madein_list);
        if ($this->query) {
            $madein_list->where(function($query) {
                $query->where('name','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.made-in.index', [
            'list' => $madein_list->orderBy('id', 'desc')->paginate($this->per_page)
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

    // public function rolesChanged($roles)
    // {
    //     if (!$roles) {
    //         return;
    //     }

    //     $this->selectedRoles = $roles;
    // }

    public function store()
    {
        $this->validate([
            'name' => 'required',
    
        ]);

        $brand = MadeIn::create([
            'name' => $this->name,
        ]);

        // $brand->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Data created successfully!']);
    }
    
    public function edit($id)
    {
        $this->hydrate();
        $record = MadeIn::findOrFail($id);
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
            $record = MadeIn::find($this->selected_id);
            $record->update([
                'name' => $this->name,
            ]);

            // $record->syncRoles($this->selectedRoles);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Data updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = MadeIn::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Data deleted successfully!']);
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
