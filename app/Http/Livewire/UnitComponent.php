<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Unit;
use Livewire\WithPagination;

class UnitComponent extends Component
{
   use WithPagination;

    public $data, $title_en, $title_ar, $title_ur, $selected_id;
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
                $query->where('title_en','LIKE','%'. $this->query .'%');
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
        $this->title_en = null;
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
            'title_en' => 'required',
    
        ]);

        $unit = Unit::create([
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'title_ur' => $this->title_ur,
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
        $this->title_en = $record->title_en;
        // $this->selectedRoles = optional($record->roles)->pluck('id')->toArray();

        // $this->dispatchBrowserEvent('showPreviousRoles', ['roles' => $this->selectedRoles]);
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'title_en' => 'required',
        ]);
        if ($this->selected_id) {
            $record = Unit::find($this->selected_id);
            $record->update([
                'title_en' => $this->title_en,
                'title_ar' => $this->title_ar,
                'title_ur' => $this->title_ur,
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
