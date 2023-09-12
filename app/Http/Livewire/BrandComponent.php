<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Brand;
use Livewire\WithPagination;

class BrandComponent extends Component
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
        $brand_list = new Brand();
        // dd($brand_list);
        if ($this->query) {
            $brand_list->where(function($query) {
                $query->where('title','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.brand.index', [
            'list' => $brand_list->orderBy('id', 'desc')->paginate($this->per_page)
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

        $brand = brand::create([
            'title' => $this->title,
        ]);

        // $brand->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'brand created successfully!']);
    }
    
    public function edit($id)
    {
        $this->hydrate();
        $record = Brand::findOrFail($id);
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
            $record = Brand::find($this->selected_id);
            $record->update([
                'title' => $this->title,
            ]);

            // $record->syncRoles($this->selectedRoles);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'brand updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Brand::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'brand deleted successfully!']);
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
