function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    // 全てのタブコンテンツを非表示にする
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // 全てのタブリンクのアクティブクラスを削除する
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // 指定されたタブを表示する
    document.getElementById(tabName).style.display = "block";

    // 指定されたタブリンクにアクティブクラスを追加する
    evt.currentTarget.className += " active";
}

    // ドキュメントが読み込まれた後に実行する
    document.addEventListener('DOMContentLoaded', function () {
    // デフォルトのタブを開く
    document.getElementById("defaultOpen").click();

    // ❓ボタンのクリックイベントリスナーを追加
    var infoIcon = document.getElementById('info-icon');
    var infoPopup = document.getElementById('info-popup');

    if (infoIcon && infoPopup) {
        infoIcon.addEventListener('click', function() {
            // ポップアップが表示されているかどうかを確認
            if (infoPopup.style.display === 'block') {
                infoPopup.style.display = 'none';
            } else {
                infoPopup.style.display = 'block';
            }
        });

        // ポップアップの外側をクリックしたらポップアップを閉じる
        document.addEventListener('click', function(event) {
            if (!infoIcon.contains(event.target) && !infoPopup.contains(event.target)) {
                infoPopup.style.display = 'none';
            }
        });
    }
});
