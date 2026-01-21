<?php

namespace App\Http\Controllers;

use App\Models\MetricsTarget;
use Illuminate\Http\Request;

class MetricsTargetController extends Controller
{
    public function index()
    {
        try {
            $metricsTargets = MetricsTarget::all();
            return view("admin.metrics_targets.index", compact("metricsTargets"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load metrics targets: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view("admin.metrics_targets.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load metrics target form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'metric_name' => 'required|in:news,products,orders,revenue,users,bookings,contacts|unique:metrics_targets,metric_name',
                'monthly_goal' => 'required|integer|min:0',
            ]);

            MetricsTarget::create($validated);

            return redirect()->route('metrics_targets.index')
                ->with('success', 'Metrics target created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create metrics target: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(MetricsTarget $metricsTarget)
    {
        try {
            return view("admin.metrics_targets.show", compact("metricsTarget"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load metrics target: ' . $e->getMessage()]);
        }
    }

    public function edit(MetricsTarget $metricsTarget)
    {
        try {
            return view("admin.metrics_targets.edit", compact("metricsTarget"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load metrics target edit form: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, MetricsTarget $metricsTarget)
    {
        try {
            $validated = $request->validate([
                'metric_name' => "required|in:news,products,orders,revenue,users,bookings,contacts|unique:metrics_targets,metric_name,{$metricsTarget->id}",
                'monthly_goal' => 'required|integer|min:0',
            ]);

            $metricsTarget->update($validated);

            return redirect()->route('metrics_targets.index')
                ->with('success', 'Metrics target updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update metrics target: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(MetricsTarget $metricsTarget)
    {
        try {
            $metricsTarget->delete();
            return redirect()->route('metrics_targets.index')
                ->with('success', 'Metrics target deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete metrics target: ' . $e->getMessage()]);
        }
    }
}
