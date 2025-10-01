
jQuery(function($) {
    $('#header').bgSwitcher({
        images: ['/img/top/images/slide2.jpg','/img/top/images/slide6.jpg','/img/top/images/slide8.jpg','/img/top/images/slide5.jpg','/img/top/images/slide4.jpg','/img/top/images/slide7.jpg'], 
		interval: 5000,
        loop: true, // 切り替えを繰り返すか指定 true=繰り返す　false=繰り返さない
        shuffle: true, // 背景画像の順番をシャッフルするか指定 true=する　false=しない
        effect: "fade", // エフェクトの種類をfade,blind,clip,slide,drop,hideから指定
        duration: 1000, // エフェクトの時間を指定します。
        easing: "swing" // エフェクトのイージングをlinear,swingから指定
    });
});
