<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts List</title>
    <link rel="stylesheet" type="text/css" href="/css/posts_list.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <!-- 최상단 컨텐츠. 로그인 정보, 홈 -->
        <div class="head-content">
            <div class="login-state">로그인 상태</div>
            <div class="home"><button class="home-button" id="home-button" type="button">홈</button></div>
            <div class="write-post"><button id="write-post" type="button">글쓰기</button></div>
        </div>

        <!-- 메인 컨텐츠 -->
        <table class="main-content">
            <thead>
                <tr class="post-info">
                    <th width="10%">No</th>
                    <th width="50%">제목</th>
                    <th width="20%">작성자</th>
                    <th width="20%">작성일</th>
                </tr>
            </thead>
            <tbody id="post-content">
                <!-- 아래 행 16개 생성
                <tr class="table-row">
                    <td class="post-number"></td>
                    <td class="post-title"></td>
                    <td class="post-user"></td>
                    <td class="post-date"></td>
                </tr> 
                -->

                <tr class="table-row-last">
                    <td colspan=3 id="search-space">
                        <!-- <span id="text-search">검색 </span>
                        <input type="text" id="search" value=""> -->
                    </td>
                    <td colspan=2 id="page-space">
                        <button class="page-button" id="prev-page">&lt;</button>
                        <input type="text" id="page-number" value="1" readonly>
                        <button class="page-button" id="next-page">&gt;</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="/js/posts_list/def.js"></script>
    <script type="text/javascript" src="/js/posts_list/main.js"></script>
    <script type="text/javascript" src="/js/posts_list/event.js"></script>
</body>
</html>