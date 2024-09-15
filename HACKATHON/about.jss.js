document.getElementById('read-more-btn').addEventListener('click', function() {
    var moreContent = document.querySelector('.more-content');
    if (moreContent.style.display === 'none' || moreContent.style.display === '') {
        moreContent.style.display = 'block';
        this.textContent = 'Show Less';
    } else {
        moreContent.style.display = 'none';
        this.textContent = 'Read More';
    }
});
