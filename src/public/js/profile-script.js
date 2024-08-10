// $(document).ready(function() {
//     $('#form-image').on('change', function(event) {
//         const input = event.target;
//         const fileNameDisplay = $('#file-name');

//         if (input.files && input.files[0]) {
//             const fileName = input.files[0].name;
//             fileNameDisplay.text(fileName);

//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 $('.rounded__image').attr('src', e.target.result);
//             };
//             reader.readAsDataURL(input.files[0]);
//         } else {
//             fileNameDisplay.text('');
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    // 画像ファイル選択処理
    var imageInput = document.getElementById('form-image');
    var fileNameDisplay = document.getElementById('file-name');
    var profileImage = document.querySelector('.rounded__image');

    imageInput.addEventListener('change', function(event) {
        const input = event.target;

        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            fileNameDisplay.textContent = fileName;

            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            fileNameDisplay.textContent = '';
        }
    });

    // 住所自動入力処理
    var postInput = document.querySelector('input[name="post"]');
    var addressInput = document.querySelector('input[name="address"]');

    postInput.addEventListener('blur', function () {
        var postCode = postInput.value.replace(/[^0-9]/g, ''); // 郵便番号を数字のみ抽出
        if (postCode.length === 7) { // 郵便番号が7桁の場合
            fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.results) {
                        var result = data.results[0];
                        var address = `${result.address1}${result.address2}${result.address3}`;
                        addressInput.value = address;
                    } else {
                        alert('住所が見つかりませんでした。郵便番号を確認してください。');
                    }
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                });
        }
    });

    // バックボタン処理 (必要に応じて)
    var backButton = document.getElementById('back-button');
    if (backButton) {
        backButton.addEventListener('click', function() {
            window.history.back(); // 前のページに戻る
        });
    }
});
