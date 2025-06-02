<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show quiz selection
public function showQuizSelection()
{
    // Get specific quizzes by their question counts
    $quizzes = [
        'beginner' => Quiz::withCount('questions')
                        ->where('level', 'beginner')
                        ->having('questions_count', 16)
                        ->first(),
        'intermediate' => Quiz::withCount('questions')
                        ->where('level', 'intermediate')
                        ->having('questions_count', 12)
                        ->first(),
        'advanced' => Quiz::withCount('questions')
                        ->where('level', 'advanced')
                        ->having('questions_count', 7)
                        ->first()
    ];
    
    return view('user.quiz', ['quizzes' => $quizzes]);
}


    // Start quiz
   public function startQuiz($quizId)
{
    $quiz = Quiz::with(['questions' => function($query) {
        $query->with(['answers' => function($q) {
            $q->orderBy('id'); // Consistent order
        }]);
    }])->findOrFail($quizId);

    $user = Auth::user();

    $activeAttempt = QuizAttempt::firstOrCreate([
        'user_id' => $user->id,
        'quiz_id' => $quiz->id,
        'completed_at' => null
    ], [
        'started_at' => now(),
        'score' => 0
    ]);

    return view('user.quiz-attempt', [
        'quiz' => $quiz,
        'activeAttempt' => $activeAttempt
    ]);
}

    // Submit quiz answers
    public function submitQuiz(Request $request, $quizId, $attemptId)
    {
        $quiz = Quiz::with(['questions.answers'])->findOrFail($quizId);
        $attempt = QuizAttempt::where('user_id', Auth::id())
            ->where('id', $attemptId)
            ->whereNull('completed_at')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id])) {
                $selectedAnswer = $question->answers->firstWhere('id', $answers[$question->id]);
                if ($selectedAnswer && $selectedAnswer->is_correct) {
                    $score++;
                }
            }
        }

        $attempt->update([
            'score' => $score,
            'completed_at' => now(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Quiz completed! Your score: ' . $score . '/' . $quiz->questions->count());
    }

    // View quiz results
    public function viewResults($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz.questions.answers', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($attemptId);

        return view('user.quiz-results', compact('attempt'));
    }
    public function importQuiz(Request $request)
{
    $request->validate([
        'quiz_file' => 'required|file|mimetypes:application/json'
    ]);

    $data = json_decode(file_get_contents($request->file('quiz_file')->getRealPath()), true);

    $quiz = Quiz::create([
        'title' => $data['quiz_title'],
        'description' => $data['description'] ?? '',
        'level' => $data['level'],
        'time_limit' => $data['time_limit']
    ]);

    foreach ($data['questions'] as $questionData) {
        $question = $quiz->questions()->create([
            'question_text' => $questionData['question_text']
        ]);

        foreach ($questionData['answers'] as $answerData) {
            $question->answers()->create([
                'answer_text' => $answerData['text'],
                'is_correct' => $answerData['is_correct']
            ]);
        }
    }

    return redirect()->back()->with('success', 'Quiz imported successfully!');
}
}