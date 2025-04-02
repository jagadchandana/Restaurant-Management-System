<?php

namespace App\Http\Controllers\Management;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\OrderRequest;
use App\Repositories\Eloquent\Concession\ConcessionInterface;
use App\Repositories\Eloquent\Order\OrderInterface;
use App\Services\Order\OrderServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     */
    public function __construct(
        protected OrderInterface $orderInterface,
        protected ConcessionInterface $concessionInterface
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('searchParam', 'sortBy', 'sortDirection', 'rowPerPage', 'page');
        $filters['sortBy'] = $filters['sortBy'] ?? 'id';
        $filters['sortDirection'] = $filters['sortDirection'] ?? 'desc';
        $filters['rowPerPage'] = $filters['rowPerPage'] ?? 10;
        return Inertia::render("Management/Order/All/Index", [
            'orders' => $this->orderInterface->filter($filters),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Management/Order/Create/Index', [
            'concessions' => $this->concessionInterface->getByColumn([], ['id as value', 'name as label']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        try {
            $data = $request->all();
            do {
                $data['order_number'] = rand(100000, 999999);
            } while ($this->orderInterface->existsByColumn(['order_number' =>  $data['order_number']]));
            $this->orderInterface->create($data)->concessions()->sync($data['concession_ids']);
            return redirect()->route('orders.index')->with('success', 'Order created successfully');
        } catch (\Throwable $th) {
            Log::error('Order creation failed: ' . $th->getMessage());
            return redirect()->route('orders.index')->with('error', 'Order creation failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = $this->orderInterface->findById($id, ['*'], ['concessions']);
        return Inertia::render('Management/Order/Edit/Index', [
            'order' => $order,
            'concession_ids' => $order->concessions->pluck('id')->toArray(),
            'concessions' => $this->concessionInterface->getByColumn([], ['id as value', 'name as label']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        try {
            $data = $request->all();
            $order = $this->orderInterface->findById($id);
            $order->update($data);
            $order->concessions()->sync($data['concession_ids']);
            return redirect()->route('orders.index')->with('success', 'Order updated successfully');
        } catch (\Throwable $th) {
            Log::error('Order update failed: ' . $th->getMessage());
            return redirect()->route('orders.index')->with('error', 'Order update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->orderInterface->deleteById($id);
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
        } catch (\Throwable $th) {
            Log::error('Order deletion failed: ' . $th->getMessage());
            return redirect()->route('orders.index')->with('error', 'Order deletion failed');
        }
    }
    /**
     * Change the status of the order.
     */
    public function updateStatus(string $id)
    {
        try {
            $order = $this->orderInterface->findById($id);
            $order->update([
                'status' => OrderStatusEnum::InProgress->value,
                'to_kitchen' => now(),
            ]);
            // add order to kitchen(queue)
            $this->orderInterface->addOrRemoveOrder($id, true);
            return redirect()->route('orders.index')->with('success', 'Order sent to kitchen successfully');
        } catch (\Throwable $th) {
            Log::error('Order status update failed: ' . $th->getMessage());
            return redirect()->route('orders.index')->with('error', 'Order status update failed');
        }
    }
}
