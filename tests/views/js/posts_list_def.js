// 한 페이지 당 최대 게시물 개수
const maxRow = 16;


// <tr class="table-row">
//     <td class="post-number"></td>
//     <td class="post-title"></td>
//     <td class="post-user"></td>
//     <td class="post-update"></td>
//     <td class="post-delete"></td>
// </tr>
const create_table_row = () => {
    const tr = document.createElement('tr');
    tr.className = 'table-row';

    const tdNumber = document.createElement('td');
    tdNumber.className = 'post-number';
    tr.appendChild(tdNumber);

    const tdTitle = document.createElement('td');
    tdTitle.className = 'post-title';
    tr.appendChild(tdTitle);

    const tdUser = document.createElement('td');
    tdUser.className = 'post-user';
    tr.appendChild(tdUser);

    const tdUpdate = document.createElement('td');
    tdUpdate.className = 'post-update';
    tr.appendChild(tdUpdate);

    const tdDelete = document.createElement('td');
    tdDelete.className = 'post-delete';
    tr.appendChild(tdDelete);

    return tr;
};

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
}