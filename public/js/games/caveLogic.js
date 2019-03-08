/**
* If you are new or totally new in jQuery and / or javascript, I highly recommend you take a look at the following:
* https://www.w3schools.com/jquery/default.asp
* https://www.w3schools.com/js/default.asp
* https://api.jquery.com
*
* If you do not know it and still want to read the code, be aware that the basic jQuery / javascript methods are not commented
* as it is not a jQuery / javascript documentation.
 */
 

/**
 * Returns the row in which a room is located.
 *
 * @function
 * @param      {number}  roomNumber                  Le numéro de chambre
 * @param      {number}  numberOfRoomPerRow  Le nombre d'images de pièce par ligne
 * @return     {number}  La rangée dans laquelle est une chambre.
 */
function getRowFromRoom(roomNumber, numberOfRoomPerRow) {

	let rowNumber = 0;

	while(roomNumber >= rowNumber * numberOfRoomPerRow) {

		rowNumber++;

	}

	return rowNumber;

}

//when the DOM is ready, we can do everything in the following function
$(function(){

	/**
	 * Spawn the answers in front of Celestin
	 * 
	 * @function
	 */
	function spawnAnswers() {

		/**
		 * The element containing the answers.
		 *
		 * @type       {string}
		 */
		let answerSpace = '<div id="answerSpace"></div>';
		$('body').append(answerSpace);
		$('#answerSpace').css({'position': 'absolute'});
		
		for (let i = 0; i < questionsAnswers[questionNumber].length - 1; i++) {
			
			/**
			 * Random index used to display a random tool.
			 *
			 * @type       {number}
			 */
			let randomToolImageIndex = Math.floor(Math.random() * toolImages.length);
			/**
			 * The HTML code representing a tool.
			 *
			 * @type       {string}
			 */
			let toolElement = '<a href="#" class="answerA" id="answer' + i + '"><img src="images/tools/' + toolImages[randomToolImageIndex] + '" class="keyImage"/>' + i + '</a>';
			let answer = new Answer('answer'+i, parseInt(questionsAnswers[questionNumber][i+1]), toolImages[randomToolImageIndex]);

			if (questionsAnswers[questionNumber][i+1].includes('good')) {
				correctAnswerId = 'answer'+i;
			}

			answer.appendTo('#answerSpace');
			answer.setElementCSS({
				'position': 'absolute',
				'top': (i-1)*(roomHeight/3),
				'left': (currentRoomNumber-0.2)*roomWidth,
				'z-index': '2',
				'margin': '5px',
				'color': 'black',
				'font-family': 'Med1',
				'font-size': documentHeight/20,
				'background-color': 'rgba(255, 255, 255, 0.7)',
				'border-radius': '5px'
			});
			answer.setImgCSS({
				'height': '50px',
				'width': '50px',
				'background-color': 'rgba(255, 255, 255, 0.9)',
				'border-radius': '100%',
				'padding': '0.5%'
			});
			answer.setInputCSS({
				'border-radius': '5px',
				'border-color': 'black',
				'font-family': 'Med1',
				'font-size': documentHeight/20,
				'width': documentWidth/20,
				'padding': '5px'
			});

		}

		/**
		 * The top CSS value of Celestin.
		 *
		 * @type       {number}
		 */
		let celestinTop = parseFloat($(celestin.getId()).css('top'));
		/**
		 * The left CSS value of Celestin.
		 *
		 * @type       {number}
		 */
		let celestinLeft = parseFloat($(celestin.getId()).css('left')) + 0.7*roomWidth;
		$('#answerSpace').css({'top': celestinTop, 'left': celestinLeft});

	}

	/**
	 * Updates the answers
	 *
	 * @param      {integer}  questionNumber  The question number in the questions order
	 */
	function updateAnswers() {
		
		let answers = $('.answer');
		alert(answers);

		for (let i = 0; i < questionsAnswers[questionNumber].length - 1; i++) {
			
			/**
			 * Random index used to display a random tool.
			 *
			 * @type       {number}
			 */
			//let randomToolImageIndex = Math.floor(Math.random() * toolImages.length);
			/**
			 * A tool image.
			 *
			 * @type       {string}
			 */
			//let toolImage = 'images/tools/' + toolImages[randomToolImageIndex];
			//let answer = new Answer('answer'+i, parseInt(questionsAnswers[questionNumber][i+1]), toolImages[randomToolImageIndex]);

			answers[i].attr('id', 'answer'+i);
			answers[i].text(parseInt(questionsAnswers[questionNumber][i+1]));

			if (questionsAnswers[questionNumber][i+1].includes('good')) {
				correctAnswerId = 'answer'+i;
			}

		}

	}

	/**
	 * Pops up the popup question
	 *
	 * @function
	 */
	function spawnPopUp() {
		
		$('#questionPopUp').remove();
		/**
		 * Tip to indicate how to answer the question (HTML code).
		 *
		 * @type       {string}
		 */
		let questionText = '<p>Utilise le bon outil pour casser le rocher ! <br/> </p><p id=essaisRestants>'+(10-numberOfGivenAnswers)+' essais restants </p>';//narrative text appearing on the popup
		/**
		 * HTML code of the question.
		 *
		 * @type       {string}
		 */
		let questionPopUp = '<div id="questionPopUp"><p>'+ questionsAnswers[questionNumber][0] +' ?<br/></p>' + questionText + '</div>';//basic popup
		$('#drawing').prepend(questionPopUp);

		/**
		 * The x coordinate of the popup.
		 *
		 * @type       {number}
		 */
		let popUpX = 0;
		/**
		 * The y coordinate of the popup.
		 *
		 * @type       {number}
		 */
		let popUpY = 0;

		//Displays the context menu according to where the user clicks on the screen.
		if (currentRoomNumber / 2 <= numberOfRoomImagesPerRow / 2) {
			popUpX = parseFloat($(wizard.getId()).css('left')) - roomWidth;
			popUpY = parseFloat($(wizard.getId()).css('top')) - 0.5*roomWidth;
		}
		else {
			popUpX = parseFloat($(wizard.getId()).css('left')) - roomWidth;
			popUpY = 0;
		}
		
		//adjust popup settings
		$('#questionPopUp').css({'z-index': '2', 'text-align': 'center', 'position': 'absolute', 'top': popUpY, 'left': popUpX, 'background-color': 'white', 'background-color': 'rgba(255, 255, 255, 0.5)', 'background-position': 'center', 'padding': '1px', 'border-radius': '5px', 'font-family': 'Med1', 'font-size': documentHeight/20});
		$('#questionPopUp p').css({'color': 'black'});

	}

	//vars
		
		/**
		 * Question number
		 *
		 * @type       {number}
		 */
		let questionNumber = 0;

		/**
		 * Holds question and answers related data
		 *
		 * @type       {Object}
		 */
		let questionsAnswers = harvestDataFromElement('questionsanswers', '#data');

		/**
		 * The height of the document.
		 *
		 * @type       {number}
		 */
	   	let documentHeight = $(document).height();
	   	/**
	   	 * The width of the document
	   	 *
	   	 * @type       {number}
	   	 */
		let documentWidth = $(document).width();

		$("#drawing").css({"height": documentHeight-20, "width": documentWidth-20});

		/**
		 * The height of the element in which we draw.
		 *
		 * @type       {number}
		 */
		let drawingBoardHeight = $("#drawing").height();
		/**
		 * The width of the element in which we draw.
		 *
		 * @type       {number}
		 */
		let drawingBoardWidth = $("#drawing").width();

		/**
		 * Total number of room images on the screen.
		 *
		 * @type       {number}
		 */
		let numberOfRoomImages = 10;
		/**
		 * Number of rows of rooms on the screen.
		 *
		 * @type       {number}
		 */
		let numberOfRows = 2;
		/**
		 * Number of images of rooms per row.
		 *
		 * @type       {number}
		 */
		let numberOfRoomImagesPerRow = numberOfRoomImages / numberOfRows;

		/**
		 * Determines the height of the image of each room.
		 *
		 * @type       {number}
		 */
		let roomHeight = drawingBoardHeight / numberOfRows;
		/**
		 * Determines the width of the image of each room.
		 *
		 * @type       {number}
		 */
		let roomWidth = drawingBoardWidth / numberOfRoomImagesPerRow;

		let imagesData = harvestDataFromElement('images', '#data');
		/**
		 * Names of all the pictures in the room
		 *
		 * @type       {string[]}
		 */
		let roomImages = [imagesData.room];
		/**
		 * All door picture names.
		 *
		 * @type       {string[]}
		 */
		let doorImages = [imagesData.door, '2.png', '3.png'];
		/**
		 * All tools images names.
		 *
		 * @type       {string[]}
		 */
		let toolImages = [imagesData.tool1, imagesData.tool2, imagesData.tool3, imagesData.tool4];
		/**
		 * Name of the image representing Celestin.
		 *
		 * @type       {string}
		 */
		let celestinImage = imagesData.celestin;
		/**
		 * The name of the image representing the magician
		 *
		 * @type       {string}
		 */
		let wizardImage = 'images/character/2.png';

		/**
		 * The room celestin is currently in.
		 *
		 * @type       {number}
		 */
		let currentRoomNumber = 0;

		/**
		 * The number of answers given by the player.
		 *
		 * @type       {number}
		 */
		let numberOfGivenAnswers = 0;
		/**
		 * The number of correct answers given by the player.
		 *
		 * @type       {number}
		 */
		let numberOfCorrectAnswers = 0;

		/**
		 * The identifier of the correct answer.
		 *
		 * @type       {string}
		 */
		let correctAnswerId = '';

		/**
		 * HTML code representing the gameover screen
		 *
		 * @type       {string}
		 */
		let gameOver = '';

		/**
		 * Contains all rooms.
		 *
		 * @type       {Room[]}
		 */
		let rooms = [];
	
	//add all the rooms
	for (let i = 0; i < numberOfRoomImages; i++) {

		/**
		 * Random index for choosing a random room image.
		 *
		 * @type       {number}
		 */
		let randomRoomImageIndex = Math.floor(Math.random() * roomImages.length);

		rooms[rooms.length] = new Room(i, roomImages[randomRoomImageIndex], doorImages[0]);

		rooms[i].appendTo('#drawing');

		rooms[i].setRoomElementCSS({'position': 'relative'});
		rooms[i].setDoorElementCSS({
			'position': 'absolute',
			'bottom': 0.3*roomHeight,
			'left': 0.7*roomWidth
		});
			
	}
	

	//adjust all elements of the room CSS
		rooms[1].setRoomImgCSS({'width': roomWidth, 'height': roomHeight});
		rooms[1].setDoorImgCSS({
			'width': 0.3*roomWidth,
			'height': 0.3*roomHeight,
			'z-index': '1'
		});

	//create Célestin element element
		
		/**
		 * Character Célestin.
		 *
		 * @type       {Character}
		 */
		let celestin = new Character('celestin', celestinImage);
		celestin.appendTo('#drawing');

	//adjust the CSS of the celestin element
		celestin.setImgCSS({'height': 0.3*roomHeight, 'width': 0.3*roomWidth});
		celestin.setElementCSS({'position': 'absolute', 'top': 0.4*roomHeight, 'left': 0.2*roomWidth});

	//create a wizard element

		/**
		 * A magician character.
		 *
		 * @type       {Character}
		 */
		let wizard = new Character('wizard', wizardImage);
		wizard.appendTo('#drawing');

	//adjust wizard element CSS
		wizard.setImgCSS({'height': 0.3*roomHeight, 'width': 0.3*roomWidth});
		wizard.setElementCSS({
			'position': 'absolute',
			'top': roomHeight+0.4*roomHeight,
			'left': numberOfRoomImagesPerRow*roomWidth-(0.3*roomWidth)
		});

	/////////////////////////////////////////////////////////////////

	spawnPopUp();
	
	//create answers
	spawnAnswers();
	//when clicking on the correct answer
	$('body').on('click', '.answer', function() {
		
		answerId = $(this).attr('id');

		numberOfGivenAnswers++;


		//if the user clicked on the correct answer
		if (answerId === correctAnswerId) {

			questionNumber++;
			numberOfCorrectAnswers++;
			//updateAnswers();

			$('#questionPopUp').remove();
			$('#' + (currentRoomNumber + 1)).show(500);//next room appears
			$('#' + currentRoomNumber).css('filter', 'blur(3px)');//precedent room blurs
			$('#door' + currentRoomNumber).hide(500);

			//animate celestin
			if (currentRoomNumber < numberOfRoomImages-1 && numberOfGivenAnswers < 10) {

				//if we are not at the end of a row
				if (currentRoomNumber+1 < getRowFromRoom(currentRoomNumber, numberOfRoomImagesPerRow) * numberOfRoomImagesPerRow) {

					$(celestin.getId()).animate({left: '+=' + roomWidth + 'px'});
					$('#answerSpace').animate({left: '+=' + roomWidth + 'px'});

				}
				else if (currentRoomNumber+1 == getRowFromRoom(currentRoomNumber, numberOfRoomImagesPerRow) * numberOfRoomImagesPerRow) {

					$(celestin.getId()).animate({left: '-=' + roomWidth * (numberOfRoomImagesPerRow-1) + 'px', top: '+=' + roomHeight + 'px'});
					$('#answerSpace').animate({left: '-=' + roomWidth * (numberOfRoomImagesPerRow-1) + 'px', top: '+=' + roomHeight + 'px'});
							
				}

				currentRoomNumber++;// we finally go to the next room
				spawnPopUp();
					
			}
			

		}
		else {
			$('#essayeEncore').remove();
			$('#questionPopUp').prepend('<p id="essayeEncore"> Essaye encore ! <br/></p>');
			$('#essayeEncore').hide().fadeIn(200);
			$('#essaisRestants').text((10-numberOfGivenAnswers)+' essais restants')
		}

		//if the user has finished the game with all the correct answers 
		if(numberOfCorrectAnswers === 10) {
			$('#answerSpace').remove();
			//what we will show the player at the end of the game
			gameOver = '<div id="gameOver"><h1>Bravo !</h1><br/><h3>Célestin a réussi à passer !</h3><br/></div>';

			//clear the parts and create the gameover element
			$('.room').fadeOut(200);
			$('#drawing').append(gameOver);
		
			//adjust the gameover element and show it
			$('.doorImage').css({'width': 0.3*roomWidth, 'height': 0.3*roomHeight, 'z-index': '1'});
			$('#gameOver').hide().css({
				'text-align': 'center',
				'margin': 'auto',
				'background-color': 'white',
				'font-family': 'Med1',
				'font-size': '2em'
			});
			$('#gameOver').slideDown(2000);
		}
		//if the user has finished the game with at least 8 correct answers but not 10
		else if (numberOfGivenAnswers >= 10 && numberOfCorrectAnswers >= 8) {
			$('#answerSpace').remove();
			$('#questionPopUp').remove();
			//what we will show the player at the end of the game
			gameOver = '<div id="gameOver"><h1>Ouf !</h1><br/><h3>Celestin a réussi à trouver une crevasse pour sortir ! Quelle chance !</h3><br/></div>';

			//clear the rooms and create the gameover element
			$('.room').fadeOut(200);
			$('#drawing').append(gameOver);

			//adjust the gameover element and show it
			$('.doorImage').css({'width': 0.3*roomWidth, 'height': 0.3*roomHeight, 'z-index': '1'});
			$('#gameOver').hide().css({
				'text-align': 'center',
				'margin': 'auto',
				'background-color': 'white',
				'font-family': 'Med1',
				'font-size': '2em'
			});
			$('#gameOver').slideDown(2000);

		}
		//si the user finished the game but with less than 8 correct answers
		else if (numberOfGivenAnswers >= 10) {
			$('#answerSpace').remove();
			$('#questionPopUp').remove();
			//what we will show the player at the end of the game
			gameOver = '<div id="gameOver"><h1>Aïe...</h1><br/><h3>Celestin n\'a pas pu réussir, il est donc parti chercher d\'autres outils !</h3><br/></div>';

			//clear the rooms and create the gameover element
			$('.room').fadeOut(200);
			$('#drawing').append(gameOver);

			//adjust the gameover element and show it
			$('.doorImage').css({'width': 0.3*roomWidth, 'height': 0.3*roomHeight, 'z-index': '1'});
			$('#gameOver').hide().css({
				'text-align': 'center',
				'margin': 'auto',
				'background-color': 'white',
				'font-family': 'Med1',
				'font-size': '2em'
			});
			$('#gameOver').slideDown(2000);
			$(celestin.getId()).animate({left: '-=' + roomWidth * numberOfRoomImagesPerRow + 'px'});
		}

	});

});


