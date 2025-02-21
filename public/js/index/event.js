document.addEventListener('DOMContentLoaded', () => {
    // 글쓰기 버튼 클릭시 GET 요청
    document.querySelector('#board').addEventListener('click', () => {
        window.location.href = '/board';
    });

    // 로그인 및 로그아웃 요청
    document.querySelector('#login').addEventListener('click', (e) => {
        if(e.target.textContent === '로그인'){
            window.location.href = '/login';
        }else{
            fetch('/logout', {
                method: 'DELETE',
                dataType : 'json',
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
                if(data["message"]){
                    location.reload();
                }else{
                    console.error(data['error']);
                }
            })
            .catch((error) => {
                alert(`요청 중 에러가 발생했습니다.\n\n${error.message}`);
            });
        }
    });
});