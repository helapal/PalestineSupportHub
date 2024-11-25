@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="relative h-[500px] flex items-center justify-center">
        <div 
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1637034318492-c5d36e4f6d99'); filter: brightness(0.6);"
        ></div>
        <div class="relative z-10 text-center text-white max-w-3xl px-4">
            <h1 class="text-5xl font-bold mb-6">Support Palestinian Communities</h1>
            <p class="text-xl mb-8">
                Join us in making a difference through verified humanitarian campaigns.
                Every donation brings hope and support to those in need.
            </p>
            <a 
                href="#campaigns"
                class="inline-block px-6 py-3 bg-olive-700 hover:bg-olive-800 text-white font-semibold rounded-lg transition-colors"
            >
                View Campaigns
            </a>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8" id="campaigns">
        <!-- Campaigns Needing Support -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-olive-800">
                Campaigns Needing Support
                <span class="text-lg font-normal text-gray-600 ml-2">Help make a bigger impact</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($needingSupportCampaigns as $campaign)
                <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
                    <!-- Needs Support Badge -->
                    <div class="absolute top-4 right-4 bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        Needs Support
                    </div>
                    <div 
                        class="h-48 bg-cover bg-center"
                        style="background-image: url('{{ $campaign->image_url }}');"
                    ></div>
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-2">{{ $campaign->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $campaign->description }}</p>
                        <div class="space-y-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div 
                                    class="bg-red-500 h-2 rounded-full"
                                    style="width: {{ ($campaign->current / $campaign->goal) * 100 }}%"
                                ></div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>${{ number_format($campaign->current, 2) }}</span>
                                <span>Goal: ${{ number_format($campaign->goal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        @include('campaigns.partials.donation-form', ['campaign' => $campaign])
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Other Active Campaigns -->
        <section>
            <h2 class="text-3xl font-bold mb-8 text-olive-800">Active Campaigns</h2>
        
        <div class="mb-6">
            <form action="{{ url()->current() }}" method="GET" class="space-y-4 bg-white p-4 rounded-lg shadow-sm">
                <!-- Search and Date Range -->
                <div class="flex flex-wrap gap-4">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search campaigns..."
                        value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-lg flex-1"
                    >
                    <input 
                        type="date" 
                        name="start_date" 
                        placeholder="Start Date"
                        value="{{ request('start_date') }}"
                        class="px-4 py-2 border rounded-lg w-40"
                    >
                    <input 
                        type="date" 
                        name="end_date" 
                        placeholder="End Date"
                        value="{{ request('end_date') }}"
                        class="px-4 py-2 border rounded-lg w-40"
                    >
                </div>

                <!-- Amount Ranges -->
                <div class="flex flex-wrap gap-4">
                    <div class="flex flex-col flex-1 gap-2">
                        <label class="text-sm font-medium text-gray-700">Current Amount Range</label>
                        <div class="flex gap-4">
                            <input 
                                type="number" 
                                name="min_amount" 
                                placeholder="Min amount"
                                value="{{ request('min_amount') }}"
                                class="px-4 py-2 border rounded-lg w-full"
                                min="0"
                                step="0.01"
                            >
                            <input 
                                type="number" 
                                name="max_amount" 
                                placeholder="Max amount"
                                value="{{ request('max_amount') }}"
                                class="px-4 py-2 border rounded-lg w-full"
                                min="0"
                                step="0.01"
                            >
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 gap-2">
                        <label class="text-sm font-medium text-gray-700">Goal Amount Range</label>
                        <div class="flex gap-4">
                            <input 
                                type="number" 
                                name="min_goal" 
                                placeholder="Min goal"
                                value="{{ request('min_goal') }}"
                                class="px-4 py-2 border rounded-lg w-full"
                                min="0"
                                step="0.01"
                            >
                            <input 
                                type="number" 
                                name="max_goal" 
                                placeholder="Max goal"
                                value="{{ request('max_goal') }}"
                                class="px-4 py-2 border rounded-lg w-full"
                                min="0"
                                step="0.01"
                            >
                        </div>
                    </div>
                </div>

                <!-- Progress Range -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-gray-700">Progress Percentage Range</label>
                    <div class="flex gap-4">
                        <input 
                            type="number" 
                            name="min_progress" 
                            placeholder="Min progress %"
                            value="{{ request('min_progress') }}"
                            class="px-4 py-2 border rounded-lg w-32"
                            min="0"
                            max="100"
                            step="1"
                        >
                        <input 
                            type="number" 
                            name="max_progress" 
                            placeholder="Max progress %"
                            value="{{ request('max_progress') }}"
                            class="px-4 py-2 border rounded-lg w-32"
                            min="0"
                            max="100"
                            step="1"
                        >
                    </div>
                </div>

                <!-- Sort Controls -->
                <div class="flex flex-wrap items-center gap-4">
                    <select name="sort" class="px-4 py-2 border rounded-lg">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date</option>
                        <option value="current" {{ request('sort') === 'current' ? 'selected' : '' }}>Amount Raised</option>
                        <option value="goal" {{ request('sort') === 'goal' ? 'selected' : '' }}>Goal Amount</option>
                    </select>
                    <select name="order" class="px-4 py-2 border rounded-lg">
                        <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                    <div class="flex gap-4 ml-auto">
                        <a href="{{ url()->current() }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg">
                            Clear Filters
                        </a>
                        <button type="submit" class="px-6 py-2 bg-olive-700 hover:bg-olive-800 text-white font-semibold rounded-lg">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($campaigns as $campaign)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div 
                    class="h-48 bg-cover bg-center"
                    style="background-image: url('{{ $campaign->image_url }}');"
                ></div>
                <div class="p-4">
                    <h3 class="text-xl font-bold mb-2">{{ $campaign->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $campaign->description }}</p>
                    <div class="space-y-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div 
                                class="bg-olive-700 h-2 rounded-full"
                                style="width: {{ ($campaign->current / $campaign->goal) * 100 }}%"
                            ></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>${{ number_format($campaign->current, 2) }}</span>
                            <span>Goal: ${{ number_format($campaign->goal, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 pt-0">
                    <form action="{{ route('campaigns.donate') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="hidden" name="campaign_ids" value="{{ $campaign->id }}">
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Your email"
                            required
                            class="flex-1 px-3 py-2 border rounded-lg"
                        >
                        <input 
                            type="number" 
                            name="amount" 
                            placeholder="Amount"
                            min="1"
                            step="0.01"
                            required
                            class="w-24 px-3 py-2 border rounded-lg"
                        >
                        <input type="hidden" name="recurring" value="0">
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-olive-700 hover:bg-olive-800 text-white font-semibold rounded-lg transition-colors"
                        >
                            Donate
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    </main>
</div>
@endsection
