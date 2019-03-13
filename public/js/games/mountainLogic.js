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
	let bUsingTimer = false;
	let timeConstraintSeconds = 0;
	let rightAnswers = [];
	//console.log(questionAnswers);

	if (question1.split('t').length > 1) {
		bUsingTimer = true;
		timeConstraintSeconds = Number(question1.split('t')[1]);
		question1 = question1.split('t')[0];
	}

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
			let reponse = (bUsingTimer)? new Answer((j*10+i), '') : new Answer((j*10+i), parseInt(questionAnswers[j+1][i+1]));
			reponse.appendTo('#terrain');
			if (bUsingTimer) {

				$('#'+ (j*10+i) +' #answerBtn').data('answer', questionAnswers[j+1][i+1]);
			
			}
			else {

				$('#'+ (j*10+i)).data('answer', questionAnswers[j+1][i+1]);

			}
			reponse.setElementCSS({
				'position': 'absolute',
				'top': ((htdoc-0.15*htdoc)-(1/10*(htdoc-0.15*htdoc))*j),
				'left': ((lgdoc-0.3*lgdoc)/4)*(i+1),
				'font-size': 0.05*htdoc,
				'background-color': 'white',
				'border-radius': '5px',
				'padding': '10px'
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

		if (!bUsingTimer) {

			currentQuestion++;
			if (~$(this).data('answer').indexOf('good')) {
				nbRightAnswers++;
				alert(nbRightAnswers);
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
			question1 = (bUsingTimer)? questionAnswers[currentQuestion][0].split('t')[0] : questionAnswers[currentQuestion][0];
			affichageEtChangementQuestion(question1);
			
		}
	});

	$('#answerBtn').click(function () {
		
		currentQuestion++;
		if (~$(this).data('answer').indexOf('good')) {
			nbRightAnswers++;
			alert(nbRightAnswers);
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
		question1 = questionAnswers[currentQuestion][0].split('t')[0];
		affichageEtChangementQuestion(question1);

	});


	// Afficher la question
		//affichage de la première question
		affichageEtChangementQuestion(question1) ;

	//if there is a time constraint
	if (bUsingTimer) {

		setInterval(function () {
			
			currentQuestion++;
			question1 = (bUsingTimer)? questionAnswers[currentQuestion][0].split('t')[0] : questionAnswers[currentQuestion][0];
			ligneActuelle += 10 ;

			for (let i = 0; i < 3; i++) {
				$('#'+(ligneActuelle+i)).fadeIn(1000);
				$('#'+(ligneActuelle+i-10)).fadeOut(1000);
			}
			
			affichageEtChangementQuestion(question1);

		}, timeConstraintSeconds * 1000);

	}


	function affichageEtChangementQuestion(questionLabel){
		let question = '<p>'+ questionLabel +'</p>';
		$('#quest').css({
			'height': htdoc-0.6*htdoc,
			'position': 'absolute',
			'width': 0.27*lgdoc,
			'top': 0.15*htdoc,
			'right': 0,
			'z-index': 2,
			'font-size': 0.1*htdoc
		});
		$('#quest').html(question);

	}


});