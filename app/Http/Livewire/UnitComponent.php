<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Unit;
use Livewire\WithPagination;

class UnitComponent extends Component
{
   use WithPagination;

    public $data, $title, $selected_id;
    public array $selectedRoles = [];
    public $per_page = 10;
    public $query = '';

    protected $listeners = [
        'rolesChanged',
    ];

    public function render()
    {
        $unit_list = new Unit();

        if ($this->query) {
            $unit_list->where(function($query) {
                $query->where('title','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.unit.index', [
            'list' => $unit_list->orderBy('id', 'desc')->paginate($this->per_page)
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->title = null;
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
            'title' => 'required',
    
        ]);

        $unit = Unit::create([
            'title' => $this->title,
        ]);

        // $unit->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'unit created successfully!']);
    }
    
    public function edit($id)
    {
        $this->hydrate();
        $record = Unit::findOrFail($id);
        $this->selected_id = $id;
        $this->title = $record->title;
        // $this->selectedRoles = optional($record->roles)->pluck('id')->toArray();

        // $this->dispatchBrowserEvent('showPreviousRoles', ['roles' => $this->selectedRoles]);
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'title' => 'required',
        ]);
        if ($this->selected_id) {
            $record = Unit::find($this->selected_id);
            $record->update([
                'title' => $this->title,
            ]);

            // $record->syncRoles($this->selectedRoles);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'unit updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Unit::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'unit deleted successfully!']);
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
