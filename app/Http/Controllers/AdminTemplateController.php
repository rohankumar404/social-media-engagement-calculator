<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminTemplateController extends Controller
{
    public function edit()
    {
        $path = resource_path('views/pdf/engagement-report.blade.php');
        $content = '';
        
        if (File::exists($path)) {
            $content = File::get($path);
        }
        
        return view('admin.template.edit', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $path = resource_path('views/pdf/engagement-report.blade.php');
        
        // Ensure directory exists
        if(!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
        
        File::put($path, $request->input('content'));

        return redirect()->route('admin.template.edit')->with('success', 'PDF Report Template successfully updated.');
    }
}
