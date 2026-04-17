<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EngagementReport;
use App\Models\Lead;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_reports' => EngagementReport::count(),
            'recent_reports' => EngagementReport::latest()->take(5)->get(),
            'total_leads' => Lead::count()
        ];
        
        return view('admin.dashboard', compact('metrics'));
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    public function leads()
    {
        $leads = Lead::latest()->paginate(50);
        return view('admin.leads', compact('leads'));
    }

    public function exportLeads()
    {
        $fileName = 'leads-export-' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = ['ID', 'Email', 'Source', 'Intent Level', 'Created At'];
        
        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            Lead::chunk(500, function($leads) use($file) {
                foreach ($leads as $lead) {
                    $row = [
                        $lead->id,
                        $lead->email,
                        $lead->source,
                        $lead->intent_level,
                        $lead->created_at->format('Y-m-d H:i:s')
                    ];
                    fputcsv($file, $row);
                }
            });
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
