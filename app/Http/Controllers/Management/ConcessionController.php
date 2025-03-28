<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\ConcessionRequest;
use App\Repositories\Eloquent\Concession\ConcessionInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConcessionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ConcessionInterface $concessionInterface){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('searchParam', 'sortBy', 'sortDirection', 'rowPerPage', 'page');
        $filters['sortBy'] = $filters['sortBy'] ?? 'name';
        $filters['sortDirection'] = $filters['sortDirection'] ?? 'asc';
        $filters['rowPerPage'] = $filters['rowPerPage'] ?? 10;
       return Inertia::render("Management/Concession/All/Index", [
            'concessions' => $this->concessionInterface->filter($filters),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Management/Concession/Create/Index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConcessionRequest $request)
    {
        $data = $request->all();
        $data['image'] = $request->file('image')->store('concessions', 'public');
        $this->concessionInterface->create($data);
        return redirect()->route('concessions.index')->with('success', 'Concession created successfully');
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

        return Inertia::render('Management/Concession/Edit/Index',[
            'concession' => $this->concessionInterface->findById($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConcessionRequest $request, string $id)
    {
        $data = $request->all();
        $data['image'] = $request->file('image')->store('concessions', 'public');
        $this->concessionInterface->update($id, $data);
        return redirect()->route('concessions.index')->with('success', 'Concession updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->concessionInterface->deleteById($id);
        return redirect()->route('concessions.index')->with('success','Concession deleted successfully');
    }
}
