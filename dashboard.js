document.querySelectorAll('.load-content a').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        fetch(this.getAttribute('href'))
            .then(response => response.text())
            .then(data => {
                document.getElementById('content').innerHTML = data;
            })
            .catch(error => console.error('Error loading content:', error));
    });
});