<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social Media Dashboard') }}
        </h2>
    </x-slot>

    <!-- We inject some specific dark UI styles here to match the calculator tool -->
    <style>
        .dashboard-container {
            background-color: #f3f4f6; /* Tailwind gray-100 fallback */
        }
        .dark-card {
            background-color: #272727;
            color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .premium-badge {
            background-color: #85f43a;
            color: #272727;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-block;
        }
        .btn-primary-accent {
            background-color: #85f43a;
            color: #272727;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        .btn-primary-accent:hover {
            background-color: #47A805;
            color: #ffffff;
        }
        .table-dark th {
            background-color: rgba(255,255,255,0.05);
            color: #85f43a;
            padding: 0.75rem 1rem;
            text-align: left;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .table-dark td {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
    </style>

    <div class="py-12 dashboard-container" x-data="dashboardUI()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Premium / Usage Status Widget -->
            <div class="dark-card mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold mb-1">Your Account Status</h3>
                            <p class="text-gray-400 text-sm">
                                Track your calculations and access historical data.
                            </p>
                        </div>
                        <div>
                            @if($usageLimit && $usageLimit->is_premium)
                                <span class="premium-badge">PRO User</span>
                            @else
                                <div class="text-right">
                                    <p class="text-gray-400 text-sm mb-2">
                                        Calculations used: <strong class="text-white">{{ $usageLimit ? $usageLimit->usage_count : 0 }} / 3</strong>
                                    </p>
                                    @if($usageLimit && $usageLimit->usage_count >= 3)
                                        <a href="#" class="btn-primary-accent inline-block">Upgrade to Premium</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saved Reports Table -->
            <div class="dark-card">
                <div class="p-6 border-b" style="border-color: rgba(255,255,255,0.05);">
                    <h3 class="text-xl font-bold text-white">Saved Reports</h3>
                </div>
                
                <div class="overflow-x-auto">
                    @if($reports->isEmpty())
                        <div class="p-8 text-center text-gray-400">
                            You haven't generated any reports yet. 
                            <div class="mt-4">
                                <a href="/calculator" class="text-[#85f43a] hover:underline">Go to Calculator</a>
                            </div>
                        </div>
                    @else
                        <table class="w-full table-dark">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Platform</th>
                                    <th>Engagement Rate</th>
                                    <th>Quality Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr class="hover:bg-[rgba(255,255,255,0.02)] transition-colors">
                                        <td class="text-gray-300">
                                            {{ $report->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="font-medium text-white">
                                            {{ $report->platform }}
                                        </td>
                                        <td>
                                            <span class="text-white font-bold">{{ $report->engagement_rate }}%</span>
                                        </td>
                                        <td>
                                            @if($report->engagement_rate > 6)
                                                <span class="text-[#85f43a]">Viral</span>
                                            @elseif($report->engagement_rate >= 3)
                                                <span class="text-[#85f43a]">High</span>
                                            @elseif($report->engagement_rate >= 1)
                                                <span class="text-yellow-400">Average</span>
                                            @else
                                                <span class="text-red-400">Low</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button 
                                                @click="downloadPdf({{ $report->id }})"
                                                class="text-sm text-[#85f43a] hover:text-white transition-colors flex items-center"
                                                :disabled="isDownloading === {{ $report->id }}"
                                            >
                                                <span x-show="isDownloading !== {{ $report->id }}">
                                                    <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    Download PDF
                                                </span>
                                                <span x-show="isDownloading === {{ $report->id }}" x-cloak>
                                                    Processing...
                                                </span>
                                            </button>
                                            
                                            <!-- Hidden data payload storage -->
                                            <div id="report-data-{{ $report->id }}" class="hidden">
                                                {{ $report->report_json }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function dashboardUI() {
            return {
                isDownloading: null,
                
                async downloadPdf(reportId) {
                    this.isDownloading = reportId;
                    
                    try {
                        let jsonElement = document.getElementById('report-data-' + reportId);
                        if(!jsonElement) throw new Error("Report payload not found.");
                        
                        let reportData = jsonElement.innerText.trim();

                        const response = await fetch('/download-report', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/pdf'
                            },
                            body: JSON.stringify({
                                report_data: reportData,
                                // Authenticated so email not required by backend
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        let dateStr = new Date().toISOString().slice(0,10);
                        a.download = `engagement-report-${dateStr}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        
                    } catch (error) {
                        console.error('Error downloading PDF:', error);
                        alert('Failed to initialize PDF generation.');
                    } finally {
                        this.isDownloading = null;
                    }
                }
            }
        }
    </script>
</x-app-layout>
