/**
 * AJAX Upload ( http://valums.com/ajax-upload/ ) 
 * Copyright (c) Andris Valums
 * Licensed under the MIT license ( http://valums.com/mit-license/ )
 * Thanks to Gary Haran, David Mark, Corey Burns and others for contributions 
 */
(function () {
    /* global window */
    /* jslint browser: true, devel: true, undef: true, nomen: true, bitwise: true, regexp: true, newcap: true, immed: true */
    
    /**
     * Wrapper for FireBug's console.log
     */
    function log(){
        if (typeof(console) != 'undefined' && typeof(console.log) == 'function'){            
            Array.prototype.unshift.call(arguments, '[Ajax Upload]');
            console.log( Array.prototype.join.call(arguments, ' '));
        }
    } 

    /**
     * Attaches event to a dom element.
     * @param {Element} el
     * @param type event name
     * @param fn callback This refers to the passed element
     */
    function addEvent(el, type, fn){
        if (el.addEventListener) {
            el.addEventListener(type, fn, false);
        } else if (el.attachEvent) {
            el.attachEvent('on' + type, function(){
                fn.call(el);
	        });
	    } else {
            throw new Error('not supported or DOM not loaded');
        }
    }   
    
    /**
     * Attaches resize event to a window, limiting
     * number of event fired. Fires only when encounteres
     * delay of 100 after series of events.
     * 
     * Some browsers fire event multiple times when resizing
     * http://www.quirksmode.org/dom/events/resize.html
     * 
     * @param fn callback This refers to the passed element
     */
    function addResizeEvent(fn){
        var timeout;
               
	    addEvent(window, 'resize', function(){
            if (timeout){
                clearTimeout(timeout);
            }
            timeout = setTimeout(fn, 100);                        
        });
    }    
    
    // Needs more testing, will be rewriten for next version        
    // getOffset function copied from jQuery lib (http://jquery.com/)
    if (document.documentElement.getBoundingClientRect){
        // Get Offset using getBoundingClientRect
        // http://ejohn.org/blog/getboundingclientrect-is-awesome/
        var getOffset = function(el){
            var box = el.getBoundingClientRect();
            var doc = el.ownerDocument;
            var body = doc.body;
            var docElem = doc.documentElement; // for ie 
            var clientTop = docElem.clientTop || body.clientTop || 0;
            var clientLeft = docElem.clientLeft || body.clientLeft || 0;
             
            // In Internet Explorer 7 getBoundingClientRect property is treated as physical,
            // while others are logical. Make all logical, like in IE8.	
            var zoom = 1;            
            if (body.getBoundingClientRect) {
                var bound = body.getBoundingClientRect();
                zoom = (bound.right - bound.left) / body.clientWidth;
            }
            
            if (zoom > 1) {
                clientTop = 0;
                clientLeft = 0;
            }
            
            var top = box.top / zoom + (window.pageYOffset || docElem && docElem.scrollTop / zoom || body.scrollTop / zoom) - clientTop, left = box.left / zoom + (window.pageXOffset || docElem && docElem.scrollLeft / zoom || body.scrollLeft / zoom) - clientLeft;
            
            
            if (typeof document.documentElement.style.maxHeight == "undefined") { 
	            return {
	                top: (top + 20),
	                left: left
	            };
	        }else{
	            return {
	                top: top,
	                left: left
	            };
	        }
        };        
    } else {
        // Get offset adding all offsets 
        var getOffset = function(el){
            var top = 0, left = 0;
            do {
                top += el.offsetTop || 0;
                left += el.offsetLeft || 0;
                el = el.offsetParent;
            } while (el);
            
            return {
                left: left,
                top: top
            };
        };
    }
    
    /**
     * Returns left, top, right and bottom properties describing the border-box,
     * in pixels, with the top-left relative to the body
     * @param {Element} el
     * @return {Object} Contains left, top, right,bottom
     */
    function getBox(el){
        var left, right, top, bottom;
        var offset = getOffset(el);
        left = offset.left;
        top = offset.top;
        
        right = left + el.offsetWidth;
        bottom = top + el.offsetHeight;
        
        return {
            left: left,
            right: right,
            top: top,
            bottom: bottom
        };
    }
    
    /**
     * Helper that takes object literal
     * and add all properties to element.style
     * @param {Element} el
     * @param {Object} styles
     */
    function addStyles(el, styles){
        for (var name in styles) {
            if (styles.hasOwnProperty(name)) {
                el.style[name] = styles[name];
            }
        }
    }
        
    /**
     * Function places an absolutely positioned
     * element on top of the specified element
     * copying position and dimentions.
     * @param {Element} from
     * @param {Element} to
     */    
    function copyLayout(from, to){
	    var box = getBox(from);
        
        addStyles(to, {
	        position: 'absolute',                    
	        left : box.left + 'px',
	        top : box.top + 'px',
	        width : from.offsetWidth + 'px',
	        height : from.offsetHeight + 'px'
	    });        
    }

    /**
    * Creates and returns element from html chunk
    * Uses innerHTML to create an element
    */
    var toElement = (function(){
        var div = document.createElement('div');
        return function(html){
            div.innerHTML = html;
            var el = div.firstChild;
            return div.removeChild(el);
        };
    })();
            
    /**
     * Function generates unique id
     * @return unique id 
     */
    var getUID = (function(){
        var id = 0;
        return function(){
            return 'ValumsAjaxUpload' + id++;
        };
    })();        
 
    /**
     * Get file name from path
     * @param {String} file path to file
     * @return filename
     */  
    function fileFromPath(file){
        return file.replace(/.*(\/|\\)/, "");
    }
    
    /**
     * Get file extension lowercase
     * @param {String} file name
     * @return file extenstion
     */    
    function getExt(file){
        return (-1 !== file.indexOf('.')) ? file.replace(/.*[.]/, '') : '';
    }

    function hasClass(el, name){        
        var re = new RegExp('\\b' + name + '\\b');        
        return re.test(el.className);
    }    
    function addClass(el, name){
        if ( ! hasClass(el, name)){   
            el.className += ' ' + name;
        }
    }    
    function removeClass(el, name){
        var re = new RegExp('\\b' + name + '\\b');                
        el.className = el.className.replace(re, '');        
    }
    
    function removeNode(el){
        el.parentNode.removeChild(el);
    }

    /**
     * Easy styling and uploading
     * @constructor
     * @param button An element you want convert to 
     * upload button. Tested dimentions up to 500x500px
     * @param {Object} options See defaults below.
     */
    window.AjaxUpload = function(button, options){
        this._settings = {
            // Location of the server-side upload script
            action: 'js/upload.asp',
            // File upload name
            name: 'userfile',
            // Additional data to send
            data: {},
            // Submit file as soon as it's selected
            autoSubmit: true,
            // The type of data that you're expecting back from the server.
            // html and xml are detected automatically.
            // Only useful when you are using json data as a response.
            // Set to "json" in that case. 
            responseType: false,
            // Class applied to button when mouse is hovered
            hoverClass: 'hover',
            // Class applied to button when AU is disabled
            disabledClass: 'disabled',            
            // When user selects a file, useful with autoSubmit disabled
            // You can return false to cancel upload			
            onChange: function(file, extension){
            },
            // Callback to fire before file is uploaded
            // You can return false to cancel upload
            onSubmit: function(file, extension){
            },
            // Fired when file upload is completed
            // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
            onComplete: function(file, response){
            }
        };

                        
        // Merge the users options with our defaults
        for (var i in options) {
            if (options.hasOwnProperty(i)){
                this._settings[i] = options[i];
            }
        }
                
        // button isn't necessary a dom element
        if (button.jquery){
            // jQuery object was passed
            button = button[0];
        } else if (typeof button == "string") {
            if (/^#.*/.test(button)){
                // If jQuery user passes #elementId don't break it					
                button = button.slice(1);                
            }
            
            button = document.getElementById(button);
        }
        
        if ( ! button || button.nodeType !== 1){
			return false;
            throw new Error("Please make sure that you're passing a valid element"); 
        }
                
        if ( button.nodeName.toUpperCase() == 'A'){
            // disable link                       
            addEvent(button, 'click', function(e){
                if (e && e.preventDefault){
                    e.preventDefault();
                } else if (window.event){
                    window.event.returnValue = false;
                }
            });
        }
                    
        // DOM element
        this._button = button;        
        // DOM element                 
        this._input = null;
        // If disabled clicking on button won't do anything
        this._disabled = false;
        
        // if the button was disabled before refresh if will remain
        // disabled in FireFox, let's fix it
        this.enable();        
        
        this._rerouteClicks();
        

    };
    
    // assigning methods to our class
    AjaxUpload.prototype = {
        setData: function(data){
            this._settings.data = data;
        },
        disable: function(){            
            addClass(this._button, this._settings.disabledClass);
            this._disabled = true;
            
            var nodeName = this._button.nodeName.toUpperCase();            
            if (nodeName == 'INPUT' || nodeName == 'BUTTON'){
                this._button.setAttribute('disabled', 'disabled');
            }            
            
            // hide input
            if (this._input){
                // We use visibility instead of display to fix problem with Safari 4
                // The problem is that the value of input doesn't change if it 
                // has display none when user selects a file           
                this._input.parentNode.style.visibility = 'hidden';
            }
        },
        enable: function(){
            removeClass(this._button, this._settings.disabledClass);
            this._button.removeAttribute('disabled');
            this._disabled = false;
            
        },
        /**
         * Creates invisible file input 
         * that will hover above the button
         * <div><input type='file' /></div>
         */
        _createInput: function(){ 
            var self = this;
                        
            var input = document.createElement("input");
            input.setAttribute('type', 'file');
            input.setAttribute('name', this._settings.name);
            //input.setAttribute('id', 'aaa');
            
            
            
            addStyles(input, {
               'position' : 'absolute',
                // in Opera only 'browse' button
                // is clickable and it is located at
                // the right side of the input
                'right' : 0,
                'margin' : 0,
                'padding' : 0,
                'top' : 0,
                'fontSize' : '148px',
               'cursor' : 'pointer'
            });

            var div = document.createElement("div");                        
            addStyles(div, {
                'display' : 'block',
                'position' : 'absolute',
                'overflow' : 'hidden',
                'margin' : 0,
                'padding' : 0,
                'opacity' : 0,
                // Make sure browse button is in the right side
                // in Internet Explorer
                'direction' : 'ltr',
                //Max zIndex supported by Opera 9.0-9.2
                'zIndex': 2147483583
            });
            
            // Make sure that element opacity exists.
            // Otherwise use IE filter            
            if ( div.style.opacity !== "0") {
                if (typeof(div.filters) == 'undefined'){
//                    throw new Error('Opacity not supported by the browser');
                }
                div.style.filter = "alpha(opacity=0)";
            }
            
            addEvent(input, 'change', function(){
                 
                if ( ! input || input.value === ''){                
                    return;                
                }
//				var fileList = input.files
//				fsize=0;
		//		var fileset = input.files[0];
		//		alert(input[0]);
		//		fsize =input.files[0].size;
		//		fsize = fileset.fileSize != null ? fileset.fileSize : fileset.size;
		//		alert(fsize);
		//		if(fsize>140*1024){alert("ファイルサイズが大きすぎます("+(fsize/1024)+"KB)。140KB以下にしてください");return false}

                // Get filename from input, required                
                // as some browsers have path instead of it          
                var file = fileFromPath(input.value);
                                
                if (false === self._settings.onChange.call(self, file, getExt(file))){
                    self._clearInput();                
                    return;
                }
                
                // Submit form when value is changed
                if (self._settings.autoSubmit) {
                    self.submit();
                }
            });            

            addEvent(input, 'mouseover', function(){
                addClass(self._button, self._settings.hoverClass);
            });
            
            addEvent(input, 'mouseout', function(){
                removeClass(self._button, self._settings.hoverClass);
                
                // We use visibility instead of display to fix problem with Safari 4
                // The problem is that the value of input doesn't change if it 
                // has display none when user selects a file           
                input.parentNode.style.visibility = 'hidden';

            });   
                        
	        div.appendChild(input);
            //document.body.appendChild(div);
            document.getElementById("cnt").appendChild(div);
            this._input = input;
        },
        _clearInput : function(){
            if (!this._input){
                return;
            }            
                             
            // this._input.value = ''; Doesn't work in IE6                               
            removeNode(this._input.parentNode);
            this._input = null;                                                                   
            this._createInput();
            
            removeClass(this._button, this._settings.hoverClass);
        },
        /**
         * Function makes sure that when user clicks upload button,
         * the this._input is clicked instead
         */
        _rerouteClicks: function(){
            var self = this;
            
            // IE will later display 'access denied' error
            // if you use using self._input.click()
            // other browsers just ignore click()

            addEvent(self._button, 'mouseover', function(){
                if (self._disabled){
                    return;
                }
                                
                if ( ! self._input){
	                self._createInput();
                }
                
                var div = self._input.parentNode;                            
                copyLayout(self._button, div);
                div.style.visibility = 'visible';
                                
            });
            
            
            // commented because we now hide input on mouseleave
            /**
             * When the window is resized the elements 
             * can be misaligned if button position depends
             * on window size
             */
            //addResizeEvent(function(){
            //    if (self._input){
            //        copyLayout(self._button, self._input.parentNode);
            //    }
            //});            
                                         
        },
        /**
         * Creates iframe with unique name
         * @return {Element} iframe
         */
        _createIframe: function(){
            // We can't use getTime, because it sometimes return
            // same value in safari :(
            var id = getUID();            
             
            // We can't use following code as the name attribute
            // won't be properly registered in IE6, and new window
            // on form submit will open
            // var iframe = document.createElement('iframe');
            // iframe.setAttribute('name', id);                        
 
            var iframe = toElement('<iframe src="javascript:false;" name="' + id + '" />');
            // src="javascript:false; was added
            // because it possibly removes ie6 prompt 
            // "This page contains both secure and nonsecure items"
            // Anyway, it doesn't do any harm.            
            iframe.setAttribute('id', id);
            
            iframe.style.display = 'none';
            document.body.appendChild(iframe);
            
            return iframe;
        },
        /**
         * Creates form, that will be submitted to iframe
         * @param {Element} iframe Where to submit
         * @return {Element} form
         */
        _createForm: function(iframe){
            var settings = this._settings;
                        
            // We can't use the following code in IE6
            // var form = document.createElement('form');
            // form.setAttribute('method', 'post');
            // form.setAttribute('enctype', 'multipart/form-data');
            // Because in this case file won't be attached to request                    
            var form = toElement('<form method="post" enctype="multipart/form-data"></form>');
                        
            form.setAttribute('action', settings.action);
            form.setAttribute('target', iframe.name);                                   
            form.style.display = 'none';
            document.body.appendChild(form);
            
            // Create hidden input element for each data key
            for (var prop in settings.data) {
                if (settings.data.hasOwnProperty(prop)){
                    var el = document.createElement("input");
                    el.setAttribute('type', 'hidden');
                    el.setAttribute('name', prop);
                    el.setAttribute('value', settings.data[prop]);
                    form.appendChild(el);
                }
            }
            return form;
        },
        /**
         * Gets response from iframe and fires onComplete event when ready
         * @param iframe
         * @param file Filename to use in onComplete callback 
         */
        _getResponse : function(iframe, file){            
            // getting response
            var toDeleteFlag = false, self = this, settings = this._settings;   
               
            addEvent(iframe, 'load', function(){                
                
                if (// For Safari 
                    iframe.src == "javascript:'%3Chtml%3E%3C/html%3E';" ||
                    // For FF, IE
                    iframe.src == "javascript:'<html></html>';"){                                                                        
                        // First time around, do not delete.
                        // We reload to blank page, so that reloading main page
                        // does not re-submit the post.
                        
                        if (toDeleteFlag) {
                            // Fix busy state in FF3
                            setTimeout(function(){
                                removeNode(iframe);
                            }, 0);
                        }
                                                
                        return;
                }
                
                var doc = iframe.contentDocument ? iframe.contentDocument : window.frames[iframe.id].document;
                
                // fixing Opera 9.26,10.00
                if (doc.readyState && doc.readyState != 'complete') {
                   // Opera fires load event multiple times
                   // Even when the DOM is not ready yet
                   // this fix should not affect other browsers
                   return;
                }
                
                // fixing Opera 9.64
                if (doc.body && doc.body.innerHTML == "false") {
                    // In Opera 9.64 event was fired second time
                    // when body.innerHTML changed from false 
                    // to server response approx. after 1 sec
                    return;
                }
                
                var response;
                
                if (doc.XMLDocument) {
                    // response is a xml document Internet Explorer property
                    response = doc.XMLDocument;
                } else if (doc.body){
                    // response is html document or plain text
                    response = doc.body.innerHTML;
                    
                    if (settings.responseType && settings.responseType.toLowerCase() == 'json') {
                        // If the document was sent as 'application/javascript' or
                        // 'text/javascript', then the browser wraps the text in a <pre>
                        // tag and performs html encoding on the contents.  In this case,
                        // we need to pull the original text content from the text node's
                        // nodeValue property to retrieve the unmangled content.
                        // Note that IE6 only understands text/html
                        if (doc.body.firstChild && doc.body.firstChild.nodeName.toUpperCase() == 'PRE') {
                            response = doc.body.firstChild.firstChild.nodeValue;
                        }
                        
                        if (response) {
                            response = eval("(" + response + ")");
                        } else {
                            response = {};
                        }
                    }
                } else {
                    // response is a xml document
                    response = doc;
                }
                
                settings.onComplete.call(self, file, response);
                
                // Reload blank page, so that reloading main page
                // does not re-submit the post. Also, remember to
                // delete the frame
                toDeleteFlag = true;
                
                // Fix IE mixed content issue
                iframe.src = "javascript:'<html></html>';";
            });            
        },        
        /**
         * Upload file contained in this._input
         */
        submit: function(){                        
            var self = this, settings = this._settings;
            
            if ( ! this._input || this._input.value === ''){                
                return;                
            }
                                    
            var file = fileFromPath(this._input.value);
            
            // user returned false to cancel upload
            if (false === settings.onSubmit.call(this, file, getExt(file))){
                this._clearInput();                
                return;
            }
            
            // sending request    
            var iframe = this._createIframe();
            var form = this._createForm(iframe);
            
            // assuming following structure
            // div -> input type='file'
            removeNode(this._input.parentNode);            
            removeClass(self._button, self._settings.hoverClass);
                        
            form.appendChild(this._input);
                        
            form.submit();

            // request set, clean up                
            removeNode(form); form = null;                          
            removeNode(this._input); this._input = null;
            
            // Get response from iframe and fire onComplete event when ready
            this._getResponse(iframe, file);            

            // get ready for next request            
            this._createInput();
        }
    };
})(); 


//
// openWYSIWYG v1.0 Copyright (c) 2006 openWebWare.com
// This copyright notice MUST stay intact for use.
//
// An open source WYSIWYG editor for use in web based applications.
// For full source code and docs, visit http://www.openwebware.com/
//
// This library is free software; you can redistribute it and/or modify 
// it under the terms of the GNU Lesser General Public License as published 
// by the Free Software Foundation; either version 2.1 of the License, or 
// (at your option) any later version.
//
// This library is distributed in the hope that it will be useful, but 
// WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
// or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public 
// License for more details.
//
// You should have received a copy of the GNU Lesser General Public License along 
// with this library; if not, write to the Free Software Foundation, Inc., 59 
// Temple Place, Suite 330, Boston, MA 02111-1307 USA 


/* ---------------------------------------------------------------------- *\
  Global Variables: Set global variables such as images directory, 
	                  WYSIWYG Height, Width, and CSS Directory.
\* ---------------------------------------------------------------------- */

// Images Directory
imagesDir = "../img/icons/";

// CSS Directory
cssDir = "../css/";

// Popups Directory
popupsDir = "../help/";

// WYSIWYG Width and Height
wysiwygWidth = 10;
wysiwygHeight = 10;

// Include Style Sheet
document.write('<link rel="stylesheet" type="text/css" href="' +cssDir+ 'styles.css">\n');


/* ---------------------------------------------------------------------- *\
  Toolbar Settings: Set the features and buttons available in the WYSIWYG
	                  Toolbar.
\* ---------------------------------------------------------------------- */


// List of available font types
  var Fonts = new Array();
  Fonts[0] = "Arial";
  Fonts[1] = "Sans Serif";
  Fonts[2] = "Tahoma";
	Fonts[3] = "Verdana";
	Fonts[4] = "Courier New";
	Fonts[5] = "Georgia";
	Fonts[6] = "Times New Roman";
	Fonts[7] = "Impact";
  Fonts[8] = "Comic Sans MS";

// List of available block formats (not in use)
var BlockFormats = new Array();
  BlockFormats[0]  = "Address";
  BlockFormats[1]  = "Bulleted List";
  BlockFormats[2]  = "Definition";
	BlockFormats[3]  = "Definition Term";
	BlockFormats[4]  = "Directory List";
	BlockFormats[5]  = "Formatted";
	BlockFormats[6]  = "Heading 1";
	BlockFormats[7]  = "Heading 2";
	BlockFormats[8]  = "Heading 3";
	BlockFormats[9]  = "Heading 4";
	BlockFormats[10] = "Heading 5";
	BlockFormats[11] = "Heading 6";
	BlockFormats[12] = "Menu List";
	BlockFormats[13] = "Normal";
	BlockFormats[14] = "Numbered List";

// List of available font sizes
var FontSizes = new Array();
  FontSizes[0]  = "1";
  FontSizes[1]  = "2";
  FontSizes[2]  = "3";
	FontSizes[3]  = "4";
	FontSizes[4]  = "5";
	FontSizes[5]  = "7";
	FontSizes[6]  = "9";

// Order of available commands in toolbar one
var buttonName = new Array();
  buttonName[0]  = "bold";
  buttonName[1]  = "italic";
  buttonName[2]  = "underline";
	//buttonName[3]  = "strikethrough";
  buttonName[4]  = "seperator";
	buttonName[5]  = "subscript";
	buttonName[6]  = "superscript";
	buttonName[7]  = "seperator";
	buttonName[8]  = "justifyleft";
	buttonName[9]  = "justifycenter";
	buttonName[10] = "justifyright";
	buttonName[11] = "seperator";
	buttonName[12] = "unorderedlist";
	buttonName[13] = "orderedlist";
	buttonName[14] = "outdent";
	buttonName[15] = "indent";

// Order of available commands in toolbar two
var buttonName2 = new Array();
  buttonName2[0]  = "forecolor";
	buttonName2[1]  = "backcolor";
//	buttonName2[2]  = "seperator";
//	buttonName2[3]  = "seperator";
//	buttonName2[4]  = "undo";
//	buttonName2[5]  = "redo";
	buttonName2[6]  = "seperator";
	buttonName2[7]  = "createlink";
//	buttonName2[8]  = "seperator";
//	buttonName2[9]  = "seperator";
	
// List of available actions and their respective ID and images
var ToolbarList = {
//Name              buttonID                 buttonTitle           buttonImage                            buttonImageRollover
  "bold":           ['Bold',                 'Bold',               imagesDir + 'bold.gif',               imagesDir + 'bold_on.gif'],
  "italic":         ['Italic',               'Italic',             imagesDir + 'italics.gif',            imagesDir + 'italics_on.gif'],
  "underline":      ['Underline',            'Underline',          imagesDir + 'underline.gif',          imagesDir + 'underline_on.gif'],
	"strikethrough":  ['Strikethrough',        'Strikethrough',      imagesDir + 'strikethrough.gif',      imagesDir + 'strikethrough_on.gif'],
	"seperator":      ['',                     '',                   imagesDir + 'seperator.gif',          imagesDir + 'seperator.gif'],
	"subscript":      ['Subscript',            'Subscript',          imagesDir + 'subscript.gif',          imagesDir + 'subscript_on.gif'],
	"superscript":    ['Superscript',          'Superscript',        imagesDir + 'superscript.gif',        imagesDir + 'superscript_on.gif'],
	"justifyleft":    ['Justifyleft',          'Justifyleft',        imagesDir + 'justify_left.gif',       imagesDir + 'justify_left_on.gif'],
	"justifycenter":  ['Justifycenter',        'Justifycenter',      imagesDir + 'justify_center.gif',     imagesDir + 'justify_center_on.gif'],
	"justifyright":   ['Justifyright',         'Justifyright',       imagesDir + 'justify_right.gif',      imagesDir + 'justify_right_on.gif'],
	"unorderedlist":  ['InsertUnorderedList',  'InsertUnorderedList',imagesDir + 'list_unordered.gif',     imagesDir + 'list_unordered_on.gif'],
	"orderedlist":    ['InsertOrderedList',    'InsertOrderedList',  imagesDir + 'list_ordered.gif',       imagesDir + 'list_ordered_on.gif'],
	"outdent":        ['Outdent',              'Outdent',            imagesDir + 'indent_left.gif',        imagesDir + 'indent_left_on.gif'],
	"indent":         ['Indent',               'Indent',             imagesDir + 'indent_right.gif',       imagesDir + 'indent_right_on.gif'],
	"cut":            ['Cut',                  'Cut',                imagesDir + 'cut.gif',                imagesDir + 'cut_on.gif'],
	"copy":           ['Copy',                 'Copy',               imagesDir + 'copy.gif',               imagesDir + 'copy_on.gif'],
  "paste":          ['Paste',                'Paste',              imagesDir + 'paste.gif',              imagesDir + 'paste_on.gif'],
	"forecolor":      ['ForeColor',            'ForeColor',          imagesDir + 'forecolor.gif',          imagesDir + 'forecolor_on.gif'],
	"backcolor":      ['BackColor',            'BackColor',          imagesDir + 'backcolor.gif',          imagesDir + 'backcolor_on.gif'],
	"undo":           ['Undo',                 'Undo',               imagesDir + 'undo.gif',               imagesDir + 'undo_on.gif'],
	"redo":           ['Redo',                 'Redo',               imagesDir + 'redo.gif',               imagesDir + 'redo_on.gif'],
	"inserttable":    ['InsertTable',          'InsertTable',        imagesDir + 'insert_table.gif',       imagesDir + 'insert_table_on.gif'],
	"insertimage":    ['InsertImage',          'InsertImage',        imagesDir + 'insert_picture.gif',     imagesDir + 'insert_picture_on.gif'],
	"createlink":     ['CreateLink',           'CreateLink',         imagesDir + 'insert_hyperlink.gif',   imagesDir + 'insert_hyperlink_on.gif'],
	"viewSource":     ['ViewSource',           'ViewSource',         imagesDir + 'view_source.gif',        imagesDir + 'view_source_on.gif'],
	"viewText":       ['ViewText',             'ViewText',           imagesDir + 'view_text.gif',          imagesDir + 'view_text_on.gif'],
	"help":           ['Help',                 'Help',               imagesDir + 'help.gif',               imagesDir + 'help_on.gif'],
	"selectfont":     ['SelectFont',           'SelectFont',         imagesDir + 'select_font.gif',        imagesDir + 'select_font_on.gif'],
	"selectsize":     ['SelectSize',           'SelectSize',         imagesDir + 'select_size.gif',        imagesDir + 'select_size_on.gif']
};



/* ---------------------------------------------------------------------- *\
  Function    : insertAdjacentHTML(), insertAdjacentText() and insertAdjacentElement()
  Description : Emulates insertAdjacentHTML(), insertAdjacentText() and 
	              insertAdjacentElement() three functions so they work with 
								Netscape 6/Mozilla
  Notes       : by Thor Larholm me@jscript.dk
\* ---------------------------------------------------------------------- */
if(typeof HTMLElement!="undefined" && !HTMLElement.prototype.insertAdjacentElement){
  HTMLElement.prototype.insertAdjacentElement = function
  (where,parsedNode)
	{
	  switch (where){
		case 'beforeBegin':
			this.parentNode.insertBefore(parsedNode,this)
			break;
		case 'afterBegin':
			this.insertBefore(parsedNode,this.firstChild);
			break;
		case 'beforeEnd':
			this.appendChild(parsedNode);
			break;
		case 'afterEnd':
			if (this.nextSibling) 
      this.parentNode.insertBefore(parsedNode,this.nextSibling);
			else this.parentNode.appendChild(parsedNode);
			break;
		}
	}

	HTMLElement.prototype.insertAdjacentHTML = function
  (where,htmlStr)
	{
		var r = this.ownerDocument.createRange();
		r.setStartBefore(this);
		var parsedHTML = r.createContextualFragment(htmlStr);
		this.insertAdjacentElement(where,parsedHTML)
	}


	HTMLElement.prototype.insertAdjacentText = function
  (where,txtStr)
	{
		var parsedText = document.createTextNode(txtStr)
		this.insertAdjacentElement(where,parsedText)
	}
};


// Create viewTextMode global variable and set to 0
// enabling all toolbar commands while in HTML mode
viewTextMode = 0;



var toolbarid;
function toolbardisp(textareaID){
	if(document.getElementById('box_wysiwyg'+toolbarid)){
	document.getElementById('box_wysiwyg'+toolbarid).style.border='';
	document.getElementById('box_wysiwyg'+toolbarid).style.backgroundColor='';
	if(document.getElementById(toolbarid+'_edit')){document.getElementById(toolbarid+'_edit').style.display = 'none'; }
	}
	toolbarid=textareaID;
	document.getElementById('box_wysiwyg'+toolbarid).style.border='dashed 1px black';
	document.getElementById('box_wysiwyg'+toolbarid).style.backgroundColor='#FFEE99';
	document.getElementById(toolbarid+'_edit').style.display = 'block'; 
}


function open_config(ints,nodes){
	if(nodes.value=='入力設定を開く'){
		nodes.value='入力設定を閉じる';
		document.getElementById('s_box'+ints+'_config').style.display='block';
	}else{
		nodes.value='入力設定を開く';
		document.getElementById('s_box'+ints+'_config').style.display='none';
	}
}

function heightset(textareaID){
	if(document.getElementById("wysiwyg" + textareaID)){
		var doc = document.getElementById("wysiwyg" + textareaID).contentWindow.document;
		if(doc.body){
			document.getElementById("wysiwyg" + textareaID).style.height=doc.body.offsetHeight*1.1+10+'px';
		}else{
			document.getElementById("wysiwyg" + textareaID).style.height="120px";
		}
	}
//	alert(document.getElementById("wysiwyg" + textareaID).style.height);
}
/* ---------------------------------------------------------------------- *\
  Function    : generate_wysiwyg()
  Description : replace textarea with wysiwyg editor
  Usage       : generate_wysiwyg("textarea_id");
  Arguments   : textarea_id - ID of textarea to replace
\* ---------------------------------------------------------------------- */
function creatboxerea(ints) {
boxco++;
ints++;
var intext="";
var newid="s_box" + ints;

tagObj = document.createElement("div");
tagObj.id= newid;
tagObj.style.borderbottom= "1px dashed #ccc";
tagObj.className =  "container editmainbox";
document.getElementById("editbox").appendChild(tagObj);

intext += '<input type="hidden" name="' + newid + '_del" value="0" />\n'
intext += '<div class="' + newid + '_c1" style="width:100px; float:left; margin-right:10px;">\n'
intext += '<textarea id="' + newid + '_d1" name="' + newid + '_d1" style="width:100px; border:0;" rows="8">項目名</textarea>\n'
intext += '</div>\n'
intext += '<div class="' + newid + '_c2" style="width:300px; float:left">\n'
intext += '	<textarea id="' + newid + '_d2" name="' + newid + '_d2" style=" width:100%; height:60px;border:0;">例）入力してください</textarea>\n'
intext += '	<div id="' + newid + '_input">\n'
intext += '	<textarea rows="4" cols="40"></textarea>\n'
intext += '	</div>\n'

 intext += '<input type="button" onclick="open_config('+ints+',this)" value="入力設定を開く" />'
 intext += '	<div id="' + newid + '_config" style="display:none">'
 intext += '	<table>'
 intext += '	<tr>'
 intext += '	<th abbr="入力タイプ"><label for="' + newid + '_input_type">入力タイプ</label></th>'
 intext += '	<td><select name="' + newid + '_input_type" id="' + newid + '_input_type" onchange="write_input('+ints+')">'
 intext += '	<option value="0">マルチラインテキスト</option>'
 intext += '	<option value="1">シングルラインテキスト</option>'
 intext += '	<option value="2">セレクトボックス（単一選択型）</option>'
 intext += '	<option value="3">セレクトボックス（複数選択型）</option>'
 intext += '	<option value="4">チェックボックス（単一選択型）</option>'
 intext += '	<option value="5">チェックボックス（複数選択型）</option>'
 intext += '	</select>'
 intext += '	</td>'
 intext += '	</tr>'
 intext += '	<tr id="' + newid + '_input_defs1">'
 intext += '	<th abbr="入力タイプ"><label for="' + newid + '_input_def1">初期値</label></th>'
 intext += '	<td>'
 intext += '	入力ボックスに最初から入っているテキストを入力してください。<br />'
 intext += '<textarea id="' + newid + '_input_def1" name="' + newid + '_input_def1" onchange="write_input('+ints+')" rows="4" cols="30"></textarea>'
 intext += '	</td>'
 intext += '	</tr>'
 intext += '	<tr id="' + newid + '_input_defs2" style="display:none">'
 intext += '	<th abbr="入力タイプ"><label for="' + newid + '_input_def2">初期値</label></th>'
 intext += '	<td>'
 intext += '	入力ボックスに最初から入っている、または選択されているテキストを入力してください。<br />'
 intext += '	<input name="' + newid + '_input_def2" type="text" id="' + newid + '_input_def2" onchange="write_input('+ints+')" value="" />'
 intext += '	</td>'
 intext += '	</tr>'
 intext += '	<tr id="' + newid + '_input_select" style="display:none">'
 intext += '	<th abbr="選択内容"><label for="' + newid + '_input_new">選択内容</label></th>'
 intext += '	<td>'
 intext += '		<div id="' + newid + '_input_selects">未設定</div>'
 intext += '		<div style="padding-left:15px;"><input value="" name="' + newid + '_input_new" id="' + newid + '_input_new" /><input type="button" onclick="addselect('+ints+')" value="選択項目追加" /></div>'
 intext += '	</td>'
 intext += '	</tr>'
 intext += '	</table>'


intext += '</div>\n'


document.getElementById(newid).innerHTML=intext;


generate_wysiwyg(newid+'_d1',0);
generate_wysiwyg(newid+'_d2',0);
toolbardisp(newid);


}
function setline(ints,mode,no){
var newid="s_box" + ints;
var intext="";
var selectbox=document.getElementById(newid+"_input_selects");
switch(parseInt(mode)){
	case 1://削除
		selectbox.getElementsByTagName("div")[no]=null;
	break;
	case 2://上と入れ替え
		if(no!=0 && selectbox.getElementsByTagName("div").length!=1){
			intext=selectbox.getElementsByTagName("input")[no-1].value;
			selectbox.getElementsByTagName("input")[no-1].value=selectbox.getElementsByTagName("input")[no].value;
			selectbox.getElementsByTagName("input")[no].value=intext;
		}
	break;
	case 3://下と入れ替え
		if(no!=selectbox.getElementsByTagName("div").length && selectbox.getElementsByTagName("div").length!=1){
			intext=selectbox.getElementsByTagName("input")[no+1].value;
			selectbox.getElementsByTagName("input")[no+1].value=selectbox.getElementsByTagName("input")[no].value;
			selectbox.getElementsByTagName("input")[no].value=intext;
		}
	break;
}
write_input(ints);
}
function addselect(ints){
var newid="s_box" + ints;
var intext="";
var tagco=0;
var selectbox=document.getElementById(newid+"_input_selects");
tagco=selectbox.getElementsByTagName("div").length;

var	tagObj = document.createElement("div");
intext='<a href="javascript:setline('+ints+',1,'+tagco+')">×</a> <input type="text" size="20" value="'+document.getElementById(newid+"_input_new").value+'" name="'+newid+'_selectword" onchange="write_input('+ints+')" /><a href="javascript:setline('+ints+',2,'+tagco+')">▲</a> <a href="javascript:setline('+ints+',3,'+tagco+')">▼</a>';
tagObj.innerHTML=intext;
document.getElementById(newid+"_input_new").value='';

	selectbox.appendChild(tagObj);
	write_input(ints);
}
function write_input(ints){
var newid="s_box" + ints;
var intext="";
var inputtype;
var maruti="";
var selectword="";
var deftext;
var sw="";
inputtype=document.getElementById(newid+"_input_type");
if(inputtype){
	if(parseInt(inputtype.value)==0){
		document.getElementById(newid+"_input_defs1").style.display="";
		document.getElementById(newid+"_input_defs2").style.display="none";
		document.getElementById(newid+"_input_select").style.display="none";
		deftext=document.getElementById(newid+"_input_def1").value;
	}else{
		deftext=document.getElementById(newid+"_input_def2").value;
		document.getElementById(newid+"_input_defs1").style.display="none";
		document.getElementById(newid+"_input_defs2").style.display="";
		document.getElementById(newid+"_input_select").style.display="";
	}
	switch(parseInt(inputtype.value)){
		case 0:
		intext='<textarea rows="4" cols="30">'+deftext+'</textarea>'
		break;
		case 1:
		intext='<input type="text" value="'+deftext+'" siez="20" />'
		break;
		case 3:
		maruti=' multiple="multiple"'
		case 2:
		if(document.getElementsByName(newid+"_selectword")){
			for(i=0;i<document.getElementsByName(newid+"_selectword").length;i++){
				sw=document.getElementsByName(newid+"_selectword")[i].value;
				if(sw!=''){
					selectword += '<option value="'+sw+'"'
					if(sw==deftext){selectword += ' selected="selected"'}
					selectword += '>'+sw+'</option>'
				}
			}
		}
		if(selectword != ''){
			intext='<select'+maruti+'>'+selectword+'</select>';
		}else{
			intext='選択項目を設定してください';
		}
		break;
		case 4:
		maruti="radio"
		case 5:
		maruti="checkbox"
		default:
		if(document.getElementsByName(newid+"_selectword")){
			for(i=0;i<document.getElementsByName(newid+"_selectword").length;i++){
				sw=document.getElementsByName(newid+"_selectword")[i].value;
				if(sw!=''){
					selectword += '<li style="width:140px;float:left;"><input type="'+maruti+'" value="'+sw+'"';
					if(sw==deftext){selectword += ' checked="checked"'}
					selectword += ' />　'+sw;+"</li>"
				}
			}
		}
		if(selectword != ''){
			intext='<ul class="container">'+selectword+'</ul>';
		}else{
			intext='選択項目を設定してください';
		}


	}
	document.getElementById(newid+"_input").innerHTML=intext;
}
	
}

function generate_wysiwyg(textareaID,mode) {
	
 
	
  // Pass the textareaID to the "n" variable.
  var n = textareaID;
  toolbarid=n;
	
	// Toolbars width is 2 pixels wider than the wysiwygs
	toolbarWidth = parseFloat(wysiwygWidth) + 2;
	
  // Generate WYSIWYG toolbar one
  var toolbar;
  toolbar='<div id="'+textareaID+'_edit" style=" position:absolute; top:0;left:0;">';
//  toolbar = toolbar +  '<img src="' +imagesDir+ 'seperator2.gif" alt="" hspace="3"></td>';
  
	// Create IDs for inserting Font Type and Size drop downs
//	toolbar += '<table class="nobordert"><tr>'
//	toolbar += '<td><span id="FontSelect' + n + '" style="width:140px;flot:left"></span></td>';
//	toolbar += '<td><span id="FontSizes'  + n + '" style="width:140px;flot:left"></span></td>';
//	toolbar += '<td>'
  
	// Output all command buttons that belong to toolbar one
	for (var i = 0; i <= buttonName.length;) { 
    if (buttonName[i]) {
	    var buttonObj            = ToolbarList[buttonName[i]];
		  var buttonID             = buttonObj[0];
	    var buttonTitle          = buttonObj[1];
      var buttonImage          = buttonObj[2];
		  var buttonImageRollover  = buttonObj[3];
	    
			if (buttonName[i] == "seperator") {
		    toolbar += '<img src="' +buttonImage+ '" border=0 unselectable="on" width="2" height="18" hspace="2" unselectable="on">';
			}
	    else {
		    toolbar += '<img src="' +buttonImage+ '" border=0 unselectable="on" title="' +buttonTitle+ '" id="' +buttonID+ '" class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' + buttonImageRollover + '\';" onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' + buttonImage + '\';" unselectable="on" width="20" height="20">';
	    }
    }
    i++;
  }

//  toolbar += '<td>&nbsp;</td></tr></table>';  

  // Generate WYSIWYG toolbar two
  var toolbar2="";
//  toolbar2 = '<table cellpadding="0" cellspacing="0" border="0" class="toolbar2"><tr><td style="width: 6px;"><img src="' +imagesDir+ 'seperator2.gif" alt="" hspace="3"></td>';
 
  // Output all command buttons that belong to toolbar two
  for (var j = 0; j <= buttonName2.length;) {
    if (buttonName2[j]) {
	    var buttonObj            = ToolbarList[buttonName2[j]];
		  var buttonID             = buttonObj[0];
	    var buttonTitle          = buttonObj[1];
      var buttonImage          = buttonObj[2];
		  var buttonImageRollover  = buttonObj[3];
	  
		  if (buttonName2[j] == "seperator") {
		    toolbar2 += '<img src="' +buttonImage+ '" border=0 unselectable="on" width="2" height="18" hspace="2" unselectable="on">';
			}
	    else if (buttonName2[j] == "viewSource"){
//		    toolbar2 += '<td style="width: 22px;">';
				toolbar2 += '<span id="HTMLMode' + n + '"><img src="'  +buttonImage+  '" border=0 unselectable="on" title="' +buttonTitle+ '" id="' +buttonID+ '" class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' +buttonImageRollover+ '\';" onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' + buttonImage + '\';" unselectable="on"  width="20" height="20"></span>';
				toolbar2 += '<span id="textMode' + n + '"><img src="' +imagesDir+ 'view_text.gif" border=0 unselectable="on" title="viewText"          id="ViewText"       class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' +imagesDir+ 'view_text_on.gif\';"    onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' +imagesDir+ 'view_text.gif\';" unselectable="on"  width="20" height="20"></span>';
//	      toolbar2 += '</td>';
			}
	    else {
		    toolbar2 += '<img src="' +buttonImage+ '" border=0 unselectable="on" title="' +buttonTitle+ '" id="' +buttonID+ '" class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' +buttonImageRollover+ '\';" onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' + buttonImage + '\';" unselectable="on" width="20" height="20">';
	    }
    }
    j++;
  }

//  toolbar2 += '<td>&nbsp;</td></tr></table>';  
	


	// Create iframe which will be used for rich text editing
if(mode==2){
	var iframe = '<div id="box_wysiwyg' + n + '">';

iframe = iframe + '<iframe frameborder="0" id="wysiwyg' + n + '" name="wysiwyg' + n + '" style=" width:95%;border:1px solid #7F9DB9;" height="200"></iframe>\n' + '</div>';
}else{
	var iframe = '<div id="box_wysiwyg' + n + '" onmouseover="toolbardisp(\'' + n + '\')" onmouseout="heightset(\'' + n + '\')">';
iframe = iframe + '<iframe frameborder="0" id="wysiwyg' + n + '" name="wysiwyg' + n + '" style=" width:100%;" onkeydown="this.offsetHeight" height="200"></iframe>\n' + '</div>';
}

  // Insert after the textArea both toolbar one and two
//  document.getElementById(n).insertAdjacentHTML("afterEnd", toolbar + toolbar2 + '</td></tr></table></div>' + iframe);
  document.getElementById(n).insertAdjacentHTML("afterEnd", toolbar + toolbar2 + '</div>' + iframe);

//テキストエリアのフォーカスイベントのセット
//	addListener(document.getElementById(textareaID), 'click', toolbardisp, false);
//	alert(document.getElementById(textareaID).onClick);

//	if(document.getElementById(textareaID).offsetWidth){document.getElementById("wysiwyg" + n).offsetWidth=document.getElementById(textareaID).offsetWidth;}



  // Insert the Font Type and Size drop downs into the toolbar
//	outputFontSelect(n);
//	outputFontSizes(n); 
	
  // Hide the dynamic drop down lists for the Font Types and Sizes
//  hideFonts(n);
//	hideFontSizes(n);
	
	
	// Give the iframe the global wysiwyg height and width
//  document.getElementById("wysiwyg" + n).style.height = wysiwygHeight + "px";
//  document.getElementById("wysiwyg" + n).style.width = wysiwygWidth + "px";
	
	// Pass the textarea's existing text over to the content variable
  var content = document.getElementById(n).value;
	
	var doc = document.getElementById("wysiwyg" + n).contentWindow.document;
	
	// Write the textarea's content into the iframe
 var content2=content;
  doc.open();
  if(content==''){content='<div></div>'}
doc.write(content);
  if(content2==''&&doc.body){
	  doc.body.innerHTML="";
	}
  if(doc.body){
  doc.body.style.fontSize="75%";
  doc.body.style.padding=0;
  doc.body.style.margin=0;
  }
  doc.close();
//	addListener(document.getElementById(textareaID), 'click', toolbardisp, false);

	
	// Hide the "Text Mode" button
if(mode==2){
}else{
	heightset(n);
}

  	// Hide the textarea 
document.getElementById(n).style.display = 'none'; 
//document.getElementById("textMode" + n).style.display = 'none'; 

// Make the iframe editable in both Mozilla and IE
  doc.body.contentEditable = true;
  doc.designMode = "on";
  	// Update the textarea with content in WYSIWYG when user submits form
  var browserName = navigator.appName;
  if (browserName == "Microsoft Internet Explorer") {
    for (var idx=0; idx < document.forms.length; idx++) {
      document.forms[idx].attachEvent('onsubmit', function() { updateTextArea(n); });
    }
  }
  else {
  	for (var idx=0; idx < document.forms.length; idx++) {
    	document.forms[idx].addEventListener('submit',function OnSumbmit() { updateTextArea(n); }, true);
    }
  }
 	

};



/* ---------------------------------------------------------------------- *\
  Function    : formatText()
  Description : replace textarea with wysiwyg editor
  Usage       : formatText(id, n, selected);
  Arguments   : id - The execCommand (e.g. Bold)
                n  - The editor identifier that the command 
								     affects (the textarea's ID)
                selected - The selected value when applicable (e.g. Arial)
\* ---------------------------------------------------------------------- */
function formatText(id, n, selected) {

  // When user clicks toolbar button make sure it always targets its respective WYSIWYG
  document.getElementById("wysiwyg" + n).contentWindow.focus();
	
	// When in Text Mode these execCommands are disabled
	var formatIDs = new Array("FontSize","FontName","Bold","Italic","Underline","Subscript","Superscript","Strikethrough","Justifyleft","Justifyright","Justifycenter","InsertUnorderedList","InsertOrderedList","Indent","Outdent","ForeColor","BackColor","InsertImage","InsertTable","CreateLink");
  
	// Check if button clicked is in disabled list
	for (var i = 0; i <= formatIDs.length;) {
		if (formatIDs[i] == id) {
			 var disabled_id = 1; 
		}
	  i++;
	}
	
	// Check if in Text Mode and disabled button was clicked
	if (viewTextMode == 1 && disabled_id == 1) {
	  alert ("You are in HTML Mode. This feature has been disabled.");	
	}
	
	else {
	
	  // FontSize
	  if (id == "FontSize") {
      document.getElementById("wysiwyg" + n).contentWindow.document.execCommand("FontSize", false, selected);
	  }
	  
		// FontName
	  else if (id == "FontName") {
      document.getElementById("wysiwyg" + n).contentWindow.document.execCommand("FontName", false, selected);
	  }
	
	  // ForeColor and BackColor
    else if (id == 'ForeColor' || id == 'BackColor') {
      var w = screen.availWidth;
      var h = screen.availHeight;
      var popW = 210, popH = 165;
      var leftPos = (w-popW)/2, topPos = (h-popH)/2;
      var currentColor = _dec_to_rgb(document.getElementById("wysiwyg" + n).contentWindow.document.queryCommandValue(id));
   
	    window.open(popupsDir + 'select_color.html?color=' + currentColor + '&command=' + id + '&wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
    }
	  
		// InsertImage
	  else if (id == "InsertImage") {
      window.open(popupsDir + 'insert_image.html?wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,resizable=0,width=400,height=190');
	  }
	  
		// InsertTable
	  else if (id == "InsertTable") {
	    window.open(popupsDir + 'create_table.html?wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,resizable=0,width=400,height=360');
	  }
	  
		// CreateLink
	  else if (id == "CreateLink") {
	    window.open(popupsDir + 'insert_hyperlink.html?wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,resizable=0,width=300,height=110');
	  }
	  
		// ViewSource
    else if (id == "ViewSource") {
	    viewSource(n);
	  }
		
		// ViewText
		else if (id == "ViewText") {
	    viewText(n);
	  }

		// Help
		else if (id == "Help") {
	    window.open(popupsDir + 'about.html','popup','location=0,status=0,scrollbars=0,resizable=0,width=400,height=330');
	  }
	  
		// Every other command
	  else {
      document.getElementById("wysiwyg" + n).contentWindow.document.execCommand(id, false, null);
		}
  }
};



/* ---------------------------------------------------------------------- *\
  Function    : insertHTML()
  Description : insert HTML into WYSIWYG in rich text
  Usage       : insertHTML(<b>hello</b>, "textareaID")
  Arguments   : html - The HTML being inserted (e.g. <b>hello</b>)
                n  - The editor identifier that the HTML 
								     will be inserted into (the textarea's ID)
\* ---------------------------------------------------------------------- */
function insertHTML(html, n) {

  var browserName = navigator.appName;
	 	 
	if (browserName == "Microsoft Internet Explorer") {	  
	  document.getElementById('wysiwyg' + n).contentWindow.document.selection.createRange().pasteHTML(html);   
	} 
	 
	else {
	  var div = document.getElementById('wysiwyg' + n).contentWindow.document.createElement("div");
		 
		div.innerHTML = html;
		var node = insertNodeAtSelection(div, n);		
	}
	
}


/* ---------------------------------------------------------------------- *\
  Function    : insertNodeAtSelection()
  Description : insert HTML into WYSIWYG in rich text (mozilla)
  Usage       : insertNodeAtSelection(insertNode, n)
  Arguments   : insertNode - The HTML being inserted (must be innerHTML 
	                           inserted within a div element)
                n          - The editor identifier that the HTML will be 
								             inserted into (the textarea's ID)
\* ---------------------------------------------------------------------- */
function insertNodeAtSelection(insertNode, n) {
  // get current selection
  var sel = document.getElementById('wysiwyg' + n).contentWindow.getSelection();

  // get the first range of the selection
  // (there's almost always only one range)
  var range = sel.getRangeAt(0);

  // deselect everything
  sel.removeAllRanges();

  // remove content of current selection from document
  range.deleteContents();

  // get location of current selection
  var container = range.startContainer;
  var pos = range.startOffset;

  // make a new range for the new selection
  range=document.createRange();

  if (container.nodeType==3 && insertNode.nodeType==3) {

    // if we insert text in a textnode, do optimized insertion
    container.insertData(pos, insertNode.nodeValue);

    // put cursor after inserted text
    range.setEnd(container, pos+insertNode.length);
    range.setStart(container, pos+insertNode.length);
  } 
	
	else {
    var afterNode;
    
		if (container.nodeType==3) {
      // when inserting into a textnode
      // we create 2 new textnodes
      // and put the insertNode in between

      var textNode = container;
      container = textNode.parentNode;
      var text = textNode.nodeValue;

      // text before the split
      var textBefore = text.substr(0,pos);
      // text after the split
      var textAfter = text.substr(pos);

      var beforeNode = document.createTextNode(textBefore);
      afterNode = document.createTextNode(textAfter);

      // insert the 3 new nodes before the old one
      container.insertBefore(afterNode, textNode);
      container.insertBefore(insertNode, afterNode);
      container.insertBefore(beforeNode, insertNode);

      // remove the old node
      container.removeChild(textNode);
    } 
	
	  else {
      // else simply insert the node
      afterNode = container.childNodes[pos];
      container.insertBefore(insertNode, afterNode);
    }

    range.setEnd(afterNode, 0);
    range.setStart(afterNode, 0);
  }

  sel.addRange(range);
};

	

/* ---------------------------------------------------------------------- *\
  Function    : _dec_to_rgb
  Description : convert a decimal color value to rgb hexadecimal
  Usage       : var hex = _dec_to_rgb('65535');   // returns FFFF00
  Arguments   : value   - dec value
\* ---------------------------------------------------------------------- */

function _dec_to_rgb(value) {
  var hex_string = "";
  for (var hexpair = 0; hexpair < 3; hexpair++) {
    var myByte = value & 0xFF;            // get low byte
    value >>= 8;                          // drop low byte
    var nybble2 = myByte & 0x0F;          // get low nybble (4 bits)
    var nybble1 = (myByte >> 4) & 0x0F;   // get high nybble
    hex_string += nybble1.toString(16);   // convert nybble to hex
    hex_string += nybble2.toString(16);   // convert nybble to hex
  }
  return hex_string.toUpperCase();
};



/* ---------------------------------------------------------------------- *\
  Function    : outputFontSelect()
  Description : creates the Font Select drop down and inserts it into 
	              the toolbar
  Usage       : outputFontSelect(n)
  Arguments   : n   - The editor identifier that the Font Select will update
	                    when making font changes (the textarea's ID)
\* ---------------------------------------------------------------------- */
function outputFontSelect(n) {

  var FontSelectObj        = ToolbarList['selectfont'];
  var FontSelect           = FontSelectObj[2];
  var FontSelectOn         = FontSelectObj[3];
  
	Fonts.sort();
	var FontSelectDropDown = new Array;
//	FontSelectDropDown[n] = '<table border="0" cellpadding="0" cellspacing="0" style="width: 145px;"><tr><td onMouseOver="document.getElementById(\'selectFont' + n + '\').src=\'' + FontSelectOn + '\';" onMouseOut="document.getElementById(\'selectFont' + n + '\').src=\'' + FontSelect + '\';"><img src="' + FontSelect + '" id="selectFont' + n + '" width="85" height="20" onClick="showFonts(\'' + n + '\');" unselectable="on"><br>';
//	FontSelectDropDown[n] += '<span id="Fonts' + n + '" class="dropdown" style="width: 145px;">';
	FontSelectDropDown[n] = '<span onMouseOver="document.getElementById(\'selectFont' + n + '\').src=\'' + FontSelectOn + '\';" onMouseOut="document.getElementById(\'selectFont' + n + '\').src=\'' + FontSelect + '\';"><img src="' + FontSelect + '" id="selectFont' + n + '" width="85" height="20" onClick="showFonts(\'' + n + '\');" unselectable="on"><br>';
	FontSelectDropDown[n] += '<span id="Fonts' + n + '" class="dropdown" style="width: 145px;">';

	for (var i = 0; i <= Fonts.length;) {
	  if (Fonts[i]) {
      FontSelectDropDown[n] += '<button type="button" onClick="formatText(\'FontName\',\'' + n + '\',\'' + Fonts[i] + '\')\; hideFonts(\'' + n + '\');" onMouseOver="this.className=\'mouseOver\'" onMouseOut="this.className=\'mouseOut\'" class="mouseOut" style="width: 120px;"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="left" style="font-family:' + Fonts[i] + '; font-size: 12px;">' + Fonts[i] + '</td></tr></table></button><br>';	
    }	  
	  i++;
  }
	FontSelectDropDown[n] += '</span></span>';
	document.getElementById('FontSelect' + n).insertAdjacentHTML("afterBegin", FontSelectDropDown[n]);
};



/* ---------------------------------------------------------------------- *\
  Function    : outputFontSizes()
  Description : creates the Font Sizes drop down and inserts it into 
	              the toolbar
  Usage       : outputFontSelect(n)
  Arguments   : n   - The editor identifier that the Font Sizes will update
	                    when making font changes (the textarea's ID)
\* ---------------------------------------------------------------------- */
function outputFontSizes(n) {

  var FontSizeObj        = ToolbarList['selectsize'];
  var FontSize           = FontSizeObj[2];
  var FontSizeOn         = FontSizeObj[3];

	FontSizes.sort();
	var FontSizesDropDown = new Array;
//	FontSizesDropDown[n] = '<table border="0" cellpadding="0" cellspacing="0"><tr><td onMouseOver="document.getElementById(\'selectSize' + n + '\').src=\'' + FontSizeOn + '\';" onMouseOut="document.getElementById(\'selectSize' + n + '\').src=\'' + FontSize + '\';"><img src="' + FontSize + '" id="selectSize' + n + '" width="49" height="20" onClick="showFontSizes(\'' + n + '\');" unselectable="on"><br>';
//  FontSizesDropDown[n] += '<span id="Sizes' + n + '" class="dropdown" style="width: 170px;">';
	FontSizesDropDown[n] = '<span onMouseOver="document.getElementById(\'selectSize' + n + '\').src=\'' + FontSizeOn + '\';" onMouseOut="document.getElementById(\'selectSize' + n + '\').src=\'' + FontSize + '\';"><img src="' + FontSize + '" id="selectSize' + n + '" width="49" height="20" onClick="showFontSizes(\'' + n + '\');" unselectable="on"><br>';
  FontSizesDropDown[n] += '<span id="Sizes' + n + '" class="dropdown" style="width: 170px;">';

	for (var i = 0; i <= FontSizes.length;) {
	  if (FontSizes[i]) {
      FontSizesDropDown[n] += '<button type="button" onClick="formatText(\'FontSize\',\'' + n + '\',\'' + FontSizes[i] + '\')\;hideFontSizes(\'' + n + '\');" onMouseOver="this.className=\'mouseOver\'" onMouseOut="this.className=\'mouseOut\'" class="mouseOut" style="width: 145px;"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="left" style="font-family: arial, verdana, helvetica;"><span style="font-size:' + (80+parseInt(FontSizes[i])*10) + '%">size ' + FontSizes[i] + '</span></td></tr></table></button><br>';	
    }	  
	  i++;
  }
//	FontSizesDropDown[n] += '</span></td></tr></table>';
	FontSizesDropDown[n] += '</span></span>';
	document.getElementById('FontSizes' + n).insertAdjacentHTML("afterBegin", FontSizesDropDown[n]);
};



/* ---------------------------------------------------------------------- *\
  Function    : hideFonts()
  Description : Hides the list of font names in the font select drop down
  Usage       : hideFonts(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function hideFonts(n) {
  document.getElementById('Fonts' + n).style.display = 'none'; 
};



/* ---------------------------------------------------------------------- *\
  Function    : hideFontSizes()
  Description : Hides the list of font sizes in the font sizes drop down
  Usage       : hideFontSizes(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function hideFontSizes(n) {
  document.getElementById('Sizes' + n).style.display = 'none'; 
};



/* ---------------------------------------------------------------------- *\
  Function    : showFonts()
  Description : Shows the list of font names in the font select drop down
  Usage       : showFonts(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function showFonts(n) { 
  if (document.getElementById('Fonts' + n).style.display == 'block') {
    document.getElementById('Fonts' + n).style.display = 'none';
	}
  else {
    document.getElementById('Fonts' + n).style.display = 'block'; 
    document.getElementById('Fonts' + n).style.position = 'absolute';		
  }
};



/* ---------------------------------------------------------------------- *\
  Function    : showFontSizes()
  Description : Shows the list of font sizes in the font sizes drop down
  Usage       : showFonts(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function showFontSizes(n) { 
  if (document.getElementById('Sizes' + n).style.display == 'block') {
    document.getElementById('Sizes' + n).style.display = 'none';
	}
  else {
    document.getElementById('Sizes' + n).style.display = 'block'; 
    document.getElementById('Sizes' + n).style.position = 'absolute';		
  }
};



/* ---------------------------------------------------------------------- *\
  Function    : viewSource()
  Description : Shows the HTML source code generated by the WYSIWYG editor
  Usage       : showFonts(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function viewSource(n) {
  var getDocument = document.getElementById("wysiwyg" + n).contentWindow.document;
  var browserName = navigator.appName;
	
	// View Source for IE 	 
  if (browserName == "Microsoft Internet Explorer") {
    var iHTML = getDocument.body.innerHTML;
    getDocument.body.innerText = iHTML;
	}
 
  // View Source for Mozilla/Netscape
  else {
    var html = document.createTextNode(getDocument.body.innerHTML);
    getDocument.body.innerHTML = "";
    getDocument.body.appendChild(html);
	}
  
	// Hide the HTML Mode button and show the Text Mode button
  document.getElementById('HTMLMode' + n).style.display = 'none'; 
	document.getElementById('textMode' + n).style.display = 'block';
	
	// set the font values for displaying HTML source
	getDocument.body.style.fontSize = "12px";
	getDocument.body.style.fontFamily = "Courier New"; 
	
  viewTextMode = 1;
};



/* ---------------------------------------------------------------------- *\
  Function    : viewSource()
  Description : Shows the HTML source code generated by the WYSIWYG editor
  Usage       : showFonts(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function viewText(n) { 
  var getDocument = document.getElementById("wysiwyg" + n).contentWindow.document;
  var browserName = navigator.appName;
	
	// View Text for IE 	  	 
  if (browserName == "Microsoft Internet Explorer") {
    var iText = getDocument.body.innerText;
    getDocument.body.innerHTML = iText;
	}
  
	// View Text for Mozilla/Netscape
  else {
    var html = getDocument.body.ownerDocument.createRange();
    html.selectNodeContents(getDocument.body);
    getDocument.body.innerHTML = html.toString();
	}
  
	// Hide the Text Mode button and show the HTML Mode button
  document.getElementById('textMode' + n).style.display = 'none'; 
	document.getElementById('HTMLMode' + n).style.display = 'block';
	
	// reset the font values
  getDocument.body.style.fontSize = "";
	getDocument.body.style.fontFamily = ""; 
	viewTextMode = 0;
};



/* ---------------------------------------------------------------------- *\
  Function    : updateTextArea()
  Description : Updates the text area value with the HTML source of the WYSIWYG
  Usage       : updateTextArea(n)
  Arguments   : n   - The editor identifier (the textarea's ID)
\* ---------------------------------------------------------------------- */
function updateTextArea(n) {
  document.getElementById(n).value = document.getElementById("wysiwyg" + n).contentWindow.document.body.innerHTML;
};


// イベントリスナー登録
function addListener(elem, eventType, func, cap) {
    if(elem.addEventListener) {
        elem.addEventListener(eventType, func, cap);
    } else if(elem.attachEvent) {
        elem.attachEvent('on' + eventType, func);
    } else {
        alert('ご利用のブラウザーはサポートされていません。');
        return false;
    }
}