<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PageContent;
use Livewire\WithPagination;

class PageContentComponent extends Component
{

    use WithPagination;

    public $data, $page_name_id, $page_details_en, $page_details_ar, $page_details_ur, $selected_id;
    public array $selectedRoles = [];
    public $per_page = 10;
    public $query = '';

    protected $listeners = [
        'rolesChanged',
    ];

    public function render()
    {
        $page_list = new PageContent();
        // dd($page_list);
        if ($this->query) {
            $page_list->where(function($query) {
                $query->where('name','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.page-content-component.index', [
            'list' => $page_list->orderBy('id', 'desc')->paginate($this->per_page)
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->page_name_id = null;
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
            'page_name_id' => 'required',
            'page_details_en' => 'required',
    
        ]);

        $brand = PageContent::create([
            'page_name_id' => $this->page_name_id,
            'page_details_en' => $this->page_details_en,
            'page_details_ur' => $this->page_details_ur,
            'page_details_ar' => $this->page_details_ar,
        ]);

        // $brand->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Data created successfully!']);
    }
    
    public function edit($id)
    {
        $this->hydrate();
        $record = PageContent::findOrFail($id);
        $this->selected_id = $id;
        $this->page_name_id = $record->page_name_id;
        $this->page_details_en = $record->page_details_en;
        $this->page_details_ur = $record->page_details_ur;
        $this->page_details_ar = $record->page_details_ar;
        // $this->selectedRoles = optional($record->roles)->pluck('id')->toArray();

        // $this->dispatchBrowserEvent('showPreviousRoles', ['roles' => $this->selectedRoles]);
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'page_name_id' => 'required',
        ]);
        if ($this->selected_id) {
            $record = PageContent::find($this->selected_id);
            $record->update([
                'page_name_id' => $this->page_name_id,
                'page_details_en' => $this->page_details_en,
                'page_details_ar' => $this->page_details_ar,
                'page_details_ur' => $this->page_details_ur,
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
            $record = PageContent::where('id', $id);
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
