<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="/css/login_form.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="back_button_container">
            <button id="home" class="back_button">홈</button>
            <button id="backPage" class="back_button">←</button>
        </div>

        <div class="login-container">
            <form action="/login" method="POST" id="login-form">
                @csrf
                <table>
                    <thead>
                        <tr>
                            <th width="70%"></th>
                            <th width="30%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type=text id="id" name="id" placeholder="아이디를 입력하세요."></td>
                            <td rowspan="2"><button type="button" id="login">로그인</button></td>
                        </tr>
                        <tr>
                            <td><input type=password id="password" name="pw" placeholder="비밀번호를 입력하세요."></td>
                        </tr>
                        <tr >
                            <td colspan="2">
                                <a href="/login/signup" id="create-account">회원가입</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/js/login_form/def.js"></script>
    <script type="text/javascript" src="/js/login_form/event.js"></script>
</body>
</html>