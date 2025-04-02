<?php

namespace App\Http\Controllers\Management;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Order\OrderInterface;
use App\Services\Order\OrderServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class KitchenController extends Controller
{
    /**
     * @param  protected
     */
    public function __construct(protected OrderInterface $orderInterface) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('searchParam', 'sortBy', 'sortDirection', 'rowPerPage', 'page');
        $filters['sortBy'] = $filters['sortBy'] ?? 'queue_order';
        $filters['sortDirection'] = $filters['sortDirection'] ?? 'asc';
        $filters['rowPerPage'] = $filters['rowPerPage'] ?? 10;
        $filters['status'] = $filters['status'] ?? OrderStatusEnum::InProgress->value;
        return Inertia::render('Management/Kitchen/All/Index', [
            'orders' => $this->orderInterface->filter($filters),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = $this->orderInterface->findById($id, ['*'], ['concessions']);
        return Inertia::render('Management/Kitchen/Edit/Index', [
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();
            $data['status'] = OrderStatusEnum::Completed->value;
            $this->orderInterface->update($id, $data);
            //remove order from kitchen(queue)
            $this->orderInterface->addOrRemoveOrder($id, false);
            return redirect()->route('kitchen.index')->with('success', 'Order updated successfully');
        } catch (\Throwable $th) {
            Log::error('Order update failed: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Order update failed');
        }
    }
}
