<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Industry Benchmarks') }}
            </h2>
            <a href="{{ route('benchmarks.create') }}" class="bg-[#85f43a] text-[#272727] font-semibold px-4 py-2 rounded shadow hover:bg-[#47A805] hover:text-white transition-colors">
                Add New Benchmark
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#272727] shadow-xl sm:rounded-lg border border-[rgba(255,255,255,0.05)] overflow-hidden">
                <div class="p-6 border-b border-[rgba(255,255,255,0.05)] text-white">
                    <h3 class="text-xl font-bold mb-4">Manage Benchmarks</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-300">
                            <thead class="text-xs text-[#85f43a] uppercase bg-[rgba(255,255,255,0.05)]">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Industry</th>
                                    <th scope="col" class="px-6 py-3">Platform</th>
                                    <th scope="col" class="px-6 py-3">Avg Rate</th>
                                    <th scope="col" class="px-6 py-3">High Threshold</th>
                                    <th scope="col" class="px-6 py-3">Viral Threshold</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($benchmarks as $b)
                                <tr class="bg-transparent border-b border-[rgba(255,255,255,0.05)] hover:bg-[rgba(255,255,255,0.02)]">
                                    <td class="px-6 py-4 font-medium text-white">{{ $b->industry }}</td>
                                    <td class="px-6 py-4 capitalize">{{ $b->platform }}</td>
                                    <td class="px-6 py-4">{{ $b->avg_engagement_rate }}%</td>
                                    <td class="px-6 py-4">{{ $b->high_threshold }}%</td>
                                    <td class="px-6 py-4">{{ $b->viral_threshold }}%</td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-3">
                                        <a href="{{ route('benchmarks.edit', $b->id) }}" class="text-[#85f43a] hover:underline">Edit</a>
                                        <form action="{{ route('benchmarks.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this benchmark?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 hover:underline">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                {{ $benchmarks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
