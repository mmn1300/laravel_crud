<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" type="text/css" href="/css/create_account.css">
</head>
<body>
    <div class="container">
        <div class="sign-up-container">
            <div class="create-account-container">
                <table id="table1">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th width="77%"></th>
                            <th width="20%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="icon-cell-body"><img src="/img/unchecked.png" class="icon-img" width="18px" height="18px"></span></td>
                            <td><input type="text" id="id" class="check-input" placeholder="아이디"></td>
                            <td><button id="id-redundancy-check">중복 확인</button></td>
                        </tr>
                        <tr>
                            <td><span class="icon-cell-body"><img src="/img/unchecked.png" class="icon-img" width="18px" height="18px"></span></td>
                            <td colspan="2"><input class="input" type="password" id="pw" placeholder="비밀번호"></td>
                        </tr>
                        <tr>
                            <td><span class="icon-cell-body"><img src="/img/unchecked.png" class="icon-img" width="18px" height="18px"></span></td>
                            <td colspan="2"><input class="input" type="password" id="pw-check" placeholder="비밀번호 확인"></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="text-td"><h5 id="pw-check-text" class="highlight-black">비밀번호를 입력해주세요</h5></td>
                        </tr>
                    </tbody>
                </table>
                <table id="table2">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th width="77%"></th>
                            <th width="20%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="icon-cell-body"><img src="/img/unchecked.png" class="icon-img" width="18px" height="18px"></span></td>
                            <td colspan="2">
                                <input class="email-input" type="text" id="email" placeholder="이메일">
                                <span>@</span>
                                <input class="email-input" id="email-domain" placeholder="도메인 주소">
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="icon-cell-body"><img src="/img/unchecked.png" class="icon-img" width="18px" height="18px"></span></td>
                            <td colspan="2">
                                <input class="phone-input" type="text" id="phone" placeholder="전화번호">
                                <span>-</span>
                                <input class="phone-input" type="text" id="phone2" placeholder="전화번호">
                                <span>-</span>
                                <input class="phone-input" type="text" id="phone3" placeholder="전화번호">
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="icon-cell-body"><img src="/img/unchecked.png" class="icon-img" width="18px" height="18px"></span></td>
                            <td colspan="2">
                                <input class="birthday-input" type="birthday" id="birthday" placeholder="생년월일 6자리"><br/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button type="button" id="sign-up">회원가입</button>
                <button type="button" id="back-page">이전 페이지</button>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/create_account.js"></script>
</body>
</html>