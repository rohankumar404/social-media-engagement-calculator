<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndustryBenchmark;

class AdminBenchmarkController extends Controller
{
    public function index()
    {
        $benchmarks = IndustryBenchmark::orderBy('industry')->paginate(20);
        return view('admin.benchmarks.index', compact('benchmarks'));
    }

    public function create()
    {
        return view('admin.benchmarks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'industry' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'avg_engagement_rate' => 'required|numeric|min:0',
            'high_threshold' => 'required|numeric|min:0',
            'viral_threshold' => 'required|numeric|min:0',
        ]);

        IndustryBenchmark::create($data);

        return redirect()->route('benchmarks.index')->with('success', 'Benchmark created successfully.');
    }

    public function edit(IndustryBenchmark $benchmark)
    {
        return view('admin.benchmarks.edit', compact('benchmark'));
    }

    public function update(Request $request, IndustryBenchmark $benchmark)
    {
        $data = $request->validate([
            'industry' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'avg_engagement_rate' => 'required|numeric|min:0',
            'high_threshold' => 'required|numeric|min:0',
            'viral_threshold' => 'required|numeric|min:0',
        ]);

        $benchmark->update($data);

        return redirect()->route('benchmarks.index')->with('success', 'Benchmark updated successfully.');
    }

    public function destroy(IndustryBenchmark $benchmark)
    {
        $benchmark->delete();
        return redirect()->route('benchmarks.index')->with('success', 'Benchmark deleted successfully.');
    }
}
