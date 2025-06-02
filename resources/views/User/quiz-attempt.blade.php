@extends('layouts.app')

@section('title', 'Quiz Attempt')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
                <p class="text-gray-600 mt-1">{{ $quiz->description }}</p>
            </div>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                {{ $quiz->level }} level
            </span>
        </div>

        <form method="POST" action="{{ route('user.quiz.submit', ['quizId' => $quiz->id, 'attemptId' => $activeAttempt->id]) }}">
            @csrf
            
            <div class="space-y-8">
                @foreach($quiz->questions as $index => $question)
                    <div class="border-b pb-6 last:border-b-0">
                        <div class="flex items-start mb-4">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-800 mr-3">
                                {{ $index + 1 }}
                            </span>
                            <h3 class="text-lg font-medium">{{ $question->question_text }}</h3>
                        </div>
                        
                        <div class="ml-11 space-y-3">
                            @foreach($question->answers as $answer)
                                <div class="flex items-center">
                                    <input type="radio" 
                                           id="answer-{{ $answer->id }}"
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $answer->id }}"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="answer-{{ $answer->id }}" class="ml-3 text-gray-700">
                                        {{ $answer->answer_text }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md shadow-sm">
                    Submit Quiz
                </button>
            </div>
        </form>
    </div>
</div>
@endsection