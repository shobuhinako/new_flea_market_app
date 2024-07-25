document.addEventListener('DOMContentLoaded', (event) => {
    const tablinks = document.querySelectorAll('.tablinks');
    tablinks.forEach(tab => {
        tab.addEventListener('click', (e) => {
            openTab(e, tab.getAttribute('data-tab'));
        });
    });

    // "全て" ボタンをデフォルトでクリックした状態にする
    document.getElementById("defaultOpen").click();

    // フィルタークリアボタンのクリックイベントを追加
    document.getElementById('clearFilters').addEventListener('click', function() {
        const url = new URL(window.location);
        url.searchParams.delete('category');
        url.searchParams.delete('sort');
        url.searchParams.delete('status');
        window.history.pushState({}, '', url);
        
        // ページをリロードしてフィルターをクリア
        window.location.reload();
    });
});

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    
    // タブのコンテンツを全て非表示にする
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    
    // タブリンクの "active" クラスを全て削除する
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // 選択されたタブを表示し、リンクに "active" クラスを追加する
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
