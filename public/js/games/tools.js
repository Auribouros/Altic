//constructors

	/**
	 * Creates an instance of a character.
	 *
	 * @class      Character
	 * @param      {string}  id      The character's identifier
	 * @param      {string}  img     The character's image
	 */
	function Character(id, img, propImg) {
		
		/**
		 * The character's identifier.
		 * 
		 * @type     {string}
		 */
		this.id = id;
		/**
		 * The character's image.
		 * 
		 * @type     {string}
		 */
		this.img = img;
		/**
		 * Prop image
		 * 
		 * @type       {string}
		 */
		this.propImg = (propImg != undefined)? '<img src="' + propImg + '" id="'+ this.id +'PropImage"/>' : '';
		/**
		 * HTML code representing the character.
		 * 
		 * @type     {string}
		 */
		this.html = '<div id="'+ this.id +'">'+
		'<img src="' + this.img + '" id="'+ this.id +'Image"/>'+
		this.propImg +
		'</div>';

		/**
		 * Gets the character's identifier.
		 *
		 * @function
		 * @return     {string}  The identifier.
		 */
		this.getId = function () {
			return '#' + this.id;
		};
		/**
		 * Appends the character to an element.
		 *
		 * @function
		 * @param      {string}  element  The element to append the character to.
		 */
		this.appendTo = function (element) {
			$(element).append(this.html);
		};
		/**
		 * Sets the character's CSS.
		 *
		 * @function   
		 * @param      {Object}  cssRules  The css rules to apply.
		 */
		this.setElementCSS = function (cssRules) {
			$('#'+this.id).css(cssRules);
		};
		/**
		 * Sets the character's image CSS.
		 *
		 * @function   
		 * @param      {Object}  cssRules  The css rules to apply.
		 */
		this.setImgCSS = function (cssRules) {
			$('#'+this.id+'Image').css(cssRules);
		};
		this.setPropImgCSS = function (cssRules) {
			$('#'+this.id+'PropImage').css(cssRules);
		};

	}

	/**
	 * Creates an instance of a room.
	 *
	 * @class      Room
	 * @param      {string}  id       The identifier.
	 * @param      {string}  roomImg  The room image path.
	 * @param      {string}  doorImg  The door image path.
	 */
	function Room(id, roomImg, doorImg) {
		
		/**
		 * The identifier.
		 * 
		 * @type {string}
		 */
		this.id = id;
		/**
		 * The room image path.
		 * 
		 * @type       {string}
		 */
		this.roomImg = roomImg;
		/**
		 * The door image path.
		 * 
		 * @type       {string}
		 */
		this.doorImg = doorImg;
		/**
		 * HTML code representing the room image element.
		 * 
		 * @type       {string}
		 */
		this.roomImageElement = '<img src="'+ this.roomImg +'" class="roomImage"/>';
		/**
		 * HTML code representing the door image element.
		 * 
		 * @type       {string}
		 */
		this.roomDoorImageElement = '<div class="door" id="door'+ this.id +'"><a href="#"><img src="'+ this.doorImg +'" class="doorImage"/></a></div>';
		/**
		 * HTML code representing the room element.
		 * 
		 * @type       {string}
		 */
		this.html = '<span class="room" id="'+ this.id +'">'+ this.roomImageElement + this.roomDoorImageElement +'</span>';

		/**
		 * Gets the identifier.
		 *
		 * @function
		 * @return     {string}  The identifier.
		 */
		this.getId = function () {
			return '#' + this.id;
		};
		/**
		 * Appends the room to an element.
		 *
		 * @function
		 * @param      {string}  element  The element to append the room to.
		 */
		this.appendTo = function (element) {
			$(element).append(this.html);
		};
		/**
		 * Sets the room element css.
		 *
		 * @function
		 * @param      {Object}  cssRules  The css rules to apply.
		 */
		this.setRoomElementCSS = function (cssRules) {
			$('#'+this.id).css(cssRules);
		};
		/**
		 * Sets the room image css.
		 *
		 * @function
		 * @param      {Object}  cssRules  The css rules to apply.
		 */
		this.setRoomImgCSS = function (cssRules) {
			$('.roomImage').css(cssRules);
		};
		/**
		 * Sets the door element css.
		 *
		 * @function
		 * @param      {Object}  cssRules  The css rules to apply.
		 */
		this.setDoorElementCSS = function (cssRules) {
			$('#door'+ this.id).css(cssRules);
		};
		/**
		 * Sets the door image css.
		 *
		 * @function
		 * @param      {Object}  cssRules  The css rules to apply.
		 */
		this.setDoorImgCSS = function (cssRules) {
			$('.doorImage').css(cssRules);
		};

	}

	/**
	 * Instanciates an Answer
	 *
	 * @class      Answer (name)
	 * @param      {string}  id      The identifier
	 * @param      {string}  value   The value
	 * @param      {string}  image   The image
	 */
	function Answer(id, value, image) {
		
		/**
		 * Id
		 * @type       {string}
		 */
		this.id = id;
		/**
		 * Value HTML code
		 * @type       {string}
		 */
		this.value = (value === '') ? '<input type="text"/><button id="answerBtn">Valider</button>' : value;
		/**
		 * Image element HTML code
		 * @type       {string}
		 */
		this.image = (image === undefined) ? '' : '<img class="ansImg" id="ansImg'+ this.id +'" src="'+ image +'"/>';
		/**
		 * The HTML code
		 * @type       {string}
		 */
		this.html = '<a href="#" class="answer" id="'+ this.id +'">'+ this.image + this.value +'</a>';

		/**
		 * Gets the identifier.
		 *
		 * @return     {string}  The identifier.
		 */
		this.getId = function () {
			return '#' + this.id;
		};
		/**
		 * Appends to an element.
		 *
		 * @param      {Object}  element  The element to append this to
		 */
		this.appendTo = function (element) {
			$(element).append(this.html);
		};
		/**
		 * Sets the image css.
		 *
		 * @param      {Object}  rules   The CSS rules to apply
		 */
		this.setImgCSS = function (rules) {
			$('#ansImg'+this.id).css(rules);
		};
		/**
		 * Sets the element css.
		 *
		 * @param      {Object}  rules   The CSS rules to apply
		 */
		this.setElementCSS = function (rules) {
			$('#'+this.id).css(rules);
		};
		/**
		 * Sets the input css.
		 *
		 * @param      {Object}  rules   The CSS rules to apply
		 */
		this.setInputCSS = function (rules) {
			if (value === '') {
				$('#'+this.id+' input').css(rules);
			}
		};


	}
//functions
	
	/**
	 * Returns data from a specified variable in a specified HTML element
	 *
	 * @param      {string}  variableName  The variable name containing data
	 * @param      {string}  element       The HTML element to harvest data from
	 * @return     {string}  Harvested data
	 */
	function harvestDataFromElement(variableName, element) {
		
		return $(element).data(variableName);

	}

	/**
	 * Sends data to the Symfony controller.
	 *
	 * @param      {Object}    data      The data
	 * @param      {string}    url       The controller url
	 * @param      {Function}  callback  The callback function
	 */
	function sendDataToController(data, url, callback) {
		
		$.ajax({
			url: url,
			data: data,
			type: 'POST',
			success: callback,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
		        alert("Status: " + textStatus); 
		        alert("Error: " + errorThrown); 
		    }    
		});

	}
