// 로그인이 되어있는지 확인. 요청을 통해 로그인 되어있다면 아이디와 닉네임을 불러옴
async function checkLogin() {
    return fetch('/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP 오류. 상태코드: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if(data['error'] !== undefined){
            console.log(data['error']);
        }
        return data;
    })
    .catch((error) => {
        alert(`요청 중 에러가 발생했습니다.\n\n${error.message}`);
    });
};

// 게시글을 수정하는 비동기 요청 함수
const updatePost = () => {
    const number = parseInt(document.querySelector('.main-content').id);
    const title = document.querySelector('#title-input').value;
    const content = document.querySelector('#content').value;

    fetch('/post/update', {
        method: 'PUT',
        dataType: 'json',
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            number : number,
            title : title,
            content : content
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
            alert('요청을 성공적으로 완료하였습니다.');
            window.location.href = `/post/read/${number}`;
        }else{
            console.error(data['error']);
        }
    })
    .catch((error) => {
        alert(`요청 중 에러가 발생했습니다.\n\n${error.message}`);
    });
};