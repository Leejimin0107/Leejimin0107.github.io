function calculateOrder() {
    // 메뉴 항목과 가격 정의 (HTML의 id와 일치해야 합니다)
    const menu = {
        americano: { name: '아메리카노', price: 3500 },
        latte: { name: '카페라떼', price: 4000 },
        cappuccino: { name: '카푸치노', price: 4250 },
        mocha: { name: '카페모카', price: 4500 },
        espresso: { name: '에스프레소', price: 3000 },
        croissant: { name: '크루아상', price: 3200 },
        muffin: { name: '머핀', price: 2750 }
    };

    let total = 0; // 총 비용 초기화
    let receiptHtml = ''; // 영수증 내용을 담을 HTML 문자열

    // 각 메뉴 항목의 수량을 확인하고 총액 계산 및 영수증 항목 생성
    for (const itemKey in menu) {
        const quantityInput = document.getElementById(itemKey);

        if (quantityInput) {
            const quantity = parseInt(quantityInput.value);
            const item = menu[itemKey]; // 메뉴 객체에서 해당 항목 가져오기

            if (!isNaN(quantity) && quantity > 0) { // 수량이 0보다 클 경우만 계산 및 영수증에 추가
                const subtotal = quantity * item.price;
                total += subtotal;

                // 영수증 항목 추가
                receiptHtml += `
                    <div class="receipt-item">
                        <span class="name-qty">${item.name} x ${quantity}</span>
                        <span class="subtotal">${subtotal.toLocaleString()}원</span>
                    </div>
                `;
            } else if (isNaN(quantity)) {
                // 유효하지 않은 숫자 입력 처리 (예: 0으로 설정)
                console.warn(`${item.name}에 유효하지 않은 수량이 입력되었습니다. 0으로 간주합니다.`);
                quantityInput.value = 0;
            }
        }
    }

    // 총액 표시 업데이트
    document.getElementById('totalAmount').innerText = `총액: ${total.toLocaleString()}원`;

    // 영수증 영역 업데이트
    const receiptArea = document.getElementById('receiptArea');
    const receiptItems = document.getElementById('receiptItems');
    const receiptFinalTotal = document.getElementById('receiptFinalTotal');
    const receiptDate = document.getElementById('receiptDate');

    if (total > 0) { // 총액이 0보다 클 때만 영수증 표시
        receiptItems.innerHTML = receiptHtml; // 영수증 항목들 삽입
        receiptFinalTotal.innerText = `${total.toLocaleString()}원`; // 최종 총액 표시

        // 현재 날짜 및 시간 설정
        const now = new Date();
        const dateTimeString = `${now.getFullYear()}년 ${now.getMonth() + 1}월 ${now.getDate()}일 ` +
                               `${now.getHours()}시 ${now.getMinutes()}분 ${now.getSeconds()}초`;
        receiptDate.innerText = `결제일시: ${dateTimeString}`;

        receiptArea.style.display = 'block'; // 영수증 영역 보이기
    } else {
        receiptArea.style.display = 'none'; // 총액이 0이면 영수증 숨기기
    }
}