<?php
// DB 접속 정보 (root, 비번 없음)
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'amusement';

// MySQL 연결
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// 티켓 종류 및 가격
$ticket_types = ['입장권', 'BIG3', '자유이용권', '연간이용권'];
$child_prices = [7000, 12000, 21000, 70000];
$adult_prices = [10000, 18000, 28000, 90000];
$descs = ['입장', '입장+이용3종', '입장+이용자유', '입장+이용자유'];

// POST 값 초기화
$customer_name = $_POST['customer_name'] ?? '';
$child_qty = $_POST['child_qty'] ?? [1, 0, 0, 0];
$adult_qty = $_POST['adult_qty'] ?? [1, 0, 0, 0];

$items = [];
$total_price = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < count($ticket_types); $i++) {
        $c = intval($child_qty[$i]);
        $a = intval($adult_qty[$i]);
        if ($c > 0) {
            $total_price += $child_prices[$i] * $c;
            $items[] = "어린이 {$ticket_types[$i]} {$c}매";
        }
        if ($a > 0) {
            $total_price += $adult_prices[$i] * $a;
            $items[] = "어른 {$ticket_types[$i]} {$a}매";
        }
    }

    // DB 저장 (항상 새로 저장, 덮어쓰기 X)
    if (!empty($customer_name)) {
        $sql = "INSERT INTO amusement 
            (name, enter_child, enter_adult, big3_child, big3_adult, free_child, free_adult, year_child, year_adult)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "siiiiiiii",
            $customer_name,
            $child_qty[0], $adult_qty[0],
            $child_qty[1], $adult_qty[1],
            $child_qty[2], $adult_qty[2],
            $child_qty[3], $adult_qty[3]
        );
        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>놀이공원 예매</title>
    <style>
        table { border-collapse: collapse; }
        th, td { border: 1px solid #888; padding: 5px 10px; text-align: center; }
        th { background: #eee; }
        .receipt { margin-top: 20px; font-family: '굴림', monospace; }
        input[type="text"] { width: 100px; }
    </style>
</head>
<body>
<form method="post">
    고객성명 <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>">
    <input type="submit" value="합계"><br><br>
    <table>
        <tr>
            <th>No</th>
            <th>구분</th>
            <th>어린이</th>
            <th>어른</th>
            <th>비고</th>
        </tr>
        <?php for ($i = 0; $i < count($ticket_types); $i++): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $ticket_types[$i] ?></td>
            <td>
                <select name="child_qty[]">
                    <?php for ($j = 0; $j <= 5; $j++): ?>
                        <option value="<?= $j ?>" <?= (isset($child_qty[$i]) && $child_qty[$i] == $j) ? 'selected' : '' ?>>
                            <?= $j ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <?= number_format($child_prices[$i]) ?>
            </td>
            <td>
                <select name="adult_qty[]">
                    <?php for ($j = 0; $j <= 5; $j++): ?>
                        <option value="<?= $j ?>" <?= (isset($adult_qty[$i]) && $adult_qty[$i] == $j) ? 'selected' : '' ?>>
                            <?= $j ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <?= number_format($adult_prices[$i]) ?>
            </td>
            <td><?= $descs[$i] ?></td>
        </tr>
        <?php endfor; ?>
    </table>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $total_price > 0): ?>
    <div class="receipt">
        <?= date("Y년 n월 j일 A g:i") ?><br>
        <?= htmlspecialchars($customer_name) ?> 고객님 감사합니다.<br>
        <?php foreach ($items as $item): ?>
            <?= $item ?><br>
        <?php endforeach; ?>
        합계 <?= number_format($total_price) ?>원입니다.
    </div>
<?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>
