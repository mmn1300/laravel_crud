<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Post</title>
    <link rel="stylesheet" type="text/css" href="/css/read_post.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <!-- 최상단 컨텐츠. 수정 버튼(본인 글), 삭제 버튼(본인 글)-추천 버튼(타인 글), 홈 버튼, 뒤로가기 버튼 -->
        <div class="head-content">
            <div class="button-container">
                <div class="home"><button class="home-button">홈</button></div>
                <div class="prev-page"><button class="prev-page-button">←</button></div>
            </div>
        </div>

        <!-- 메인 컨텐츠 -->
        <div class="main-content" id="{{ $number }}">
            <!-- 상단 컨텐츠. 제목, 작성자 정보, 조회 수, 추천 수 -->
            <div class="post-info">
                <div class="post-info">
                    <div class="title">
                        <span id="title">{{ $title }}</span>
                    </div>
                    <div class="post-control">
                        <div class="user-info"><span id="user-info">{{ $user }}</span></div>
                        <!-- <div class="view-count"><span id="view-count">조회 수: {{ $views }}</span></div>
                        <div class="recommend"><span id="recommend-count">추천 수: {{ $recommends }}</span></div> -->
                    </div>
                </div>
            </div>

            <!-- 중단 컨텐츠. 작성된 시점, 첨부된 파일 (존재 시 다운로드) -->
            <div class="mid-content">
                <div class="date-time">{{ $regist_day }}</div>
                <div class="file-container"></div>
            </div>

            <!-- 하단 컨텐츠. 텍스트 영역 -->
            <div class="text-area">
                <span id="text-area">{{ $content }}</span>
            </div>

            <!-- 최하단 컨텐츠. (본인 글)게시글 수정, 삭제 / (타인 글)추천하기 -->
            <div class="post-actions" id="{{ $isOwnPost }}"></div>
        </div>
    </div>
    <script type="text/javascript" src="/js/read_post/def.js"></script>
    <script type="text/javascript" src="/js/read_post/main.js"></script>
    <script type="text/javascript" src="/js/read_post/event.js"></script>
</body>
</html>