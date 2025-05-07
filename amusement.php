<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>놀이공원 티켓 예매</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { width: 500px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        select { width: 45px; }
        .receipt { margin-top: 15px; font-size: 14px; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            고객성명 <input type="text" name="customer_name" required>
            <input type="submit" value="확인">
            
            <table>
                <tr>
                    <th>No</th>
                    <th>구분</th>
                    <th>어린이</th>
                    <th></th>
                    <th>어른</th>
                    <th></th>
                    <th>비고</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>입장권</td>
                    <td>7,000</td>
                    <td>
                        <select name="child_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>10,000</td>
                    <td>
                        <select name="adult_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>입장</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>BIG3</td>
                    <td>12,000</td>
                    <td>
                        <select name="child_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>16,000</td>
                    <td>
                        <select name="adult_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>입장+놀이3종</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>자유이용권</td>
                    <td>21,000</td>
                    <td>
                        <select name="child_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>26,000</td>
                    <td>
                        <select name="adult_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>입장+놀이자유</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>연간이용권</td>
                    <td>70,000</td>
                    <td>
                        <select name="child_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>90,000</td>
                    <td>
                        <select name="adult_qty[]">
                            <?php for($i=0; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($i==1) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                    <td>입장+놀이자유</td>
                </tr>
            </table>
        </form>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['customer_name'])) {
            $customer_name = htmlspecialchars($_POST['customer_name']);
            $child_qty = isset($_POST['child_qty']) ? $_POST['child_qty'] : [0, 0, 0, 0];
            $adult_qty = isset($_POST['adult_qty']) ? $_POST['adult_qty'] : [0, 0, 0, 0];
            
            $ticket_types = ['입장권', 'BIG3', '자유이용권', '연간이용권'];
            $child_prices = [7000, 12000, 21000, 70000];
            $adult_prices = [10000, 16000, 26000, 90000];
            
            $total_price = 0;
            $items = [];
            
            for ($i = 0; $i < 4; $i++) {
                if ($child_qty[$i] > 0) {
                    $total_price += $child_prices[$i] * $child_qty[$i];
                    $items[] = "어린이 {$ticket_types[$i]} {$child_qty[$i]}매";
                }
                if ($adult_qty[$i] > 0) {
                    $total_price += $adult_prices[$i] * $adult_qty[$i];
                    $items[] = "어른 {$ticket_types[$i]} {$adult_qty[$i]}매";
                }
            }
            
            // 영수증 출력
            if ($total_price > 0) {
                echo '<div class="receipt">';
                echo date("Y년 m월 d일 A h:i") . "<br>";
                echo "{$customer_name} 고객님 감사합니다.<br>";
                foreach ($items as $item) {
                    echo $item . "<br>";
                }
                echo "총액 " . number_format($total_price) . "원입니다.";
                echo '</div>';
            }
        }
        
        // 샘플 영수증 (캡쳐화면 예시와 유사하게)
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo '<div class="receipt">';
            echo "2019년 3월 31일 오후 8:30분<br>";
            echo "OOO 고객님 감사합니다.<br>";
            echo "어린이 입장권 1매<br>";
            echo "어른 BIG3 2매<br>";
            echo "총액 39,000원입니다.";
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
