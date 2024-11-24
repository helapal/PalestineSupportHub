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
        <h2 class="text-3xl font-bold mb-8 text-olive-800">Active Campaigns</h2>
        
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
    </main>
</div>
@endsection
