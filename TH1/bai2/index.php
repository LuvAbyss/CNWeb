<?php
// Đường dẫn tới file câu hỏi
$filename = 'Quiz.txt';
$questions = [];

// HÀM PHÂN TÍCH FILE CẤU TRÚC (PARSER)
// Đọc file và chuyển đổi thành mảng dữ liệu có cấu trúc
function loadQuestions($filepath) {
    if (!file_exists($filepath)) {
        return [];
    }

    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $questions = [];
    $currentQuestion = [
        'id' => 0,
        'text' => '',
        'options' => [],
        'correct_answers' => []
    ];
    $count = 0;

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Nếu gặp dòng bắt đầu bằng "ANSWER:", đây là kết thúc của một câu hỏi
        if (strpos($line, 'ANSWER:') === 0) {
            // Lấy phần đáp án phía sau dấu hai chấm
            $ansStr = trim(substr($line, 7));
            // Tách các đáp án (ví dụ: "A, C" -> ['A', 'C'])
            $currentQuestion['correct_answers'] = array_map('trim', explode(',', $ansStr));
            $currentQuestion['id'] = ++$count;
            
            // Lưu câu hỏi vào danh sách
            $questions[] = $currentQuestion;
            
            // Reset biến tạm để đón câu hỏi mới
            $currentQuestion = [
                'id' => 0,
                'text' => '',
                'options' => [],
                'correct_answers' => []
            ];
        } 
        // Kiểm tra xem dòng này có phải là phương án lựa chọn (A., B., C., D.) không
        // Regex: Bắt đầu bằng chữ cái in hoa, theo sau là dấu chấm
        elseif (preg_match('/^([A-Z])\.(.*)/', $line, $matches)) {
            $key = $matches[1]; // A, B, C...
            $content = trim($matches[2]); // Nội dung phương án
            $currentQuestion['options'][$key] = $content;
        } 
        // Nếu không phải hai trường hợp trên, thì là nội dung câu hỏi
        else {
            // Nối thêm vào nội dung câu hỏi (xử lý câu hỏi nhiều dòng)
            $currentQuestion['text'] .= ($currentQuestion['text'] === '' ? '' : '<br>') . $line;
        }
    }
    return $questions;
}

// Tải câu hỏi
$questions = loadQuestions($filename);

// XỬ LÝ KHI NGƯỜI DÙNG NỘP BÀI
$isSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');
$userAnswers = $isSubmitted ? ($_POST['q'] ?? []) : [];
$totalScore = 0;
$totalQuestions = count($questions);

if ($isSubmitted) {
    foreach ($questions as $index => $q) {
        // Lấy đáp án người dùng chọn cho câu này (mảng các ký tự A, B...)
        $uAns = isset($userAnswers[$index]) ? $userAnswers[$index] : [];
        if (!is_array($uAns)) $uAns = [$uAns]; // Chuẩn hóa thành mảng

        // So sánh: Đáp án đúng và đáp án chọn phải giống hệt nhau (không thừa không thiếu)
        // array_diff trả về các phần tử khác nhau, nếu rỗng cả 2 chiều là đúng
        $diff1 = array_diff($q['correct_answers'], $uAns);
        $diff2 = array_diff($uAns, $q['correct_answers']);
        
        if (empty($diff1) && empty($diff2)) {
            $totalScore++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Thi Trắc Nghiệm Android</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #eef2f5; }
        .quiz-container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .question-block { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px dashed #ddd; }
        .question-title { font-weight: 600; color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .form-check-label { cursor: pointer; width: 100%; }
        .form-check { padding: 8px 10px 8px 35px; border-radius: 5px; margin-bottom: 5px; transition: background 0.2s; }
        .form-check:hover { background-color: #f8f9fa; }
        
        /* Styles cho kết quả */
        .result-box { background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; border: 1px solid #c3e6cb; }
        .correct-opt { background-color: #d1e7dd !important; border-left: 4px solid #198754; }
        .wrong-opt { background-color: #f8d7da !important; border-left: 4px solid #dc3545; }
        .missed-opt { border: 2px dashed #198754; opacity: 0.7; } /* Đáp án đúng mà không chọn */
        .badge-result { font-size: 0.9em; margin-left: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="quiz-container">
        <h1 class="text-center mb-4 text-primary">📝 Bài Thi Trắc Nghiệm Android</h1>
        
        <?php if (empty($questions)): ?>
            <div class="alert alert-danger">
                Không tìm thấy file <strong>Quiz.txt</strong> hoặc file rỗng. Vui lòng tạo file cùng thư mục với script này.
            </div>
        <?php else: ?>

            <?php if ($isSubmitted): ?>
                <div class="result-box">
                    <h3>Kết quả của bạn</h3>
                    <div class="display-4 fw-bold"><?php echo $totalScore; ?> / <?php echo $totalQuestions; ?></div>
                    <p>Câu trả lời đúng</p>
                    <a href="quiz.php" class="btn btn-primary mt-2">Làm lại bài thi</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <?php foreach ($questions as $index => $q): ?>
                    <?php 
                        // Xác định loại input: Nếu có nhiều đáp án đúng -> Checkbox, ngược lại -> Radio
                        $inputType = count($q['correct_answers']) > 1 ? 'checkbox' : 'radio';
                        $inputName = "q[$index]" . ($inputType == 'checkbox' ? '[]' : '');
                        
                        // Lấy trạng thái trả lời của user cho câu này
                        $userSelected = $isSubmitted ? ($userAnswers[$index] ?? []) : [];
                        if (!is_array($userSelected)) $userSelected = [$userSelected];
                        
                        // Kiểm tra đúng sai để hiển thị badge
                        $isCorrect = false;
                        if ($isSubmitted) {
                            $diff1 = array_diff($q['correct_answers'], $userSelected);
                            $diff2 = array_diff($userSelected, $q['correct_answers']);
                            $isCorrect = empty($diff1) && empty($diff2);
                        }
                    ?>

                    <div class="question-block" id="q-<?php echo $index; ?>">
                        <div class="question-title">
                            Câu <?php echo $q['id']; ?>: <?php echo $q['text']; ?>
                            <?php if ($isSubmitted): ?>
                                <?php if ($isCorrect): ?>
                                    <span class="badge bg-success badge-result">Đúng</span>
                                <?php else: ?>
                                    <span class="badge bg-danger badge-result">Sai</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php foreach ($q['options'] as $key => $val): ?>
                            <?php 
                                $class = '';
                                $checked = in_array($key, $userSelected) ? 'checked' : '';
                                
                                if ($isSubmitted) {
                                    $isKeyCorrect = in_array($key, $q['correct_answers']);
                                    $isKeySelected = in_array($key, $userSelected);

                                    // Logic tô màu
                                    if ($isKeyCorrect && $isKeySelected) {
                                        $class = 'correct-opt'; // Chọn đúng
                                    } elseif ($isKeySelected && !$isKeyCorrect) {
                                        $class = 'wrong-opt'; // Chọn sai
                                    } elseif ($isKeyCorrect && !$isKeySelected) {
                                        $class = 'missed-opt'; // Đáp án đúng nhưng chưa chọn
                                    }
                                }
                            ?>
                            <div class="form-check <?php echo $class; ?>">
                                <input class="form-check-input" type="<?php echo $inputType; ?>" 
                                       name="<?php echo $inputName; ?>" 
                                       value="<?php echo $key; ?>" 
                                       id="q<?php echo $index; ?>_<?php echo $key; ?>"
                                       <?php echo $checked; ?>
                                       <?php echo $isSubmitted ? 'disabled' : ''; // Khóa input khi đã nộp ?> 
                                >
                                <label class="form-check-label" for="q<?php echo $index; ?>_<?php echo $key; ?>">
                                    <strong><?php echo $key; ?>.</strong> <?php echo $val; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if ($isSubmitted && !$isCorrect): ?>
                            <div class="mt-2 text-success small fw-bold">
                                Đáp án đúng: <?php echo implode(', ', $q['correct_answers']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php if (!$isSubmitted): ?>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Nộp Bài</button>
                    </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>