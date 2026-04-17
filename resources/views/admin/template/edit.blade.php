<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Template Editor') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#272727] shadow-xl sm:rounded-lg border border-[rgba(255,255,255,0.05)] overflow-hidden">
                <div class="p-8 text-white">
                    <div class="mb-6 border-b border-[rgba(255,255,255,0.05)] pb-4">
                        <h3 class="text-xl font-bold mb-2">Edit PDF Template Layout</h3>
                        <p class="text-gray-400 text-sm">Directly modify the HTML/Inline CSS layout for the DOMPDF output engine.</p>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.template.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm font-bold mb-2">Blade Template Source Code</label>
                            <textarea name="content" rows="30" class="font-mono shadow appearance-none border border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] rounded w-full py-2 px-3 text-white leading-relaxed focus:outline-none focus:shadow-outline focus:border-[#85f43a]" required>{{ $content }}</textarea>
                            <p class="text-gray-500 text-xs mt-2"><strong>Warning:</strong> Syntax errors in this Blade file may break standard PDF exports. Please back up configurations.</p>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-[#85f43a] text-[#272727] font-semibold py-2 px-6 rounded shadow hover:bg-[#47A805] hover:text-white transition-colors">
                                Save Report Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
