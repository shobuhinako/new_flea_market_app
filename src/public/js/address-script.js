document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('back-button').addEventListener('click', function() {
        const itemId = document.getElementById('item_id').value;
        window.location.href = `/confirm_purchase/${itemId}`;
    });
});


