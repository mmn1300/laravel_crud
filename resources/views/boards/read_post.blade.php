<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Post</title>
    @vite('resources/css/read_post.css')
</head>
<body>
    <div class="container">
        <!-- 최상단 컨텐츠. 수정 버튼(본인 글), 삭제 버튼(본인 글)-추천 버튼(타인 글), 홈 버튼, 뒤로가기 버튼 -->
        <div class="head-content">
            <div class="button-container"></div>
            <div class="home"><button class="home-button">홈</button></div>
            <div class="prev-page"><button class="prev-page-button">←</button></div>
        </div>

        <!-- 메인 컨텐츠 -->
        <div class="main-content">
            <!-- 상단 컨텐츠. 제목, 작성자 정보, 조회 수, 추천 수 -->
            <div class="post-info">
                <div class="post-info">
                    <div class="title">
                        <span id="title">제목</span>
                    </div>
                    <div class="post-control">
                        <div class="user-info"><span id="user-info">작성자 정보</span></div>
                        <div class="view-count"><span id="view-count">조회 수: <span>00</span></span></div>
                        <div class="recommendation"><button id="recommendation">추천하기</button></div>
                    </div>
                </div>
            </div>

            <!-- 중단 컨텐츠. 작성된 시점, 첨부된 파일 (존재 시 다운로드) -->
            <div class="mid-content">
                <div class="date-time">2025-01-01 12:00:00</div>
                <div class="file-container"></div>
            </div>

            <!-- 하단 컨텐츠. 텍스트 영역 -->
            <div class="text-area">
                <span id="text-area">텍스트 출력</span>
            </div>
        </div>
    </div>
</body>
</html>