// import './bootstrap';


// console.log("happy!!");

$(function(){
	// 変数に要素を入れる
	var open = $('.modal-open'),
		close = $('.modal-close'),
		close_two = $('.modal-close-two'),
		container = $('.modal-container');

	//開くボタンをクリックしたらモーダルを表示する
	open.on('click',function(){	
		container.addClass('active');
		return false;
	});

	//閉じるボタンをクリックしたらモーダルを閉じる
	close.on('click',function(){	
		container.removeClass('active');
	});

    //閉じるボタンをクリックしたらモーダルを閉じる
	close_two.on('click',function(){	
		container.removeClass('active');
	});

	//モーダルの外側をクリックしたらモーダルを閉じる
	$(document).on('click',function(e) {
		if(!$(e.target).closest('.modal-body').length) {
			container.removeClass('active');
		}
	});
});


$(function () {
    $('.tooltip').hide();
    $('.main__button').hover(
    function () {
        $(this).children('.tooltip').fadeIn('fast');
		console.log("OK");
    },
    function () {
        $(this).children('.tooltip').fadeOut('fast');
    });
});
