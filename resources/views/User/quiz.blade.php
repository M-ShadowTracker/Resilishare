@extends('layouts.app')

@section('title', 'Cybersecurity Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Cybersecurity Quiz</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Choose a Quiz Level</h2>
        <p class="text-gray-600 mb-6">Test your cybersecurity knowledge by selecting a quiz level below.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach(['beginner', 'intermediate', 'advanced'] as $level)
                @if(isset($quizzes[$level]))
                    @php $quiz = $quizzes[$level]; @endphp
                    <div class="border rounded-lg p-6 hover:shadow-md transition">
                        <div class="text-center mb-4">
                            <div class="inline-block p-4 rounded-full bg-blue-100 text-blue-600">
                                @if($level === 'beginner')
                                    <i class="fas fa-star text-3xl"></i>
                                @elseif($level === 'intermediate')
                                    <i class="fas fa-shield-alt text-3xl"></i>
                                @else
                                    <i class="fas fa-lock text-3xl"></i>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-center mb-2">{{ ucfirst($level) }} Level</h3>
                        <a href="{{ route('user.quiz.start', $quiz->id) }}" 
                           class="block bg-blue-50 hover:bg-blue-100 text-blue-800 font-medium py-2 px-4 rounded-lg transition">
                            {{ $quiz->title }}
                            <span class="float-right">{{ $quiz->questions_count }} Qs</span>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection