// <button id="recommend">추천하기</button>
const createRecommendButton = () => {
    const button = document.createElement('button');
    button.id = 'recommend';
    button.textContent = '추천하기';

    return button;
};

// <div class="my-post">
//   <button class="post-ud" id="post-update">수정</button>
//   <button class="post-ud" id="post-delete">삭제</button>
// </div>
const createUDButton = () => {
    const div = document.createElement('div');
    div.className = 'my-post';

    const updateButton = document.createElement('button');
    updateButton.className = 'post-ud';
    updateButton.id = 'post-update';
    updateButton.textContent = '수정';
    div.appendChild(updateButton);

    const deleteButton = document.createElement('button');
    deleteButton.className = 'post-ud';
    deleteButton.id = 'post-delete';
    deleteButton.textContent = '삭제';
    div.appendChild(deleteButton);

    updateButton.addEventListener('click', () => {
        const num = parseInt(document.querySelector('.main-content').id);
        window.location.href = `/post/update/${num}`;
    });

    deleteButton.addEventListener('click', () => {
        if(confirm('이 게시물을 삭제하시겠습니까?')){
            deletePost();
        }
    });

    return div;
};

// 비동기 요청을 통해 게시글 삭제를 요청하는 함수
const deletePost = () => {
    const number = parseInt(document.querySelector('.main-content').id);
    fetch('/post/delete', {
        method: 'DELETE',
        dataType: 'json',
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            number : number
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP 오류. 상태코드: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if(data['message']){
            alert('게시글 삭제를 완료하였습니다.');
            window.location.href = '/board';
        }else{
            console.error(data['error']);
        }
    })
    .catch((error) => {
        alert(`요청 중 에러가 발생했습니다.\n\n${error.message}`);
    });
};