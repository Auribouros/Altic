$(function() {

	let images = harvestDataFromElement('images', '#data');
	let imgfond = images.background;//'Image/01.png' 
	let imgfondElement = '<div id="terrain"><img src="'+imgfond+'" id="imgfond"/></div>' ;
	let htdoc = $(document).height();
	let lgdoc = $(document).width();
	let ligneActuelle = 0 ;
	let tuxImage =  images.celestin;
	let magImage =  images.wizard;
	let bul =  images.bubble;
	let bulHtml = '<div id="bul"><img src="'+bul+'"id="bulimg"/></div>' ;
	let tux = new Character('tux', tuxImage);
	let mag = new Character('mag', magImage);
	let questionAnswers = harvestDataFromElement('questionsanswers', '#data');
	let currentQuestion = 0;
	let nbRightAnswers = 0;
	let question1 = questionAnswers[currentQuestion][0];
	let bUsingTimer = false;
	let timeConstraintSeconds = 0;
	let givenAnswers = [];
	let timer = undefined;
	let timeElapsedSeconds = 0;
	let elapsedTimer = undefined;
	let dataToSendJSON = null;
	let controllerURL = '/pupil/endgame';
	let nbOfAnswersPerRow = [];

	let dataToSend = {
		questionAnswers: '',
		givenAnswers: '',
		timeElapsedSeconds: '',
		globalLevel: '',
		localLevel: '',
		table: '',
		nbRightAnswers: ''
	};
	//console.log(questionAnswers);

	if (question1.split('t')[1] != '') {
		bUsingTimer = true;
		timeConstraintSeconds = Number(question1.split('t')[1]);
	}
	
	question1 = question1.split('t')[0];

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
		nbOfAnswersPerRow[j] = questionAnswers[j].length-1;
		for (let i = 0; i < questionAnswers[j].length-1; i++) {
			let currentAnswer = questionAnswers[j][i+1];
			let reponse = (currentAnswer.indexOf('good') < 0 && currentAnswer.indexOf('bad') < 0)? new Answer((j*10+i), '') : new Answer((j*10+i), parseInt(currentAnswer));
			reponse.appendTo('#terrain');
			if (currentAnswer.indexOf('good') < 0 && currentAnswer.indexOf('bad') < 0) {

				$('#'+ (j*10+i) +' #answerBtn').data('answer', currentAnswer);
				$('#'+ (j*10+i) +' #answerBtn').data('answerId', (j*10+i));
			
			}
			else {

				$('#'+ (j*10+i)).data('answer', currentAnswer);

			}
			reponse.setElementCSS({
				'position': 'absolute',
				'top': ((htdoc-0.15*htdoc)-(1/10*(htdoc-0.15*htdoc))*j),
				'left': ((lgdoc-0.3*lgdoc)/questionAnswers[j].length)*(i+1),
				'font-size': 0.05*htdoc,
				'background-color': 'white',
				'border-radius': '5px',
				'padding': '10px'
			});
		}
	}

	nbOfAnswersPerRow = Math.max.apply(Math, nbOfAnswersPerRow);

	// Rendre invisible les lignes des futures réponses

	for (let j = 10; j <= 110; j+=10) {
		for (let i = 0; i < questionAnswers[0].length; i++) {
			$('#'+(j+i)).hide();
		}
	}
	
	// Ce qui se passe quand je clique sur une réponse

	$('a').click(function() {


		if (~$(this).data('answer').indexOf('good') || ~$(this).data('answer').indexOf('bad')) {

			currentQuestion++;
			//alert(currentQuestion);
			if (~$(this).data('answer').indexOf('good')) {
				nbRightAnswers++;
				//alert(nbRightAnswers);
			}
			givenAnswers[givenAnswers.length] = parseInt($(this).data('answer'));
			ligneActuelle += 10 ;
			for (let i = 0; i < nbOfAnswersPerRow; i++) {
				$('#'+(ligneActuelle+i)).fadeIn(1000);
				$('#'+(ligneActuelle+i-10)).fadeOut(1000);
			}
			
			let left = $(this).css('left');
			let top = $(this).css('top');
			tux.setImgCSS({'top': top, 'left': left});
			$('#tuxImage').hide().fadeIn(1000);
			if (currentQuestion > 9) {
				if (bUsingTimer) {
					window.clearInterval(timer);
				}
				window.clearInterval(elapsedTimer);
				dataToSend.questionAnswers = questionAnswers;
				dataToSend.givenAnswers = givenAnswers;
				dataToSend.timeElapsedSeconds = timeElapsedSeconds;
				dataToSend.globalLevel = harvestDataFromElement('globallevel', '#data');
				dataToSend.localLevel = harvestDataFromElement('locallevel', '#data');
				dataToSend.table = harvestDataFromElement('table', '#data');
				dataToSend.nbRightAnswers = nbRightAnswers;
				sendDataToController(dataToSend, controllerURL, function (data) {
					$('body').html(data);
				});
			}
			question1 = questionAnswers[currentQuestion][0].split('t')[0];
			affichageEtChangementQuestion(question1);

			
		}
		
	});

	$('#answerBtn').click(function () {
		
		currentQuestion++;
		alert(currentQuestion);
		let answerId = $(this).data('answerId');
		if (Number($(this).data('answer')) == Number($('#'+ answerId +' input').val())) {
			nbRightAnswers++;
		}
		ligneActuelle += 10 ;
		for (let i = 0; i < nbOfAnswersPerRow; i++) {
			$('#'+(ligneActuelle+i)).fadeIn(1000);
			$('#'+(ligneActuelle+i-10)).fadeOut(1000);
		}
			
		let left = $(this).css('left');
		let top = $(this).css('top');
		tux.setImgCSS({'top': top, 'left': left});
		$('#tuxImage').hide().fadeIn(1000);
		if (currentQuestion > 9) {
			if (bUsingTimer) {
				window.clearInterval(timer);
			}
			window.clearInterval(elapsedTimer);
			dataToSend.questionAnswers = questionAnswers;
			dataToSend.givenAnswers = givenAnswers;
			dataToSend.timeElapsedSeconds = timeElapsedSeconds;
			dataToSend.globalLevel = harvestDataFromElement('globallevel', '#data');
			dataToSend.localLevel = harvestDataFromElement('locallevel', '#data');
			dataToSend.table = harvestDataFromElement('table', '#data');
			dataToSend.nbRightAnswers = nbRightAnswers;
			sendDataToController(dataToSend, controllerURL, function (data) {
				$('body').html(data);
			});
		}
		question1 = questionAnswers[currentQuestion][0].split('t')[0];
		affichageEtChangementQuestion(question1);

	});


	// Afficher la question
		//affichage de la première question
		affichageEtChangementQuestion(question1) ;

	//if there is a time constraint
	if (bUsingTimer) {

		timer = setInterval(function () {
			
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

	elapsedTimer = setInterval(function () {
		timeElapsedSeconds++;
	}, 1000);


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