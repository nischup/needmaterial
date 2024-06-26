<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Brand;
use Livewire\WithPagination;

class BrandComponent extends Component
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
        $brand_list = new Brand();
        // dd($brand_list);
        if ($this->query) {
            $brand_list->where(function($query) {
                $query->where('title_en','LIKE','%'. $this->query .'%');
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
            'title_en' => 'required',
    
        ]);

        $brand = brand::create([
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'title_ur' => $this->title_ur,
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
        $this->title_en = $record->title_en;
        $this->title_ar = $record->title_ar;
        $this->title_ur = $record->title_ur;
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
            $record = Brand::find($this->selected_id);
            $record->update([
                'title_en' => $this->title_en,
                'title_ar' => $this->title_ar,
                'title_ur' => $this->title_ur,
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
