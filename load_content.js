// document.addEventListener('DOMContentLoaded', function() {
//     const usersLink = document.querySelector('.load-content a[href="signup.html"]');
//     const contentContainer = document.querySelector('.load-content');

//     if (usersLink && contentContainer) {
//         usersLink.addEventListener('click', function(event) {
//             event.preventDefault();

//             fetch('signup.html')
//                 .then(response => response.text())
//                 .then(data => {
//                     contentContainer.innerHTML = data;
//                 })
//                 .catch(error => console.error('Error loading content:', error));
//         });
//     }
// });





document.querySelectorAll('.load-content a').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                let url = this.getAttribute('href');
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('.content') ? doc.querySelector('.content').innerHTML : doc.body.innerHTML;
                        
                        document.querySelector('.content').innerHTML = `
                            <div class="fetched-content-container">
                                ${newContent}
                            </div>
                        `;

                        // Initialize AOS
                        AOS.init();

                        // Initialize DataTables
                        if (document.querySelector('#staffTable')) {
                            $('#staffTable').DataTable({
                                "paging": true,
                                "searching": true,
                                "info": true,
                                "autoWidth": false
                            });
                        }

                        if (document.querySelector('#assetTable')) {
                            $('#assetTable').DataTable({
                                "paging": true,
                                "searching": true,
                                "info": true,
                                "autoWidth": false
                            });
                        }
                        if (document.querySelector('#deleteLogTable')) {
                            $('#deleteLogTable').DataTable({
                                "paging": true,
                                "searching": true,
                                "info": true,
                                "autoWidth": false
                            });
                        }

                        // Make the new content visible
                        if (document.querySelector('.container-dep')) {
                            $(window).on('load', function () {
                                $('.container-dep').addClass('visible');
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading content:', error);
                        document.querySelector('.content').innerHTML = '<h1>Error</h1><p>Failed to load content. Please try again later.</p>';
                    });
            });
        });

        // Add hover effect to shift main content
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');

        sidebar.addEventListener('mouseenter', () => {
            content.style.marginLeft = '250px'; // Adjust the value based on the expanded width
        });

        sidebar.addEventListener('mouseleave', () => {
            content.style.marginLeft = '70px'; // Reset to original position
        });