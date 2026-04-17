<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class EngagementCalculatorController extends Controller
{
    public function index()
    {
        return view('tools.engagement-calculator');
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
            'platform' => 'nullable|string',
            'saves' => 'nullable|numeric|min:0',
            'split_reels' => 'nullable|numeric|min:0|max:100',
            'split_images' => 'nullable|numeric|min:0|max:100',
            'split_carousel' => 'nullable|numeric|min:0|max:100',
            'split_video' => 'nullable|numeric|min:0|max:100',
            'competitor_name' => 'nullable|string',
            'competitor_followers' => 'nullable|numeric|min:1',
            'competitor_engagement_rate' => 'nullable|numeric|min:0',
        ]);

        $followers = $request->input('followers');
        $likes = $request->input('likes');
        $comments = $request->input('comments');
        $shares = $request->input('shares');
        $total_posts = $request->input('total_posts');
        $platform = $request->input('platform', '');
        $saves = $request->input('saves', 0);
        $split_reels = $request->input('split_reels', 0);
        $split_carousel = $request->input('split_carousel', 0);
        $split_video = $request->input('split_video', 0);
        
        $competitor_name = $request->input('competitor_name');
        $competitor_followers = $request->input('competitor_followers');
        $competitor_engagement_rate = $request->input('competitor_engagement_rate');

        $is_limited_mode = false;
        $upgrade_required = false;

        if (!auth()->check()) {
            $guest_usage = session('guest_calculator_uses', 0);
            $guest_limit = \App\Models\Setting::where('key', 'guest_limit')->value('value') ?? 2;
            if ($guest_usage >= (int)$guest_limit) {
                return response()->json([
                    'error' => 'guest_limit_reached',
                    'message' => 'You have reached your free limit. Please sign up to continue.'
                ], 403);
            }
            session(['guest_calculator_uses' => $guest_usage + 1]);
            $is_limited_mode = true;
        } else {
            $user = auth()->user();
            $usageLimit = \App\Models\UserUsageLimit::firstOrCreate(
                ['user_id' => $user->id],
                ['usage_count' => 0, 'is_premium' => false]
            );

            if (!$usageLimit->is_premium && !$user->is_admin) {
                $auth_limit = \App\Models\Setting::where('key', 'auth_limit')->value('value') ?? 3;
                if ($usageLimit->usage_count >= (int)$auth_limit) {
                    $is_limited_mode = true;
                    $upgrade_required = true;
                } else {
                    $usageLimit->increment('usage_count');
                }
            } else {
                $usageLimit->increment('usage_count');
            }
        }

        $engagement_rate = (($likes + $comments + $shares) / $followers) * 100;

        $engagement_per_post = null;
        if ($total_posts) {
            $engagement_per_post = $engagement_rate / $total_posts;
        }

        $er_viral = (float)(\App\Models\Setting::where('key', 'er_viral')->value('value') ?? 6);
        $er_high = (float)(\App\Models\Setting::where('key', 'er_high')->value('value') ?? 3);

        if ($engagement_rate > $er_viral) {
            $engagement_score = 'Viral';
            $recommendations = [
                'Excellent engagement! Keep up the current content strategy.',
                'Consider collaborations with other top creators in your niche.',
                'Leverage this engagement to boost your latest products or announcements.'
            ];
        } elseif ($engagement_rate >= $er_high) {
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

        $generated = $this->generateInsights($followers, $likes, $comments, $shares, $engagement_rate, $saves, $platform);
        $insights = $generated['insights'];
        $improvement_tips = $generated['tips'];

        $content_recommendations = [];
        if (($platform === 'Instagram' || $platform === 'TikTok') && $split_reels < 30) {
            $content_recommendations[] = 'Recommend increasing reels by 40%';
        }
        if ($platform === 'LinkedIn' && $split_carousel < 20) {
            $content_recommendations[] = 'Recommend more educational carousel posts';
        }
        if ($platform === 'YouTube' && $split_video < 40) {
            $content_recommendations[] = 'Recommend more short-form videos';
        }

        $what_to_post_next = [
            'title' => 'What To Post Next',
            'recommendations' => empty($content_recommendations) ? ['Maintain your optimal content mix while monitoring changing trends.'] : $content_recommendations
        ];

        $competitor_comparison = null;
        if ($competitor_name && $competitor_followers && $competitor_engagement_rate !== null) {
            $followers_diff = $followers - $competitor_followers;
            $er_diff_absolute = $engagement_rate - $competitor_engagement_rate;
            
            if ($competitor_engagement_rate > 0) {
                $er_diff_relative = round((abs($er_diff_absolute) / $competitor_engagement_rate) * 100, 1);
            } else {
                $er_diff_relative = 0;
            }

            if ($engagement_rate > $competitor_engagement_rate && $followers < $competitor_followers) {
                 $message = "You are outperforming {$competitor_name} by {$er_diff_relative}% despite having fewer followers.";
            } elseif ($engagement_rate < $competitor_engagement_rate && $followers > $competitor_followers) {
                 $multiplier = round($competitor_engagement_rate / max($engagement_rate, 0.01), 1);
                 $message = "{$competitor_name} has {$multiplier}x engagement with fewer followers.";
            } elseif ($engagement_rate > $competitor_engagement_rate) {
                 $message = "You are outperforming {$competitor_name} by {$er_diff_relative}%.";
            } else {
                 $message = "{$competitor_name} is outperforming you by {$er_diff_relative}%.";
            }

            $competitor_comparison = [
                'competitor_name' => $competitor_name,
                'competitor_followers' => $competitor_followers,
                'competitor_engagement_rate' => $competitor_engagement_rate,
                'you_followers' => $followers,
                'you_engagement_rate' => round($engagement_rate, 2),
                'followers_difference' => $followers_diff,
                'er_difference_absolute' => round($er_diff_absolute, 2),
                'message' => $message
            ];
        }

        $report_data = [
            'engagement_rate' => $engagement_rate,
            'engagement_score' => $engagement_score,
            'engagement_per_post' => $engagement_per_post,
            'recommendations' => $recommendations,
            'fake_engagement_flag' => $fake_engagement_flag,
            'fake_engagement_messages' => $fake_engagement_messages,
            'insights' => $insights,
            'improvement_tips' => $improvement_tips,
            'what_to_post_next' => $what_to_post_next,
            'competitor_comparison' => $competitor_comparison,
            'is_limited_mode' => $is_limited_mode,
            'upgrade_required' => $upgrade_required
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

        if ($is_limited_mode) {
             $recommendations = [];
             $fake_engagement_messages = [];
             $fake_engagement_flag = false;
             $insights = [];
             $improvement_tips = [];
             $what_to_post_next = null;
             $competitor_comparison = null;
             $benchmark_comparison = null;
        }

        $report_json = json_encode($report_data);

        if (auth()->check() && !$is_limited_mode) {
            \App\Models\EngagementReport::create([
                'user_id' => auth()->id(),
                'platform' => $platform ?: 'Unknown',
                'followers' => $followers,
                'likes' => $likes,
                'comments' => $comments,
                'shares' => $shares,
                'saves' => $saves,
                'engagement_rate' => $engagement_rate,
                'fake_engagement_flag' => $fake_engagement_flag,
                'report_json' => $report_json
            ]);
        }

        return response()->json([
            'engagement_rate' => round($engagement_rate, 2),
            'engagement_score' => $engagement_score,
            'engagement_per_post' => $engagement_per_post ? round($engagement_per_post, 2) : null,
            'recommendations' => $recommendations,
            'benchmark_comparison' => $benchmark_comparison,
            'fake_engagement_flag' => $fake_engagement_flag,
            'fake_engagement_messages' => $fake_engagement_messages,
            'insights' => $insights,
            'improvement_tips' => $improvement_tips,
            'what_to_post_next' => $what_to_post_next,
            'competitor_comparison' => $competitor_comparison,
            'is_limited_mode' => $is_limited_mode,
            'upgrade_required' => $upgrade_required,
            'report_json' => $report_json
        ]);
    }

    public function saveReport(Request $request)
    {
        $request->validate([
            'report_json' => 'required|json'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Report saved successfully'
        ]);
    }

    public function downloadReport(Request $request)
    {
        $request->validate([
            'report_data' => 'required|string',
        ]);

        $data = json_decode($request->input('report_data'), true);

        if (!auth()->check()) {
            $request->validate([
                'email' => 'required|email|max:255'
            ]);

            \App\Models\Lead::firstOrCreate([
                'email' => $request->input('email')
            ], [
                'source' => 'pdf_download',
                'intent_level' => 'high'
            ]);
        }

        $pdf = Pdf::loadView('pdf.engagement-report', compact('data'));

        $date = date('Y-m-d');
        return $pdf->download("engagement-report-{$date}.pdf");
    }

    public function dashboard()
    {
        $reports = \App\Models\EngagementReport::where('user_id', auth()->id())->latest()->get();
        $usageLimit = \App\Models\UserUsageLimit::firstOrCreate(
            ['user_id' => auth()->id()],
            ['usage_count' => 0, 'is_premium' => false]
        );

        return view('dashboard', compact('reports', 'usageLimit'));
    }

    private function generateInsights($followers, $likes, $comments, $shares, $engagement_rate, $saves, $platform)
    {
        $insights = [];
        $tips = [];

        // Rules for insights
        if ($followers > 10000 && $engagement_rate < 1.0) {
            $insights[] = "Your account size is growing faster than audience quality.";
        }

        if ($likes > 100 && $comments < ($likes * 0.05)) {
            $insights[] = "Your content lacks conversation triggers.";
        }

        if ($shares < ($likes * 0.02)) {
            $insights[] = "Your content is not valuable enough for people to share.";
        }

        if ($platform === 'Instagram' && $saves < ($likes * 0.05)) {
            $insights[] = "Your posts are not considered useful enough to revisit.";
        }

        // Fill generic insights if rules didn't hit at least 3
        if (count($insights) < 3) {
            $generic_insights = [
                "Your posting consistency might be affecting your algorithmic reach.",
                "Audience interaction is heavily skewed towards passive engagement.",
                "Your content formats may not align perfectly with what your audience expects.",
                "Consider experimenting with new content styles to refresh engagement."
            ];
            foreach ($generic_insights as $gi) {
                if (!in_array($gi, $insights)) {
                    $insights[] = $gi;
                }
                if (count($insights) >= 3) break;
            }
        }

        // Tip bank
        $all_tips = [
            "Ask questions in captions",
            "Post more reels",
            "Use storytelling",
            "Publish case studies",
            "Use stronger CTA in posts"
        ];
        
        // Context-aware tip adding
        if (in_array("Your content lacks conversation triggers.", $insights)) {
            $tips[] = "Ask questions in captions";
        }
        if (in_array("Your content is not valuable enough for people to share.", $insights)) {
            $tips[] = "Use storytelling";
            $tips[] = "Publish case studies";
        }
        if (in_array("Your posts are not considered useful enough to revisit.", $insights)) {
            $tips[] = "Use stronger CTA in posts";
            $tips[] = "Post more reels";
        }
        
        // Ensure at least 3 tips are selected
        foreach ($all_tips as $tip) {
            if (!in_array($tip, $tips)) {
                $tips[] = $tip;
            }
            if (count($tips) >= 3) break;
        }

        return [
            'insights' => array_slice($insights, 0, max(3, count($insights))), 
            'tips' => array_slice($tips, 0, max(3, count($tips))) 
        ];
    }
}
