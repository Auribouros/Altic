$(function() {

	//alert(harvestDataFromElement('images', '#data'));
	let images = harvestDataFromElement('images', '#data');
	let imgfond = images.background;//'Image/01.png' 
	let imgfondElement = '<div id="terrain"><img src="'+imgfond+'" id="imgfond"/></div>' ;
	let htdoc = $(document).height();
	let lgdoc = $(document).width();
	let ligneActuelle = 0 ;
	let tuxImage =  images.celestin;//'Image/02.png'
	let magImage =  images.wizard;//'Image/03.png'
	let bul =  images.bubble;//'Image/04.png'
	let bulHtml = '<div id="bul"><img src="'+bul+'"id="bulimg"/></div>' ;
	let tux = new Character('tux', tuxImage);
	let mag = new Character('mag', magImage);
	let questionAnswers = harvestDataFromElement('questionsanswers', '#data');
	let currentQuestion = 1;
	let nbRightAnswers = 0;
	let question1 = questionAnswers[currentQuestion][0];
	//console.log(questionAnswers);


	$('body').append(imgfondElement);
	$('body').append(bulHtml);
	tux.appendTo('body');
	mag.appendTo('body');
	$('#imgfond').css({'height': htdoc-0.11*htdoc, 'width': lgdoc-0.3*lgdoc, 'position': 'absolute', 'top': 50});
	$('#bulimg').css({'height': htdoc-0.6*htdoc, 'position': 'absolute', 'width': 0.27*lgdoc, 'top': 80 , 'right': 50});
	tux.setImgCSS({'height': htdoc*0.07, 'position': 'absolute', 'bottom': 1});
	mag.setImgCSS({'height': htdoc-0.6*htdoc, 'position': 'absolute', 'width': 0.2*lgdoc, 'top': 400, 'right': 50});

	// Générer les positions des questions des réponses et les afficher

	for (let j = 0; j < 10; j++) {
		for (let i = 0; i < questionAnswers[j+1].length-1; i++) {
			let reponse = new Answer((j*10+i), parseInt(questionAnswers[j+1][i+1]));
			reponse.appendTo('#terrain');
			$('#'+ (j*10+i)).data('answer', questionAnswers[j+1][i+1]);
			reponse.setElementCSS({
				'position': 'absolute',
				'top': ((htdoc-0.15*htdoc)-(1/10*(htdoc-0.15*htdoc))*j),
				'left': ((lgdoc-0.3*lgdoc)/4)*(i+1)
			});
		}
	}

	// Rendre invisible les lignes des futures réponses

	for (let j = 10; j <= 110; j+=10) {
		for (let i = 0; i < questionAnswers[0].length; i++) {
			$('#'+(j+i)).hide();
		}
	}
	
	// Ce qui se passe quand je clique sur une réponse

	$('a').click(function() {

		currentQuestion++;
		if (~$(this).data('answer').indexOf('good')) {
			nbRightAnswers++;
		}
		ligneActuelle += 10 ;
		for (let i = 0; i < 3; i++) {
			$('#'+(ligneActuelle+i)).fadeIn(1000);
			$('#'+(ligneActuelle+i-10)).fadeOut(1000);
		}
		
		let left = $(this).css('left');
		let top = $(this).css('top');
		tux.setImgCSS({'top': top, 'left': left});
		$('#tuxImage').hide().fadeIn(1000);
		question1 = questionAnswers[currentQuestion][0];
		affichageEtChangementQuestion(question1);
	});


	// Afficher la question
		//affichage de la première question
		affichageEtChangementQuestion(question1) ;


	function affichageEtChangementQuestion(questionLabel){
		let question = '<p>'+ questionLabel +'</p>';
		$('#quest').css({'height': htdoc-0.6*htdoc, 'position': 'absolute', 'width': 0.27*lgdoc, 'top': 150 , 'right': 0, 'z-index': 2});
		$('#quest').html(question);

	}


});