function login(){
    const id = document.querySelector('#id');
    const pw = document.querySelector('#password');

    if(id.value.trim() === ''){
        alert('아이디를 입력해주세요');
    }else if(pw.value.trim() === ''){
        alert('비밀번호를 입력해주세요');
    }else{
        isIdExist(id.value).then(result => {
            if(result){
                isPwMatched(id.value, pw.value).then(result => {
                    if(result){
                        document.querySelector('#login-form').submit();
                        alert('로그인 되었습니다.')
                    }else{
                        alert('비밀번호 입력이 잘못되었습니다.\n다시 입력해주세요.');
                        return;
                    }
                });
            }else{
                alert('입력하신 아이디가 존재하지 않습니다.');
                return;
            }
        });
    }
}