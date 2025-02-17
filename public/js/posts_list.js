document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#post-content');
    for(let i=0; i<maxRow; i++){
        tbody.prepend(create_table_row());
    }
});
