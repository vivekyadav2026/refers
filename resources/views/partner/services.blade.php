@extends('layouts.app')

@section('title', 'My Offers - Partner Dashboard')

@section('sidebar')
    <!-- Enables sidebar -->
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                    My <span class="text-blue-600">Offers</span>
                </h1>
                <p class="text-slate-600 mt-1">
                    Share your affiliate links or submit a lead to start earning.
                </p>
            </div>
            <a href="{{ route('partner.leads.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Submit New Lead
            </a>
        </div>

        <!-- Categorized Services -->
        <div class="space-y-10">
            @if(isset($servicesByCategory) && $servicesByCategory->count() > 0)
                @foreach($servicesByCategory as $category => $services)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-inner">
                                    <i data-lucide="{{ $services->first()->icon ?? 'box' }}" class="w-4 h-4"></i>
                                </div>
                                {{ $category }}
                            </h2>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($services as $service)
                                    @include('components.service-card', ['service' => $service, 'isPartnerView' => true])
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12 text-slate-500 bg-white rounded-2xl border border-slate-200">
                    No offers available at the moment.
                </div>
            @endif
        </div>
        
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Affiliate link copied to clipboard!');
        });
    }
</script>
@endsection
