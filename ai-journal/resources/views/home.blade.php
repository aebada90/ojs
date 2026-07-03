<x-marketing-layout>
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-full mb-6">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/></svg>
                    AI-Powered Academic Review
                </div>
                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                    Automate manuscript review for your <span class="text-indigo-600">journal</span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                    AI Journal provides intelligent, multi-criteria peer review for academic manuscripts.
                    Reduce editorial workload, accelerate turnaround times, and deliver consistent,
                    structured feedback to authors — all powered by advanced AI analysis.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Start Free Trial
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#features" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-indigo-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-8 text-center text-white">
                <div>
                    <div class="text-4xl font-bold">{{ $stats['journals'] }}</div>
                    <div class="text-indigo-200 mt-1">Active Journals</div>
                </div>
                <div>
                    <div class="text-4xl font-bold">{{ $stats['articles_reviewed'] }}</div>
                    <div class="text-indigo-200 mt-1">Articles Reviewed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold">{{ $stats['reviews_completed'] }}</div>
                    <div class="text-indigo-200 mt-1">AI Reviews Completed</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Comprehensive AI Review Pipeline</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Every manuscript is evaluated across seven academic quality dimensions with detailed, actionable feedback.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['title' => 'Multi-Criteria Scoring', 'desc' => 'Automated evaluation across originality, methodology, clarity, structure, references, ethics, and reproducibility.', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['title' => 'Instant Turnaround', 'desc' => 'Complete AI review in under 60 seconds. No more months-long waiting for preliminary assessment.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['title' => 'Structured Feedback', 'desc' => 'Detailed strengths, weaknesses, and suggestions help authors improve before formal peer review.', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
                    ['title' => 'Journal Management', 'desc' => 'Editors manage multiple journals, configure review settings, and track all submissions in one dashboard.', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                    ['title' => 'Ethics & Compliance', 'desc' => 'Automatic checks for ethics declarations, consent statements, and conflict of interest disclosures.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['title' => 'Editorial Recommendations', 'desc' => 'Clear accept, minor revision, major revision, or reject recommendations with confidence scores.', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                ] as $feature)
                <div class="p-6 rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-gray-600 text-sm">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-16">How It Works</h2>
            <div class="grid md:grid-cols-4 gap-8">
                @foreach([
                    ['step' => '1', 'title' => 'Register', 'desc' => 'Sign up as a journal editor or author'],
                    ['step' => '2', 'title' => 'Submit', 'desc' => 'Authors submit manuscripts to participating journals'],
                    ['step' => '3', 'title' => 'AI Review', 'desc' => 'Our AI analyzes the manuscript across 7 criteria'],
                    ['step' => '4', 'title' => 'Report', 'desc' => 'Detailed review report with scores and recommendations'],
                ] as $step)
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4">{{ $step['step'] }}</div>
                    <h3 class="font-semibold text-gray-900">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Journals --}}
    @if($journals->count())
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Participating Journals</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($journals as $journal)
                <div class="p-6 border border-gray-200 rounded-xl hover:shadow-md transition">
                    <h3 class="font-semibold text-gray-900">{{ $journal->name }}</h3>
                    @if($journal->subject_area)
                        <span class="inline-block mt-2 px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded">{{ $journal->subject_area }}</span>
                    @endif
                    <p class="mt-3 text-sm text-gray-600 line-clamp-3">{{ $journal->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="py-20 bg-indigo-600">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white">Ready to transform your journal's review process?</h2>
            <p class="mt-4 text-indigo-200">Join journals already using AI-powered review to accelerate publishing without compromising quality.</p>
            <a href="{{ route('register') }}" class="mt-8 inline-flex items-center px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition shadow-lg">
                Create Your Account
            </a>
        </div>
    </section>
</x-marketing-layout>
