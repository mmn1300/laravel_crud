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