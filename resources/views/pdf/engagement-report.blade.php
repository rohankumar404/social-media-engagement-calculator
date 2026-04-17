<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Social Media Engagement Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            background-color: #ffffff;
            margin: 0;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #85f43a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #272727;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #777777;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .card {
            border: 1px solid #eeeeee;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fcfcfc;
        }
        .card-title {
            font-size: 16px;
            color: #47A805;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 10px;
        }
        .score-row {
            width: 100%;
            margin-bottom: 20px;
        }
        .score-col {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .big-metric {
            font-size: 42px;
            font-weight: bold;
            color: #272727;
        }
        .list-item {
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 50px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eeeeee;
        }
        th {
            background-color: #f9f9f9;
            color: #555555;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Engagement Report</h1>
        <p>Generated for {{ $data['platform'] ?? 'Social Media' }} Performance</p>
    </div>

    <div class="score-row">
        <div class="score-col">
            <div class="card" style="text-align: center;">
                <div class="card-title">Engagement Rate</div>
                <div class="big-metric">{{ number_format($data['engagement_rate'] ?? 0, 2) }}%</div>
            </div>
        </div>
        <div class="score-col" style="margin-left: 2%;">
            <div class="card" style="text-align: center;">
                <div class="card-title">Quality Score</div>
                <div class="big-metric" style="color: #85f43a;">{{ $data['engagement_score'] ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    @if(!empty($data['insights']) || !empty($data['recommendations']))
    <div class="card">
        <div class="card-title">Insights & Recommendations</div>
        <ul>
            @php $recs = !empty($data['improvement_tips']) ? $data['improvement_tips'] : ($data['recommendations'] ?? []); @endphp
            @foreach($recs as $rec)
                <li class="list-item">{{ $rec }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(!empty($data['benchmark_comparison']))
    <div class="card">
        <div class="card-title">Industry Benchmark</div>
        <p>{{ $data['benchmark_comparison']['message'] ?? '' }}</p>
    </div>
    @endif

    @if(!empty($data['competitor_comparison']))
    <div class="card">
        <div class="card-title">Competitor Comparison</div>
        <table>
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>You</th>
                    <th>Competitor</th>
                    <th>Difference</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Followers</td>
                    <td>{{ $data['competitor_comparison']['you_followers'] ?? 0 }}</td>
                    <td>{{ $data['competitor_comparison']['competitor_followers'] ?? 0 }}</td>
                    <td>{{ $data['competitor_comparison']['followers_difference'] ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Engagement Rate</td>
                    <td>{{ $data['competitor_comparison']['you_engagement_rate'] ?? 0 }}%</td>
                    <td>{{ $data['competitor_comparison']['competitor_engagement_rate'] ?? 0 }}%</td>
                    <td>{{ $data['competitor_comparison']['er_difference_absolute'] ?? 0 }}%</td>
                </tr>
            </tbody>
        </table>
        <p><strong>Conclusion:</strong> {{ $data['competitor_comparison']['message'] ?? '' }}</p>
    </div>
    @endif

    @if(!empty($data['what_to_post_next']) && !empty($data['what_to_post_next']['recommendations']))
    <div class="card">
        <div class="card-title">What To Post Next</div>
        <ul>
            @foreach($data['what_to_post_next']['recommendations'] as $item)
                <li class="list-item">{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="footer">
        Generated by MapsilyTools on {{ date('F j, Y') }}
    </div>

</body>
</html>
