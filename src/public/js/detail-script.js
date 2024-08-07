document.addEventListener('DOMContentLoaded', function () {
    // すべての info-icon 要素を取得
    const infoIcons = document.querySelectorAll('.info-icon');

    infoIcons.forEach(icon => {
        // アイコンがクリックされたときの処理
        icon.addEventListener('click', function () {
            const popup = this.nextElementSibling; // info-icon の次にある info-popup 要素を取得
            if (popup.style.display === 'block') {
                // すでに表示されている場合は非表示にする
                popup.style.display = 'none';
            } else {
                // 非表示の場合は表示する
                popup.style.display = 'block';
            }
        });

        // ドキュメント内でクリックされた場合、ポップアップを非表示にする
        document.addEventListener('click', function (event) {
            if (!icon.contains(event.target) && !icon.nextElementSibling.contains(event.target)) {
                // アイコンやポップアップ以外の部分がクリックされた場合
                icon.nextElementSibling.style.display = 'none';
            }
        });
    });
});



