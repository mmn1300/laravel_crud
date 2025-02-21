document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#home-button').addEventListener('click', () => {
        window.location.href = '/';
    });

    document.querySelector('#write-post').addEventListener('click', () => {
        window.location.href = '/post/write';
    });

    document.querySelector('#prev-page').addEventListener('click', () => {
        const pageNum = parseInt(document.querySelector('#page-number').value);
        if(pageNum < 1){
            contentLoad(pageNum-1);
            document.querySelector('#page-number').value = pageNum-1;
        }else{
            alert('첫번째 페이지입니다.');
        }
    });

    document.querySelector('#next-page').addEventListener('click', () => {
        const pageNum = parseInt(document.querySelector('#page-number').value);
        let posts = document.querySelectorAll('.title-hypertext');
        if(posts.length === maxRow){
            contentLoad(pageNum+1);
            document.querySelector('#page-number').value = String(pageNum+1);
        }else{
            alert('마지막 페이지입니다.');
        }
        posts = document.querySelectorAll('.title-hypertext');
        if(posts.length === 0){
            alert('마지막 페이지입니다.');
            contentLoad(pageNum);
            document.querySelector('#page-number').value = String(pageNum);
        }
    });
});