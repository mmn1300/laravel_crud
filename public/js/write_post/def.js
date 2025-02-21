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

// 글을 작성하는 함수. postState === true 일 때 글쓰기, false 일 때 임시저장
async function writePost(postState) {
    const title = document.querySelector('#title-input').value;
    const content = document.querySelector('#content').value;

    if(title.trim() !== ''){
        if(content.trim() !== ''){
            return fetch('/post/write', {
                method: 'POST',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
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
                    if(postState){
                        alert('게시물이 성공적으로 작성되었습니다.');
                    }else{
                        alert('게시물을 임시 저장하였습니다.');
                    }
                }else{
                    alert(`요청 중 에러가 발생했습니다.\n\n${data['error']}`);
                }
                return data['message'];
            })
            .catch((error) => {
                alert(`요청 중 에러가 발생했습니다.\n\n${error.message}`);
            });
        }else{
            alert('글을 입력해주세요.');
        }
    }else{
        alert('제목을 입력해주세요.');
    }
};

function getCurrentTime() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    document.querySelector('#date-time').textContent = `${year}-${month}-${day} ${hours}:${minutes}`;
}