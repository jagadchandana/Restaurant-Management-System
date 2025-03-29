<?php

namespace App\Http\Controllers\Management;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Concession\ConcessionInterface;
use App\Repositories\Eloquent\Order\OrderInterface;
use Illuminate\Http\Request;
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
        $filters['sortBy'] = $filters['sortBy'] ?? 'order_number';
        $filters['sortDirection'] = $filters['sortDirection'] ?? 'asc';
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
    public function store(Request $request)
    {
        $data = $request->all();
        $data['order_number'] = rand(100000, 999999);
        $this->orderInterface->create($data)->concessions()->sync($data['concession_ids']);
        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
