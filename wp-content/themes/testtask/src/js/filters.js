document.addEventListener('DOMContentLoaded', function() {
    const filterContainers = document.querySelectorAll('.js-album-filter-container');

    function filterPosts(skip = true, loadMore = true, section = this.closest('.js-album-filter-container')) {
        const filterForm = section.querySelector('.js-album-filter-form');
        const albumsList = section.querySelector('.js-albums-list');
        const loadMoreButton = section.querySelector('.js-filters__loadmore');
        const skipInput = section.querySelector('.js-skip');
        const ajaxUrl = ajax.ajaxUrl;
        if (skip) {
            skipInput.value = 0;
        }
        const formData = new FormData(filterForm);
        formData.append('action', 'filter_albums');
        formData.append('skip', skipInput.value);
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (!loadMore) albumsList.innerHTML = '';
                albumsList.innerHTML += data.data;


                skipInput.value = data.skip;

                // Optionally, handle 'hide more' logic
                if (data.hide_more) {
                    if (loadMoreButton) {
                        loadMoreButton.style.display = 'none';
                        loadMoreButton.disabled = true;
                    }
                } else {
                    if (loadMoreButton) {
                        loadMoreButton.style.display = 'flex';
                        loadMoreButton.disabled = false;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }


    // Event listeners
    filterContainers.forEach(container => {
        const filterForm = this.querySelector('.js-album-filter-form');
        const loadMore = this.querySelector('.js-filters__loadmore');
        filterForm.addEventListener('change',  () => {
             filterPosts(true, false, container);
        });
        loadMore.addEventListener('click', function () {
            filterPosts(false, true, container);
        });
    })
});