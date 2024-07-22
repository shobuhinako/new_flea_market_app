document.addEventListener('DOMContentLoaded', function () {
    var postInput = document.getElementById('post');
    postInput.addEventListener('blur', function () {
        var postCode = postInput.value.replace(/[^0-9]/g, ''); // 郵便番号を数字のみ抽出
        if (postCode.length === 7) { // 郵便番号が7桁の場合
            fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.results) {
                        var result = data.results[0];
                        var address = `${result.address1}${result.address2}${result.address3}`;
                        document.getElementById('address').value = address;
                    } else {
                        alert('住所が見つかりませんでした。郵便番号を確認してください。');
                    }
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                });
        }
    });

    document.getElementById('back-button').addEventListener('click', function() {
        const itemId = document.getElementById('item_id').value;
        window.location.href = `/confirm_purchase/${itemId}`;
    });
});

