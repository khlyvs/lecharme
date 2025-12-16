


document.getElementById('adminSearch').addEventListener('keyup', function () {
    const query = this.value.trim();
    const tableBody = document.querySelector('#kt_customers_table tbody');

    if (query.length < 2) {
        return; // çox qısa olduqda axtarma
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/search_admins.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        tableBody.innerHTML = this.responseText;
    };
    xhr.send('query=' + encodeURIComponent(query));
});
if (query.length < 2) {
    // AJAX ilə bütün adminləri yüklə və bərpa et
    fetch('ajax/search_admins.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'query=' // boş göndəririk
    })
    .then(response => response.text())
    .then(data => {
        tableBody.innerHTML = data;
    });
    return;
}
