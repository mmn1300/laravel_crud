<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="user-info-container">
            <span id="login-info">로그인되지 않음</span>
            <button type="button" id="login" class="login-btn">로그인</button>
        </div>
        <div class="button-container">
            <button id="board" class="button">글쓰기</button>
        </div>
    </div>
    <script type="text/javascript" src="/js/index/def.js"></script>
    <script type="text/javascript" src="/js/index/main.js"></script>
    <script type="text/javascript" src="/js/index/event.js"></script>
</body>
</html>