var Lock = function () {

    return {
        //main function to initiate the module
        init: function () {

             $.backstretch([
		       // "gui/ltr/img/bg/1.jpg",
		       // "gui/ltr/img/bg/2.jpg",
		       // "gui/ltr/img/bg/3.jpg",
		       // "gui/ltr/img/bg/4.jpg"
		       "gui/ltr/img/bg/5.png"
		        ], {
		          fade: 1000,
		          duration: 8000
		      });
        }

    };

}();