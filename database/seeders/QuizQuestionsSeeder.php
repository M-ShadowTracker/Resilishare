<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;

class QuizQuestionsSeeder extends Seeder
{
    public function run()
    {
        // Beginner Level Quiz (17 questions)
        $beginnerQuiz = Quiz::create([
            'title' => 'Cybersecurity Fundamentals',
            'description' => 'Basic cybersecurity concepts for beginners',
            'level' => 'beginner',
            'time_limit' => 20 // 20 minutes
        ]);

        $this->addBeginnerQuestions($beginnerQuiz);

        // Intermediate Level Quiz (12 questions)
        $intermediateQuiz = Quiz::create([
            'title' => 'Intermediate Cybersecurity',
            'description' => 'More challenging cybersecurity concepts',
            'level' => 'intermediate',
            'time_limit' => 15 
        ]);

        $this->addIntermediateQuestions($intermediateQuiz);

        // Advanced Level Quiz (7 questions)
        $advancedQuiz = Quiz::create([
            'title' => 'Advanced Cybersecurity',
            'description' => 'Expert-level cybersecurity challenges',
            'level' => 'advanced',
            'time_limit' => 10 
        ]);

        $this->addAdvancedQuestions($advancedQuiz);
    }

   protected function addBeginnerQuestions(Quiz $quiz)
{
    $questions = [
        [
            'question_text' => 'What is the most common method hackers use to gain access to systems?',
            'answers' => [
                ['text' => 'Phishing emails', 'is_correct' => true],
                ['text' => 'Brute force attacks', 'is_correct' => false],
                ['text' => 'Physical theft', 'is_correct' => false],
                ['text' => 'Social media posts', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which of these is the strongest password?',
            'answers' => [
                ['text' => 'password123', 'is_correct' => false],
                ['text' => 'P@ssw0rd!2023', 'is_correct' => true],
                ['text' => '12345678', 'is_correct' => false],
                ['text' => 'qwertyuiop', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What does HTTPS stand for?',
            'answers' => [
                ['text' => 'HyperText Transfer Protocol Secure', 'is_correct' => true],
                ['text' => 'HyperText Transfer Protocol Standard', 'is_correct' => false],
                ['text' => 'HyperText Transfer Protocol System', 'is_correct' => false],
                ['text' => 'HyperText Transfer Protocol Service', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which of the following is an example of two-factor authentication?',
            'answers' => [
                ['text' => 'Password only', 'is_correct' => false],
                ['text' => 'Password and fingerprint', 'is_correct' => true],
                ['text' => 'Username only', 'is_correct' => false],
                ['text' => 'Security question only', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is malware?',
            'answers' => [
                ['text' => 'A type of computer software that protects against threats', 'is_correct' => false],
                ['text' => 'Malicious software designed to harm or exploit systems', 'is_correct' => true],
                ['text' => 'A tool used to browse the internet', 'is_correct' => false],
                ['text' => 'An update to antivirus software', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which of the following helps protect against unauthorized access?',
            'answers' => [
                ['text' => 'Strong passwords', 'is_correct' => true],
                ['text' => 'Open Wi-Fi', 'is_correct' => false],
                ['text' => 'Sharing credentials', 'is_correct' => false],
                ['text' => 'Using the same password everywhere', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is a firewall used for?',
            'answers' => [
                ['text' => 'Preventing malware from spreading through email', 'is_correct' => false],
                ['text' => 'Blocking unauthorized access to or from a network', 'is_correct' => true],
                ['text' => 'Encrypting passwords', 'is_correct' => false],
                ['text' => 'Scanning documents', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which of the following is a safe practice?',
            'answers' => [
                ['text' => 'Clicking on links from unknown emails', 'is_correct' => false],
                ['text' => 'Installing software from trusted sources', 'is_correct' => true],
                ['text' => 'Disabling your antivirus', 'is_correct' => false],
                ['text' => 'Using public Wi-Fi for banking', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What does a VPN do?',
            'answers' => [
                ['text' => 'Makes your internet faster', 'is_correct' => false],
                ['text' => 'Provides a secure connection over the internet', 'is_correct' => true],
                ['text' => 'Infects computers with viruses', 'is_correct' => false],
                ['text' => 'Tracks your browsing', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which one is a phishing attempt?',
            'answers' => [
                ['text' => 'An email pretending to be from your bank asking for login info', 'is_correct' => true],
                ['text' => 'A news article on cybersecurity', 'is_correct' => false],
                ['text' => 'Your actual bank website', 'is_correct' => false],
                ['text' => 'An operating system update', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is an antivirus?',
            'answers' => [
                ['text' => 'A program that protects your computer from malware', 'is_correct' => true],
                ['text' => 'A hardware firewall', 'is_correct' => false],
                ['text' => 'A virus that protects other viruses', 'is_correct' => false],
                ['text' => 'A web browser', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What should you do if you receive a suspicious email?',
            'answers' => [
                ['text' => 'Click the link to see what it is', 'is_correct' => false],
                ['text' => 'Reply and ask for more info', 'is_correct' => false],
                ['text' => 'Report and delete it', 'is_correct' => true],
                ['text' => 'Forward it to friends', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Why should you keep your software updated?',
            'answers' => [
                ['text' => 'To make it look cooler', 'is_correct' => false],
                ['text' => 'To patch security vulnerabilities', 'is_correct' => true],
                ['text' => 'To remove antivirus', 'is_correct' => false],
                ['text' => 'To slow down your device', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is the purpose of a password manager?',
            'answers' => [
                ['text' => 'To manage your antivirus', 'is_correct' => false],
                ['text' => 'To safely store and create strong passwords', 'is_correct' => true],
                ['text' => 'To delete passwords', 'is_correct' => false],
                ['text' => 'To crack passwords', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which of these is an example of social engineering?',
            'answers' => [
                ['text' => 'Guessing a password', 'is_correct' => false],
                ['text' => 'Pretending to be IT support to trick someone', 'is_correct' => true],
                ['text' => 'Installing malware', 'is_correct' => false],
                ['text' => 'Scanning ports', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is two-step verification?',
            'answers' => [
                ['text' => 'Logging in with username only', 'is_correct' => false],
                ['text' => 'Using two different passwords', 'is_correct' => false],
                ['text' => 'Using a password and another form of verification', 'is_correct' => true],
                ['text' => 'Logging in from two devices', 'is_correct' => false],
            ]
        ],
    ];

    $this->addQuestionsToQuiz($quiz, $questions);
}


   protected function addIntermediateQuestions(Quiz $quiz)
{
    $questions = [
        [
            'question_text' => 'What is a zero-day vulnerability?',
            'answers' => [
                ['text' => 'A vulnerability that is exploited before the vendor is aware of it', 'is_correct' => true],
                ['text' => 'A vulnerability that only appears at midnight', 'is_correct' => false],
                ['text' => 'A vulnerability that has existed for zero days', 'is_correct' => false],
                ['text' => 'A vulnerability that affects time-based systems', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which of these is NOT a type of malware?',
            'answers' => [
                ['text' => 'Virus', 'is_correct' => false],
                ['text' => 'Worm', 'is_correct' => false],
                ['text' => 'Firewall', 'is_correct' => true],
                ['text' => 'Trojan', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What does the CIA triad stand for?',
            'answers' => [
                ['text' => 'Confidentiality, Integrity, Availability', 'is_correct' => true],
                ['text' => 'Control, Isolation, Access', 'is_correct' => false],
                ['text' => 'Communication, Identity, Authentication', 'is_correct' => false],
                ['text' => 'Code, Input, Authorization', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is the main purpose of penetration testing?',
            'answers' => [
                ['text' => 'To fix software bugs', 'is_correct' => false],
                ['text' => 'To simulate attacks and find vulnerabilities', 'is_correct' => true],
                ['text' => 'To monitor employee behavior', 'is_correct' => false],
                ['text' => 'To test backup systems', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is SQL injection?',
            'answers' => [
                ['text' => 'Injecting malicious SQL code into a database query', 'is_correct' => true],
                ['text' => 'A type of software patch', 'is_correct' => false],
                ['text' => 'An encrypted SQL message', 'is_correct' => false],
                ['text' => 'A SQL update method', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which tool is used to scan networks?',
            'answers' => [
                ['text' => 'Nmap', 'is_correct' => true],
                ['text' => 'Wireshark', 'is_correct' => false],
                ['text' => 'Photoshop', 'is_correct' => false],
                ['text' => 'PuTTY', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is the role of an IDS?',
            'answers' => [
                ['text' => 'To detect unauthorized activities in a network', 'is_correct' => true],
                ['text' => 'To install software updates', 'is_correct' => false],
                ['text' => 'To block IP addresses', 'is_correct' => false],
                ['text' => 'To create user accounts', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which protocol is used for secure web browsing?',
            'answers' => [
                ['text' => 'HTTP', 'is_correct' => false],
                ['text' => 'FTP', 'is_correct' => false],
                ['text' => 'HTTPS', 'is_correct' => true],
                ['text' => 'SMTP', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which port is used by SSH by default?',
            'answers' => [
                ['text' => '22', 'is_correct' => true],
                ['text' => '80', 'is_correct' => false],
                ['text' => '443', 'is_correct' => false],
                ['text' => '21', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is the function of hashing?',
            'answers' => [
                ['text' => 'Encrypting files', 'is_correct' => false],
                ['text' => 'Mapping data to a fixed-size value', 'is_correct' => true],
                ['text' => 'Compressing data', 'is_correct' => false],
                ['text' => 'Creating keys', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is social engineering in cybersecurity?',
            'answers' => [
                ['text' => 'Using malware to exploit networks', 'is_correct' => false],
                ['text' => 'Manipulating people to gain confidential info', 'is_correct' => true],
                ['text' => 'Running brute force attacks', 'is_correct' => false],
                ['text' => 'Designing user interfaces', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which standard is used for wireless security?',
            'answers' => [
                ['text' => 'WPA2', 'is_correct' => true],
                ['text' => 'FTP', 'is_correct' => false],
                ['text' => 'SMTP', 'is_correct' => false],
                ['text' => 'SSL', 'is_correct' => false],
            ]
        ],
    ];

    $this->addQuestionsToQuiz($quiz, $questions);
}

protected function addAdvancedQuestions(Quiz $quiz)
{
    $questions = [
        [
            'question_text' => 'In a PKI system, what is the purpose of a Certificate Revocation List (CRL)?',
            'answers' => [
                ['text' => 'To list certificates that are no longer valid before their expiration date', 'is_correct' => true],
                ['text' => 'To list all issued certificates', 'is_correct' => false],
                ['text' => 'To list certificates that have been renewed', 'is_correct' => false],
                ['text' => 'To list certificates that are about to expire', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is the primary purpose of salting in password hashing?',
            'answers' => [
                ['text' => 'To prevent rainbow table attacks', 'is_correct' => true],
                ['text' => 'To make passwords taste better', 'is_correct' => false],
                ['text' => 'To encrypt the password', 'is_correct' => false],
                ['text' => 'To compress password storage', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which algorithm is asymmetric encryption?',
            'answers' => [
                ['text' => 'RSA', 'is_correct' => true],
                ['text' => 'AES', 'is_correct' => false],
                ['text' => 'SHA-256', 'is_correct' => false],
                ['text' => 'MD5', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is lateral movement in a cyberattack?',
            'answers' => [
                ['text' => 'Spreading from one system to another in a network', 'is_correct' => true],
                ['text' => 'Downloading malware', 'is_correct' => false],
                ['text' => 'Brute-forcing login credentials', 'is_correct' => false],
                ['text' => 'Encrypting files for ransom', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which Linux command is used to capture network packets?',
            'answers' => [
                ['text' => 'tcpdump', 'is_correct' => true],
                ['text' => 'ls', 'is_correct' => false],
                ['text' => 'grep', 'is_correct' => false],
                ['text' => 'df', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'Which tool is used for reverse engineering?',
            'answers' => [
                ['text' => 'Ghidra', 'is_correct' => true],
                ['text' => 'Wireshark', 'is_correct' => false],
                ['text' => 'Burp Suite', 'is_correct' => false],
                ['text' => 'Metasploit', 'is_correct' => false],
            ]
        ],
        [
            'question_text' => 'What is a buffer overflow?',
            'answers' => [
                ['text' => 'A vulnerability caused by writing more data than a buffer can hold', 'is_correct' => true],
                ['text' => 'A full disk', 'is_correct' => false],
                ['text' => 'A memory upgrade', 'is_correct' => false],
                ['text' => 'A type of encryption', 'is_correct' => false],
            ]
        ],
    ];

    $this->addQuestionsToQuiz($quiz, $questions);
}
    protected function addQuestionsToQuiz(Quiz $quiz, array $questions)
    {
        foreach ($questions as $questionData) {
            $question = QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text']
            ]);

            foreach ($questionData['answers'] as $answerData) {
                QuizAnswer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerData['text'],
                    'is_correct' => $answerData['is_correct']
                ]);
            }
        }
    }
}