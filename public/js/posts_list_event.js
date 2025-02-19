document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#home-button').addEventListener('click', () => {
        window.location.href = '/';
    });

    document.querySelector('#write-post').addEventListener('click', () => {
        window.location.href = '/post/write';
    });
});