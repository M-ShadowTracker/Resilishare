@extends('layouts.app')

@section('title', 'Manage Quizzes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Manage Quizzes</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Add New Quiz</h2>
        <form action="{{ route('admin.quizzes.add') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" id="title" name="title" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="level" class="block text-gray-700 font-semibold mb-2">Level</label>
                    <select id="level" name="level" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="time_limit" class="block text-gray-700 font-semibold mb-2">Time Limit (minutes)</label>
                <input type="number" id="time_limit" name="time_limit" min="1" value="10" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Add Quiz
            </button>
        </form>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">All Quizzes</h2>
        
        @foreach($quizzes as $quiz)
        <div class="border-b pb-4 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold">{{ $quiz->title }}</h3>
                    <p class="text-gray-600 mb-2">{{ $quiz->description }}</p>
                    <div class="flex space-x-4 text-sm">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Level: {{ ucfirst($quiz->level) }}</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Time: {{ $quiz->time_limit }} min</span>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">Questions: {{ $quiz->questions->count() }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <h4 class="font-semibold mb-2">Add Question</h4>
                <form action="{{ route('admin.quizzes.add-question', $quiz->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Question Text</label>
                        <input type="text" name="question_text" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Answers</label>
                        <div class="space-y-2">
                            @for($i = 0; $i < 4; $i++)
                            <div class="flex items-center">
                                <input type="radio" name="correct_answer" value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }}
                                    class="mr-2">
                                <input type="text" name="answers[]" required
                                    class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            @endfor
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Add Question
                    </button>
                </form>
            </div>
            
            @if($quiz->questions->count() > 0)
            <div class="mt-4">
                <h4 class="font-semibold mb-2">Questions</h4>
                <div class="space-y-4">
                    @foreach($quiz->questions as $question)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="font-medium">{{ $question->question_text }}</p>
                        <div class="mt-2 ml-4 space-y-1">
                            @foreach($question->answers as $answer)
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full mr-2 border border-gray-400 {{ $answer->is_correct ? 'bg-green-500 border-green-500' : '' }}"></span>
                                <span class="{{ $answer->is_correct ? 'font-semibold text-green-700' : '' }}">{{ $answer->answer_text }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection