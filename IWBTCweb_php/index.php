<?php include 'sidebar.php'; ?>

<div class="tabcontent" id="home">
    <div class="slider-container">
        <div class="slider">
            <div class="slide" data-title="IWBTC 游戏网站">
                <img src="pic/header.jpg" alt="IWBTC 游戏网站">
            </div>
            <div class="slide" data-title="关卡编辑与灵感收集">
                <img src="pic/header.jpg" alt="关卡编辑与灵感收集">
            </div>
            <div class="slide" data-title="社区协作与玩法交流">
                <img src="pic/header.jpg" alt="社区协作与玩法交流">
            </div>
            <div class="slide" data-title="下载版本并开始挑战">
                <img src="pic/header.jpg" alt="下载版本并开始挑战">
            </div>
        </div>
        <div class="slide-caption" id="slideCaption"></div>

        <div class="slider-thumbs" id="sliderThumbs">
            <button type="button" class="slider-thumb active" data-index="0">
                <img src="pic/header.jpg" alt="缩略图 1">
            </button>
            <button type="button" class="slider-thumb" data-index="1">
                <img src="pic/header.jpg" alt="缩略图 2">
            </button>
            <button type="button" class="slider-thumb" data-index="2">
                <img src="pic/header.jpg" alt="缩略图 3">
            </button>
            <button type="button" class="slider-thumb" data-index="3">
                <img src="pic/header.jpg" alt="缩略图 4">
            </button>
        </div>
    </div>
</div>

<script>
// 轮播图配置：只需要改这里的标题即可
const slideTitles = [
    'IWBTC 游戏网站',
    '关卡编辑与灵感收集',
    '社区协作与玩法交流',
    '下载版本并开始挑战'
];

const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slide');
const thumbs = document.querySelectorAll('.slider-thumb');
const thumbsContainer = document.getElementById('sliderThumbs');
const caption = document.getElementById('slideCaption');
const slideCount = slides.length;
let currentIndex = 0;
let timer = null;
const interval = 5000;

slides.forEach((slide, index) => {
    slide.dataset.title = slideTitles[index] || `第 ${index + 1} 张`;
});

function startAutoPlay() {
    stopAutoPlay();
    timer = setInterval(() => {
        goToSlide((currentIndex + 1) % slideCount);
    }, interval);
}

function stopAutoPlay() {
    if (timer) {
        clearInterval(timer);
        timer = null;
    }
}

function goToSlide(index) {
    currentIndex = index;
    const offset = -currentIndex * 100;
    slider.style.transform = `translateX(${offset}%)`;

    thumbs.forEach((thumb, i) => {
        thumb.classList.toggle('active', i === currentIndex);
    });

    caption.textContent = slides[currentIndex].dataset.title;
}

thumbs.forEach((thumb) => {
    thumb.addEventListener('click', () => {
        const index = Number(thumb.dataset.index);
        goToSlide(index);
        startAutoPlay();
    });
});

slider.addEventListener('mouseenter', stopAutoPlay);
slider.addEventListener('mouseleave', startAutoPlay);
thumbsContainer.addEventListener('mouseenter', stopAutoPlay);
thumbsContainer.addEventListener('mouseleave', startAutoPlay);

goToSlide(0);
startAutoPlay();
</script>

<?php include 'footer.php'; ?>
