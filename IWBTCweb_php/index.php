<?php include 'sidebar.php'; ?>

<!-- 首页 -->
<div class="tabcontent" id="home">
    <!-- 轮播图 -->
    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="pic/library_hero2.png" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="pic/library_hero2.png" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="pic/library_hero2.png" alt="Slide 3">
            </div>
            <div class="slide">
                <img src="pic/library_hero2.png" alt="Slide 4">
            </div>
        </div>
        <div class="indicators">
            <div class="indicator active" onclick="goToSlide(0)"></div>
            <div class="indicator" onclick="goToSlide(1)"></div>
            <div class="indicator" onclick="goToSlide(2)"></div>
            <div class="indicator" onclick="goToSlide(3)"></div>
        </div>  
    </div>

</div>

<script>
//轮播图
const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slide');
const indicators = document.querySelectorAll('.indicator');
const slideCount = slides.length;
let currentIndex = 0;
let timer = null;
const interval = 5000; //5秒切换一次

//自动轮播
function startAutoPlay() {
    timer = setInterval(() => {
        goToSlide((currentIndex + 1) % slideCount);
    }, interval);
}

//停止自动轮播
function stopAutoPlay() {
    clearInterval(timer);
}

//切换到指定幻灯片
function goToSlide(index) {
    currentIndex = index;
    const offset = -currentIndex * 100;
    slider.style.transform = `translateX(${offset}%)`;

    //更新指示器状态
    indicators.forEach((indicator, i) => {
        if (i === currentIndex) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

//鼠标悬停时暂停轮播
slider.addEventListener('mouseenter', stopAutoPlay);
slider.addEventListener('mouseleave', startAutoPlay);

//启动自动轮播
startAutoPlay();
</script>

<?php include 'footer.php'; ?>