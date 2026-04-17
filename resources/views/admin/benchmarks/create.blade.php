<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Industry Benchmark') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#272727] shadow-xl sm:rounded-lg border border-[rgba(255,255,255,0.05)] overflow-hidden">
                <div class="p-8 text-white">
                    <form action="{{ route('benchmarks.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">Industry</label>
                            <input type="text" name="industry" class="shadow appearance-none border border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline focus:border-[#85f43a]" placeholder="e.g. Technology" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">Platform</label>
                            <select name="platform" class="shadow border border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:border-[#85f43a]" required>
                                <option value="instagram" class="bg-[#272727]">Instagram</option>
                                <option value="tiktok" class="bg-[#272727]">TikTok</option>
                                <option value="youtube" class="bg-[#272727]">YouTube</option>
                                <option value="facebook" class="bg-[#272727]">Facebook</option>
                                <option value="x_twitter" class="bg-[#272727]">X (Twitter)</option>
                                <option value="linkedin" class="bg-[#272727]">LinkedIn</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">Average Engagement Rate (%)</label>
                            <input type="number" step="0.01" name="avg_engagement_rate" class="shadow appearance-none border border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:border-[#85f43a]" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">High Threshold (%)</label>
                            <input type="number" step="0.01" name="high_threshold" class="shadow appearance-none border border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:border-[#85f43a]" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-400 text-sm font-bold mb-2">Viral Threshold (%)</label>
                            <input type="number" step="0.01" name="viral_threshold" class="shadow appearance-none border border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:border-[#85f43a]" required>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('benchmarks.index') }}" class="text-gray-400 hover:text-white mr-4">Cancel</a>
                            <button type="submit" class="bg-[#85f43a] text-[#272727] font-semibold py-2 px-6 rounded shadow hover:bg-[#47A805] hover:text-white transition-colors">
                                Save Benchmark
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
