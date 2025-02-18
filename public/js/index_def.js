async function checkLogin() {
    return fetch('/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP 오류. 상태코드: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        return data;
    })
    .catch((error) => {
        alert(`요청 중 에러가 발생했습니다.\n\n${error.message}`);
    });
}