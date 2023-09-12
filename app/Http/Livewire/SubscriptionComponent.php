<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use Livewire\WithPagination;

class SubscriptionComponent extends Component
{
use WithPagination;

    public $data, $name, $user_type, $buying_service_type, $selling_service_type, $quot_service_type, $advertising_service_type,$no_of_buy_req, $no_of_sell_req, $no_of_quot_req, $no_of_adver_req, $no_of_month, $fees, $selected_id;
    public array $selectedRoles = [];
    public $per_page = 10;
    public $query = '';

    protected $listeners = [
        'rolesChanged',
    ];

    public function render()
    {
        $brand_list = new Subscription();
        // dd($brand_list);
        if ($this->query) {
            $brand_list->where(function($query) {
                $query->where('title','LIKE','%'. $this->query .'%');
            });
        }

        return view('admin.livewire.subscription.index', [
            'list' => $brand_list->orderBy('id', 'desc')->paginate($this->per_page)
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name = null;
        $this->user_type = null;
        $this->buying_service_type = null;
        $this->selling_service_type = null;
        $this->quot_service_type = null;
        $this->advertising_service_type = null;
        $this->no_of_buy_req = null;
        $this->no_of_sell_req = null;
        $this->no_of_quot_req = null;
        $this->no_of_adver_req = null;
        $this->no_of_month = null;
        $this->fees = null;
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
            'no_of_month' => 'required',
            'fees' => 'required',
    
        ]);

        $brand = Subscription::create([
                'name' => $this->name,
                'user_type' => $this->user_type,
                'buying_service_type' => "BUYING",
                'selling_service_type' => "SELLING",
                'quot_service_type' => "QUOTATION",
                'advertising_service_type' => $this->advertising_service_type,
                'no_of_buy_req' => $this->no_of_buy_req,
                'no_of_sell_req' => $this->no_of_sell_req,
                'no_of_quot_req' => $this->no_of_quot_req,
                'no_of_adver_req' => $this->no_of_adver_req,
                'no_of_month' => $this->no_of_month,
                'fees' => $this->fees,
        ]);

        // $brand->syncRoles($this->selectedRoles);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Subscription created successfully!']);
    }
    
    public function edit($id)
    {
        $this->hydrate();
        $record = Subscription::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->user_type = $record->user_type;
        $this->buying_service_type = $record->buying_service_type;
        $this->selling_service_type = $record->selling_service_type;
        $this->quot_service_type = $record->quot_service_type;
        $this->advertising_service_type = $record->advertising_service_type;
        $this->no_of_buy_req = $record->no_of_buy_req;
        $this->no_of_sell_req = $record->no_of_sell_req;
        $this->no_of_quot_req = $record->no_of_quot_req;
        $this->no_of_adver_req = $record->no_of_adver_req;
        $this->no_of_month = $record->no_of_month;
        $this->fees = $record->fees;
        // $this->selectedRoles = optional($record->roles)->pluck('id')->toArray();

        // $this->dispatchBrowserEvent('showPreviousRoles', ['roles' => $this->selectedRoles]);
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required',
            'no_of_month' => 'required',
            'fees' => 'required',
        ]);
        if ($this->selected_id) {
            $record = Subscription::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'user_type' => $this->user_type,
                'buying_service_type' => "BUYING",
                'selling_service_type' => "SELLING",
                'quot_service_type' => "QUOTATION",
                'advertising_service_type' => $this->advertising_service_type,
                'no_of_buy_req' => $this->no_of_buy_req,
                'no_of_sell_req' => $this->no_of_sell_req,
                'no_of_quot_req' => $this->no_of_quot_req,
                'no_of_adver_req' => $this->no_of_adver_req,
                'no_of_month' => $this->no_of_month,
                'fees' => $this->fees,
            ]);

            // $record->syncRoles($this->selectedRoles);

            $this->resetInput();
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Subscription updated successfully!']);
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Subscription::where('id', $id);
            $record->delete();
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Subscription deleted successfully!']);
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
