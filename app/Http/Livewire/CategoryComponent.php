<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;

    public $selected_id, $data, $name_en, $name_ur, $name_ar, $categories, $p_category;

    public $per_page = 10, $type = 0;
    public $query = '';

    protected $listeners = [
        'categoryChanged',
    ];

    public function render()
    {
        $category_list = Category::with('categories', 'parent')->orderBy('id', 'DESC');

        if ($this->type) {
            if ($this->type == 1) {
                $category_list->where('parent_id', 0);
            } else {
                $category_list->where('parent_id','!=', 0);
            }
        }

        if ($this->query) {
            $category_list->where(function($query) {
                $query->where(function ($q) {
                    $q->where('name_en','LIKE','%'. $this->query .'%')
                        ->orWhere('name_ar','LIKE','%'. $this->query .'%')
                        ->orWhere('name_ur','LIKE','%'. $this->query .'%');
                });
            });
        }

        return view('admin.livewire.category.index', [
            'list' => $category_list->paginate($this->per_page)
        ]);
    }

    public function mount()
    {
        $this->category_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('categories', $this->category_column))
        {
            $this->category_column = 'name_en';
        }

        $this->categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', 0)->get()->toArray();

    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name_en = null;
        $this->name_ar = null;
        $this->name_ur = null;

        $this->dispatchBrowserEvent('clearSelect');
    }

    public function store()
    {
        $this->validate([
            'p_category' => 'nullable',
            'name_en' => 'required|unique:categories',
        ]);

        Category::create([
            'slug' => Str::slug($this->name_en),
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'name_ur' => $this->name_ur,
            'parent_id' => $this->p_category ?? 0,
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Category created successfully!']);
    }

    public function edit($id)
    {
        $record = Category::findOrFail($id);

        $this->selected_id = $id;
        $this->name_en = $record->name_en;
        $this->name_ar = $record->name_ar;
        $this->name_ur = $record->name_ur;
        $this->p_category = $record->parent_id;
    }

    public function update()
    {
        $this->validate([
            'p_category' => 'nullable|numeric',
            'name_en' => 'required|unique:categories,name_en,'.$this->selected_id,
        ]);
        if ($this->selected_id) {
            $record = Category::find($this->selected_id);
            $record->update([
                'slug' => Str::slug($this->name_en),
                'name_en' => $this->name_en,
                'name_ar' => $this->name_ar,
                'name_ur' => $this->name_ur,
                'parent_id' => $this->p_category ?? 0,
            ]);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Category updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Category::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Category deleted successfully!']);
    }

    public function paginationView()
    {
        return 'admin.pagination';
    }
}
