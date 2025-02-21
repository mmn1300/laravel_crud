document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#submit').addEventListener('click', () => {
        if(confirm('게시물을 수정하시겠습니까?')){
            updatePost();
        }
    });
});