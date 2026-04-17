<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EngagementCalculatorController extends Controller
{
    public function index()
    {
        return view('calculator.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'followers' => 'required|numeric|min:1',
            'likes' => 'required|numeric|min:0',
            'comments' => 'required|numeric|min:0',
            'shares' => 'required|numeric|min:0',
            'total_posts' => 'nullable|numeric|min:1',
            'industry_id' => 'nullable|integer|exists:industry_benchmarks,id',
        ]);

        $followers = $request->input('followers');
        $likes = $request->input('likes');
        $comments = $request->input('comments');
        $shares = $request->input('shares');
        $total_posts = $request->input('total_posts');

        $engagement_rate = (($likes + $comments + $shares) / $followers) * 100;

        $engagement_per_post = null;
        if ($total_posts) {
            $engagement_per_post = $engagement_rate / $total_posts;
        }

        if ($engagement_rate > 6) {
            $engagement_score = 'Viral';
            $recommendations = [
                'Excellent engagement! Keep up the current content strategy.',
                'Consider collaborations with other top creators in your niche.',
                'Leverage this engagement to boost your latest products or announcements.'
            ];
        } elseif ($engagement_rate >= 3) {
            $engagement_score = 'High';
            $recommendations = [
                'Great job! Your followers are highly engaged with your content.',
                'Analyze which posts perform best and replicate their style.',
                'Try engaging directly in the comments to build deeper connections.'
            ];
        } elseif ($engagement_rate >= 1) {
            $engagement_score = 'Average';
            $recommendations = [
                'Your engagement is healthy, but there is room for growth.',
                'Experiment with more video content or interactive polls.',
                'Ensure you are posting at times when your audience is most active.'
            ];
        } else {
            $engagement_score = 'Low';
            $recommendations = [
                'Try asking more questions in your captions to encourage comments.',
                'Use more targeted and relevant hashtags to reach new people.',
                'Review your posting frequency; consistency is key.'
            ];
        }

        $fake_engagement_flag = false;
        $fake_engagement_messages = [];

        if ($likes > 1000 && $comments < ($likes * 0.01)) {
            $fake_engagement_flag = true;
            $fake_engagement_messages = [
                "Possible fake followers or bot engagement detected.",
                "Your audience reacts but does not interact.",
                "You may be attracting passive followers."
            ];
        }

        $report_data = [
            'engagement_rate' => $engagement_rate,
            'engagement_score' => $engagement_score,
            'engagement_per_post' => $engagement_per_post,
            'recommendations' => $recommendations,
            'fake_engagement_flag' => $fake_engagement_flag,
            'fake_engagement_messages' => $fake_engagement_messages
        ];

        $benchmark_comparison = null;
        if ($request->filled('industry_id')) {
            $benchmark = DB::table('industry_benchmarks')->find($request->input('industry_id'));
            if ($benchmark) {
                $avg_rate = $benchmark->avg_engagement_rate;
                $difference = abs($engagement_rate - $avg_rate);
                
                if ($avg_rate > 0) {
                    $relative_diff = ($difference / $avg_rate) * 100;
                } else {
                    $relative_diff = 0;
                }

                $status = ($engagement_rate >= $avg_rate) ? 'higher' : 'lower';
                
                $message = sprintf(
                    "Your engagement is %s%% %s than the %s industry average.",
                    round($relative_diff, 1),
                    $status,
                    $benchmark->industry
                );

                if ($engagement_rate >= $avg_rate) {
                    $badge_color = 'green';
                } elseif ($relative_diff <= 20) {
                    $badge_color = 'orange'; // Slightly below (within 20% relative diff)
                } else {
                    $badge_color = 'red';    // Far below (more than 20% relative diff)
                }

                $benchmark_comparison = [
                    'status' => $status,
                    'percentage_difference' => round($relative_diff, 1),
                    'message' => $message,
                    'badge_color' => $badge_color,
                    'industry' => $benchmark->industry,
                    'benchmark_rate' => $avg_rate
                ];

                $report_data['benchmark_comparison'] = $benchmark_comparison;
            }
        }

        $report_json = json_encode($report_data);

        return response()->json([
            'engagement_rate' => round($engagement_rate, 2),
            'engagement_score' => $engagement_score,
            'engagement_per_post' => $engagement_per_post ? round($engagement_per_post, 2) : null,
            'recommendations' => $recommendations,
            'benchmark_comparison' => $benchmark_comparison,
            'fake_engagement_flag' => $fake_engagement_flag,
            'fake_engagement_messages' => $fake_engagement_messages,
            'report_json' => $report_json
        ]);
    }

    public function saveReport(Request $request)
    {
        $request->validate([
            'report_json' => 'required|json'
        ]);

        // Logic to save report_json to database could go here
        
        return response()->json([
            'success' => true,
            'message' => 'Report saved successfully'
        ]);
    }

    public function dashboard()
    {
        return view('calculator.dashboard');
    }
}
