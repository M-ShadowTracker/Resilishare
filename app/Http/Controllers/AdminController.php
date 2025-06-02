<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\FileLink;
use App\Models\URLTest;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', IsAdmin::class]);
    }

    // Admin dashboard
    public function dashboard()
    {
        $usersCount = User::where('is_admin', false)->count();
        $quizzesCount = Quiz::count();
        $filesCount = FileLink::count();
        $urlTestsCount = URLTest::count();

        return view('admin.dashboard', compact('usersCount', 'quizzesCount', 'filesCount', 'urlTestsCount'));
    }

    // Manage quizzes
    public function manageQuizzes()
    {
        $quizzes = Quiz::with(['questions.answers'])->get();
        return view('admin.manage-quizzes', compact('quizzes'));
    }

    // Add new quiz
    public function addQuiz(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'time_limit' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create($validated);

        return redirect()->back()->with('success', 'Quiz added successfully!');
    }

    // Add question to quiz
    public function addQuestion(Request $request, $quizId)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|integer',
            'answers' => 'required|array|min:2',
            'answers.*' => 'required|string',
        ]);

        $quiz = Quiz::findOrFail($quizId);
        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
        ]);

        foreach ($validated['answers'] as $index => $answerText) {
            $question->answers()->create([
                'answer_text' => $answerText,
                'is_correct' => $index == $validated['correct_answer'],
            ]);
        }

        return redirect()->back()->with('success', 'Question added successfully!');
    }

    // Manage files
    public function manageFiles()
    {
        $files = FileLink::with('user')->get();
        return view('admin.manage-files', compact('files'));
    }

    // Delete file
    public function deleteFile($fileId)
    {
        $file = FileLink::findOrFail($fileId);
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }
}