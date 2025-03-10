<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link rel="stylesheet" type="text/css" href="/css/update_post.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <!-- 최상단 컨텐츠. 현재 날짜 및 시간, 홈 버튼, 뒤로가기 버튼 -->
        <div class="head-content">
            <div class="date-time"><span id="date-time">날짜 및 시간</span></div>
            <div class="home"><button class="home-button">홈</button></div>
            <div class="prev-page"><button class="prev-page-button">←</button></div>
        </div>

        <!-- 메인 컨텐츠 -->
        <div class="main-content" id="{{ $number }}">
            <!-- 상단 컨텐츠. 제목, 로그인 정보, 임시저장 버튼, 게시하기 버튼 -->
            <form id="post-form" action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="number" value="{{ $number }}">
                <div class="post-info">
                    <div class="title">
                        <span id="title">제목 : </span>
                        <input type="text" name="title" id="title-input" value="{{ $title }}" placeholder=" 제목을 입력해주세요.">
                    </div>
                    <div class="post-control">
                        <div class="user-info"><span id="user-info">{{ $user }}</span></div>
                        <div class="submit-btn"><button id="submit-btn" type="button">수정하기</button></div>
                    </div>
                </div>

                <!-- 중단 컨텐츠. 텍스트 영역 -->
                <div class="text-area">
                    <textarea id="content" name="content">{{ $content }}</textarea>
                </div>

                <!-- 하단 컨텐츠. 파일 첨부 -->
                <div class="add-file">
                    <span id="add-file">파일 첨부</span>
                    <input type="file" id="file-upload" name="file">
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/js/update_post/def.js"></script>
    <script type="text/javascript" src="/js/update_post/main.js"></script>
    <script type="text/javascript" src="/js/update_post/event.js"></script>
</body>
</html>