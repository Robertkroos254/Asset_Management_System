document.addEventListener('DOMContentLoaded', function() {
    const usersLink = document.querySelector('.load-content a[href="signup.html"]');
    const contentContainer = document.querySelector('.load-content');

    if (usersLink && contentContainer) {
        usersLink.addEventListener('click', function(event) {
            event.preventDefault();

            fetch('signup.html')
                .then(response => response.text())
                .then(data => {
                    contentContainer.innerHTML = data;
                })
                .catch(error => console.error('Error loading content:', error));
        });
    }
});